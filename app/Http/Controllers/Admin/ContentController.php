<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EducationalPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ContentController extends Controller
{
    public function show(string $slug)
    {
        $page = EducationalPage::where('slug', $slug)->firstOrFail();

        return view('admin.content.edit', compact('page'));
    }

    public function update(Request $request, string $slug)
    {
        $page = EducationalPage::where('slug', $slug)->firstOrFail();

        $request->validate([
            'title_ar'   => 'required|string|max:255',
            'title_en'   => 'required|string|max:255',
            'intro_ar'   => 'required|string',
            'intro_en'   => 'required|string',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        $data = $request->only(['title_ar', 'title_en', 'intro_ar', 'intro_en']);

        // Handle hero image upload
        if ($request->hasFile('hero_image')) {
            $heroDir = public_path('images/content');
            if (!File::isDirectory($heroDir)) {
                File::makeDirectory($heroDir, 0755, true);
            }

            $heroFile = $request->file('hero_image');
            $heroName = $slug . '-hero.' . $heroFile->getClientOriginalExtension();
            $heroFile->move($heroDir, $heroName);
            $data['hero_image'] = "/images/content/{$heroName}";
        }

        // Process sections
        $sections = [];
        if ($request->has('sections')) {
            foreach ($request->input('sections', []) as $section) {
                if (empty($section['title_ar']) && empty($section['title_en'])) continue;

                $sections[] = [
                    'anchor_id' => $section['anchor_id'] ?? '',
                    'title_ar'  => $section['title_ar'] ?? '',
                    'title_en'  => $section['title_en'] ?? '',
                    'body_ar'   => $section['body_ar']  ?? '',
                    'body_en'   => $section['body_en']  ?? '',
                    'image_url' => $section['image_url'] ?? null,
                ];
            }
        }
        $data['sections'] = $sections;

        $page->update($data);

        return back()->with('success', 'تم تحديث المحتوى بنجاح');
    }
}
