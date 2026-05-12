<?php

namespace App\Http\Controllers;

use App\Models\EducationalPage;
use App\Models\UsageSession;
use Illuminate\Support\Facades\File;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }

    public function morris()
    {
        $this->trackPageVisit('morris');
        $page = EducationalPage::where('slug', 'morris')->firstOrFail();
        return view('pages.morris', compact('page'));
    }

    public function fabrics()
    {
        $this->trackPageVisit('fabrics');
        $page = EducationalPage::where('slug', 'fabrics')->firstOrFail();
        return view('pages.fabrics', compact('page'));
    }

    public function technique()
    {
        $this->trackPageVisit('technique');
        return view('pages.technique');
    }

    public function designTool()
    {
        $this->trackPageVisit('design-tool');
        return view('pages.design-tool');
    }

    /**
     * GET /api/patterns
     * Scans public/images/patterns/ and returns JSON asset list.
     */
    public function apiPatterns()
    {
        return response()->json($this->scanAssets('patterns'));
    }

    /**
     * GET /api/fabrics
     * Scans public/images/fabrics/ and returns JSON asset list.
     */
    public function apiFabrics()
    {
        return response()->json($this->scanAssets('fabrics'));
    }

    /**
     * Scans public/images/{type}/ for supported image files.
     * Scans subdirectories of working/ as categories.
     * Returns [{ id, url, thumb_url, working_url, category }] sorted by filename.
     */
    private function scanAssets(string $type): array
    {
        $extensions = ['png', 'jpg', 'jpeg', 'webp', 'svg'];
        $assets = [];

        $workingDir = public_path("images/{$type}/working");
        $thumbDir   = public_path("images/{$type}/thumbs");

        // Scan subdirectories of working/ as categories (e.g. birds, floral)
        if (File::isDirectory($workingDir)) {
            foreach (File::directories($workingDir) as $categoryDir) {
                $category = basename($categoryDir);

                foreach (File::files($categoryDir) as $file) {
                    $ext = strtolower($file->getExtension());
                    if (!in_array($ext, $extensions)) continue;

                    $filename = $file->getFilename();
                    $id = pathinfo($filename, PATHINFO_FILENAME);
                    $thumbFile = "{$thumbDir}/{$id}.webp";

                    $thumbUrl = File::exists($thumbFile)
                        ? "/images/{$type}/thumbs/{$id}.webp"
                        : "/images/{$type}/working/{$category}/{$filename}";

                    $assets[$id] = [
                        'id'          => $id,
                        'url'         => "/images/{$type}/working/{$category}/{$filename}",
                        'thumb_url'   => $thumbUrl,
                        'working_url' => "/images/{$type}/working/{$category}/{$filename}",
                        'category'    => $category,
                    ];
                }
            }

            // Scan files directly in working/ (no category)
            foreach (File::files($workingDir) as $file) {
                $ext = strtolower($file->getExtension());
                if (!in_array($ext, $extensions)) continue;

                $filename = $file->getFilename();
                $id = pathinfo($filename, PATHINFO_FILENAME);

                if (isset($assets[$id])) continue;

                $thumbFile = "{$thumbDir}/{$id}.webp";

                $thumbUrl = File::exists($thumbFile)
                    ? "/images/{$type}/thumbs/{$id}.webp"
                    : "/images/{$type}/working/{$filename}";

                $assets[$id] = [
                    'id'          => $id,
                    'url'         => "/images/{$type}/working/{$filename}",
                    'thumb_url'   => $thumbUrl,
                    'working_url' => "/images/{$type}/working/{$filename}",
                    'category'    => null,
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
                    'url'         => "/images/{$type}/{$filename}",
                    'thumb_url'   => "/images/{$type}/{$filename}",
                    'working_url' => "/images/{$type}/{$filename}",
                    'category'    => null,
                ];
            }
        }

        $result = array_values($assets);
        usort($result, fn($a, $b) => strcmp($a['id'], $b['id']));

        return $result;
    }

    private function trackPageVisit(string $page): void
    {
        $session = UsageSession::where('participant_id', session('participant_id'))->first();
        if ($session) {
            $visited = $session->pages_visited ?? [];
            if (!in_array($page, $visited)) {
                $visited[] = $page;
                $session->update(['pages_visited' => $visited]);
            }
        }
    }
}
