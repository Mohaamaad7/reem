<?php

namespace Tests\Feature;

use App\Models\ExpertEvaluation;
use App\Models\DesignerEvaluation;
use App\Mail\NewEvaluationNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class EvaluationTest extends TestCase
{
    use RefreshDatabase;

    public function test_expert_can_submit_evaluation_and_email_is_sent()
    {
        Mail::fake();

        $data = [
            'evaluator_name' => 'Dr. Ahmed',
            'notes' => 'Great app.',
        ];

        for ($i = 1; $i <= 8; $i++) $data["q1_$i"] = 3;
        for ($i = 9; $i <= 14; $i++) $data["q2_$i"] = 3;
        for ($i = 15; $i <= 17; $i++) $data["q3_$i"] = 3;
        for ($i = 18; $i <= 27; $i++) $data["q4_$i"] = 3;

        $response = $this->post(route('expert.survey.post'), $data);

        $response->assertRedirect(route('evaluation.thank-you'));
        $this->assertDatabaseHas('expert_evaluations', ['evaluator_name' => 'Dr. Ahmed']);

        Mail::assertSent(NewEvaluationNotification::class, function ($mail) {
            return $mail->type === 'expert';
        });
    }

    public function test_designer_can_submit_evaluation_and_email_is_sent()
    {
        Mail::fake();

        $data = [
            'designer_name' => 'Sara Ali',
            'factory_name' => 'Al-Nasij',
        ];

        for ($i = 1; $i <= 13; $i++) $data["f2_$i"] = 5;

        $response = $this->post(route('designer.survey.post'), $data);

        $response->assertRedirect(route('evaluation.thank-you'));
        $this->assertDatabaseHas('designer_evaluations', ['designer_name' => 'Sara Ali']);

        Mail::assertSent(NewEvaluationNotification::class, function ($mail) {
            return $mail->type === 'designer';
        });
    }
}
