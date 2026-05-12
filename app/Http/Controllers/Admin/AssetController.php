<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AssetController extends Controller
{
    public function fabricsIndex()
    {
        $assets = $this->getAssets('fabrics');
        $type = 'fabrics';
        $title = 'الأقمشة';

        return view('admin.assets.index', compact('assets', 'type', 'title'));
    }

    public function patternsIndex()
    {
        $assets = $this->getAssets('patterns');
        $type = 'patterns';
        $title = 'النقشات';

        return view('admin.assets.index', compact('assets', 'type', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'  => 'required|in:fabrics,patterns',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:20480',
        ]);

        $type = $request->input('type');
        $file = $request->file('image');
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $name = preg_replace('/[^a-zA-Z0-9_\-]/', '-', $name);

        // Ensure directories exist
        $dirs = [
            public_path("images/{$type}/originals"),
            public_path("images/{$type}/working"),
            public_path("images/{$type}/thumbs"),
        ];
        foreach ($dirs as $dir) {
            if (!File::isDirectory($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
        }

        try {
            ini_set('memory_limit', '256M');

            // 1. Save original as-is
            $originalExt = $file->getClientOriginalExtension();
            $file->move(public_path("images/{$type}/originals"), "{$name}.{$originalExt}");
            $originalPath = public_path("images/{$type}/originals/{$name}.{$originalExt}");

            // 2. Create working version (max 900×900, quality 85%)
            $manager = new ImageManager(Driver::class);
            $image = $manager->decodePath($originalPath);
            $image->scaleDown(900, 900);
            $image->save(public_path("images/{$type}/working/{$name}.webp"), quality: 85);

            // 3. Create thumbnail version (150×150 cover crop, quality 80%)
            $thumb = $manager->decodePath($originalPath);
            $thumb->cover(150, 150);
            $thumb->save(public_path("images/{$type}/thumbs/{$name}.webp"), quality: 80);

        } catch (\Throwable $e) {
            Log::error('Asset upload failed: ' . $e->getMessage(), [
                'type' => $type,
                'file' => $name,
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'error'   => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'success'     => true,
            'name'        => $name,
            'thumb_url'   => "/images/{$type}/thumbs/{$name}.webp",
            'working_url' => "/images/{$type}/working/{$name}.webp",
        ]);
    }

    public function destroy(string $type, string $filename)
    {
        if (!in_array($type, ['fabrics', 'patterns'])) {
            abort(404);
        }

        // Delete all versions
        $paths = [
            public_path("images/{$type}/originals"),
            public_path("images/{$type}/working"),
            public_path("images/{$type}/thumbs"),
        ];

        foreach ($paths as $dir) {
            if (File::isDirectory($dir)) {
                foreach (File::files($dir) as $file) {
                    if (pathinfo($file->getFilename(), PATHINFO_FILENAME) === $filename) {
                        File::delete($file->getPathname());
                    }
                }
            }
        }

        // Also delete from root (legacy files)
        $rootDir = public_path("images/{$type}");
        foreach (File::files($rootDir) as $file) {
            if (pathinfo($file->getFilename(), PATHINFO_FILENAME) === $filename) {
                File::delete($file->getPathname());
            }
        }

        return response()->json(['success' => true]);
    }

    private function getAssets(string $type): array
    {
        $assets = [];
        $extensions = ['png', 'jpg', 'jpeg', 'webp', 'svg'];

        // Scan working directory first
        $workingDir = public_path("images/{$type}/working");
        $thumbDir   = public_path("images/{$type}/thumbs");

        if (File::isDirectory($workingDir)) {
            foreach (File::files($workingDir) as $file) {
                $ext = strtolower($file->getExtension());
                if (!in_array($ext, $extensions)) continue;

                $filename = $file->getFilename();
                $id = pathinfo($filename, PATHINFO_FILENAME);
                $thumbFile = "{$thumbDir}/{$id}.webp";

                $assets[$id] = [
                    'id'          => $id,
                    'thumb_url'   => File::exists($thumbFile) ? "/images/{$type}/thumbs/{$id}.webp" : "/images/{$type}/working/{$filename}",
                    'working_url' => "/images/{$type}/working/{$filename}",
                ];
            }
        }

        // Scan root directory for legacy files
        $rootDir = public_path("images/{$type}");
        if (File::isDirectory($rootDir)) {
            foreach (File::files($rootDir) as $file) {
                $ext = strtolower($file->getExtension());
                if (!in_array($ext, $extensions)) continue;

                $filename = $file->getFilename();
                $id = pathinfo($filename, PATHINFO_FILENAME);

                if (isset($assets[$id])) continue;

                $assets[$id] = [
                    'id'          => $id,
                    'thumb_url'   => "/images/{$type}/{$filename}",
                    'working_url' => "/images/{$type}/{$filename}",
                ];
            }
        }

        $result = array_values($assets);
        usort($result, fn($a, $b) => strcmp($a['id'], $b['id']));

        return $result;
    }
}
