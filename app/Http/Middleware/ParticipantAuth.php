<?php

namespace App\Http\Middleware;

use App\Models\Participant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ParticipantAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('participant_id')) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'يرجى إدخال كود المشاركة أولاً'], 401);
            }
            return redirect()->route('home')
                   ->with('open_login_modal', true);
        }

        // منع المشارك الذي أكمل من إعادة التجربة
        $participant = Participant::find(session('participant_id'));
        if ($participant?->status === 'completed' && !$request->is('thank-you')) {
            return redirect()->route('thank-you');
        }

        return $next($request);
    }
}
