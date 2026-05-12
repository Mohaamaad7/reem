<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SavedDesign;

class SavedDesignController extends Controller
{
    public function index(Request $request)
    {
        $designs = SavedDesign::where('participant_id', session('participant_id'))
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($designs);
    }

    public function store(Request $request)
    {
        $request->validate([
            'canvas_json' => 'required',
            'preview_image' => 'required',
        ]);

        $design = SavedDesign::create([
            'participant_id' => session('participant_id'),
            'fabric_id' => $request->fabric_id,
            'blend_mode' => $request->blend_mode ?? 'multiply',
            'opacity' => $request->opacity ?? 0.80,
            'patterns_used' => json_decode($request->patterns_used, true),
            'canvas_json' => $request->canvas_json,
            'preview_image' => $request->preview_image,
        ]);

        return response()->json([
            'success' => true,
            'id' => $design->id
        ]);
    }

    public function destroy($id)
    {
        $design = SavedDesign::where('id', $id)
            ->where('participant_id', session('participant_id'))
            ->firstOrFail();

        $design->delete();

        return response()->json(['success' => true]);
    }
}
