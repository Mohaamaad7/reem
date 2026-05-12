<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use App\Models\UsageSession;
use Illuminate\Http\Request;

class ParticipantAuthController extends Controller
{
    public function showLogin()
    {
        // إذا المشارك مسجّل دخول بالفعل، انقله للصفحة الرئيسية
        if (session()->has('participant_id')) {
            return redirect()->route('home');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate(['code' => 'required|string|max:10']);

        $participant = Participant::where('code', trim($request->code))->first();

        if (!$participant) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'كود غير صحيح، يرجى التأكد والمحاولة مجدداً'], 422);
            }
            return back()->withErrors(['code' => 'كود غير صحيح، يرجى التأكد والمحاولة مجدداً']);
        }

        if ($participant->status === 'completed') {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'تم إكمال هذه التجربة مسبقاً، شكراً لمشاركتك'], 422);
            }
            return back()->withErrors(['code' => 'تم إكمال هذه التجربة مسبقاً، شكراً لمشاركتك']);
        }

        // حفظ بيانات المشارك في الجلسة
        session([
            'participant_id'   => $participant->id,
            'participant_name' => $participant->name,
            'participant_code' => $participant->code,
            'lang'             => 'ar',
        ]);

        // تحديث حالة المشارك
        $participant->update([
            'status'     => 'in_progress',
            'started_at' => $participant->started_at ?? now(),
        ]);

        // إنشاء session للمشارك إذا لم تكن موجودة
        if (!$participant->usageSession) {
            UsageSession::create([
                'participant_id' => $participant->id,
                'pages_visited'  => [],
            ]);
        }

        if ($request->wantsJson()) {
            return response()->json(['redirect' => route('home')]);
        }

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        session()->forget(['participant_id', 'participant_name', 'participant_code']);
        return redirect()->route('home');
    }
}
