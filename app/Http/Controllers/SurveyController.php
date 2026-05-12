<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\SurveyResponse;
use App\Models\UsageSession;
use App\Http\Requests\StoreSurveyRequest;
use App\Services\GoogleSheetsService;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function show()
    {
        return view('pages.survey');
    }

    public function store(StoreSurveyRequest $request)
    {
        $participant = Participant::findOrFail(session('participant_id'));

        $response = SurveyResponse::create([
            'participant_id'   => $participant->id,
            'participant_code' => $participant->code,
            'participant_name' => $participant->name,
            'fabric_chosen'    => session('fabric_chosen'),
            'pattern_chosen'   => session('pattern_chosen'),
            'patterns_chosen'  => session('patterns_chosen'),
            ...$request->validated(),
            'language_used'    => session('lang', 'ar'),
            'device_type'      => substr($request->userAgent(), 0, 50),
        ]);

        $participant->update(['status' => 'completed', 'completed_at' => now()]);

        // تحديث usage session
        UsageSession::where('participant_id', $participant->id)
                    ->update(['survey_completed' => true]);

        // مزامنة Google Sheets (يفشل بصمت)
        try {
            app(GoogleSheetsService::class)->appendResponse($response);
        } catch (\Exception $e) {
            \Log::error('Google Sheets sync failed: ' . $e->getMessage());
        }

        return redirect()->route('thank-you');
    }

    public function thankYou()
    {
        return view('pages.thank-you');
    }

    public function saveDesignChoice(Request $request)
    {
        $request->validate([
            'fabric'    => 'required|string|max:50',
            'patterns'  => 'nullable|string',
            'preview'   => 'nullable|string',
            'blendMode' => 'nullable|string|max:50',
            'opacity'   => 'nullable|numeric|min:0|max:1',
        ]);

        // Extract all pattern IDs from the Fabric.js JSON for survey records
        $canvasJson = json_decode($request->input('patterns'), true);
        $patternIds = [];
        if (isset($canvasJson['objects'])) {
            foreach ($canvasJson['objects'] as $obj) {
                if (isset($obj['patternId'])) {
                    $patternIds[] = $obj['patternId'];
                }
            }
        }

        session([
            'fabric_chosen'    => $request->fabric,
            'pattern_chosen'   => $patternIds[0] ?? null,
            'patterns_chosen'  => json_encode($patternIds),
            'blend_mode_chosen'=> $request->blendMode ?? 'multiply',
            'opacity_chosen'   => $request->opacity   ?? 0.8,
            'design_preview'   => $request->preview,
            'design_canvas'    => $request->patterns,
        ]);

        // تحديث usage session
        UsageSession::where('participant_id', session('participant_id'))
                    ->update(['design_tool_used' => true]);

        return response()->json(['success' => true]);
    }
}
