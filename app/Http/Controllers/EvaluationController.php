<?php

namespace App\Http\Controllers;

use App\Models\ExpertEvaluation;
use App\Models\DesignerEvaluation;
use App\Mail\NewEvaluationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EvaluationController extends Controller
{
    public function showExpert()
    {
        return view('pages.expert-survey');
    }

    public function storeExpert(Request $request)
    {
        $data = $request->validate([
            'evaluator_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        for ($i = 1; $i <= 8; $i++) $data["q1_$i"] = $request->input("q1_$i");
        for ($i = 9; $i <= 14; $i++) $data["q2_$i"] = $request->input("q2_$i");
        for ($i = 15; $i <= 17; $i++) $data["q3_$i"] = $request->input("q3_$i");
        for ($i = 18; $i <= 27; $i++) $data["q4_$i"] = $request->input("q4_$i");

        $evaluation = ExpertEvaluation::create($data);

        $this->notifyAdmin('expert', $evaluation);

        return redirect()->route('evaluation.thank-you')->with('success', 'تم إرسال تقييم لجنة التحكيم بنجاح. شكراً لتعاونكم.');
    }

    public function showDesigner()
    {
        return view('pages.designer-survey');
    }

    public function storeDesigner(Request $request)
    {
        $data = $request->validate([
            'designer_name' => 'nullable|string|max:255',
            'factory_name' => 'nullable|string|max:255',
        ]);

        for ($i = 1; $i <= 13; $i++) {
            $data["f2_$i"] = $request->input("f2_$i");
        }

        $evaluation = DesignerEvaluation::create($data);

        $this->notifyAdmin('designer', $evaluation);

        return redirect()->route('evaluation.thank-you')->with('success', 'تم إرسال تقييم المصمم بنجاح. شكراً لتعاونكم.');
    }

    public function thankYou()
    {
        return view('pages.evaluation-thank-you');
    }

    private function notifyAdmin($type, $model)
    {
        $adminEmail = env('ADMIN_NOTIFICATION_EMAIL', config('mail.from.address', 'admin@rawnaq.local'));
        if ($adminEmail) {
            try {
                Mail::to($adminEmail)->send(new NewEvaluationNotification($type, $model));
            } catch (\Exception $e) {
                \Log::error('Failed to send evaluation notification email: ' . $e->getMessage());
            }
        }
    }
}
