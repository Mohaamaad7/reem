<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use App\Models\SavedDesign;
use App\Models\SurveyResponse;
use Illuminate\Support\Facades\File;

class DashboardController extends Controller
{
    public function index()
    {
        // Count patterns in working dir, fallback to root
        $patternsWorkingDir = public_path('images/patterns/working');
        $patternsRootDir    = public_path('images/patterns');
        $patternCount = 0;

        if (File::isDirectory($patternsWorkingDir)) {
            $patternCount += count(File::files($patternsWorkingDir));
        }
        if (File::isDirectory($patternsRootDir)) {
            foreach (File::files($patternsRootDir) as $f) {
                $ext = strtolower($f->getExtension());
                if (in_array($ext, ['png', 'jpg', 'jpeg', 'webp', 'svg'])) {
                    $patternCount++;
                }
            }
        }

        $stats = [
            'participants' => Participant::count(),
            'designs'      => SavedDesign::count(),
            'responses'    => SurveyResponse::count(),
            'patterns'     => $patternCount,
        ];

        $recentDesigns = SavedDesign::with('participant')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentDesigns'));
    }
}
