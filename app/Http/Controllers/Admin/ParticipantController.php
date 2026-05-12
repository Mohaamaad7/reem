<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use App\Http\Requests\StoreParticipantRequest;

class ParticipantController extends Controller
{
    public function index()
    {
        $filter = request('filter', 'all');

        $query = Participant::with('usageSession')->latest();

        if ($filter === 'completed') {
            $query->where('status', 'completed');
        } elseif ($filter === 'not_completed') {
            $query->whereIn('status', ['pending', 'in_progress']);
        }

        $participants = $query->get();

        return view('admin.participants.index', compact('participants', 'filter'));
    }

    public function store(StoreParticipantRequest $request)
    {
        $code = Participant::generateUniqueCode();
        Participant::create(['name' => $request->name, 'code' => $code]);

        return back()->with([
            'success'        => true,
            'generated_code' => $code,
        ]);
    }

    public function destroy(Participant $participant)
    {
        $participant->delete();
        return back()->with('success', 'تم حذف المشارك بنجاح');
    }
}
