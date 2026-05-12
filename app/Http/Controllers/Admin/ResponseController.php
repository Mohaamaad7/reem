<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SurveyResponse;

class ResponseController extends Controller
{
    public function index()
    {
        $responses = SurveyResponse::with('participant')->latest()->get();

        // حساب المتوسطات
        $averages = [
            'tool_ease'     => round($responses->avg('tool_ease_rating'), 1),
            'tool_visual'   => round($responses->avg('tool_visual_rating'), 1),
            'morris_before' => round($responses->avg('morris_knowledge_before'), 1),
            'morris_after'  => round($responses->avg('morris_knowledge_after'), 1),
            'technique'     => round($responses->avg('technique_clarity'), 1),
            'eco_awareness' => round($responses->avg('eco_fabric_awareness'), 1),
            'overall'       => round($responses->avg('app_overall_rating'), 1),
        ];

        return view('admin.responses.index', compact('responses', 'averages'));
    }

    public function export()
    {
        $responses = SurveyResponse::with('participant')->latest()->get();

        $headers = [
            'Content-Type'        => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="rawnaq-responses.csv"',
        ];

        return response()->streamDownload(function () use ($responses) {
            $out = fopen('php://output', 'w');
            // BOM لدعم Excel مع Unicode
            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($out, [
                'ID', 'التاريخ', 'كود المشارك', 'اسم المشارك',
                'القماش المختار', 'النقشة المختارة',
                'سهولة الأداة', 'جودة المعاينة',
                'معرفة موريس قبل', 'معرفة موريس بعد',
                'وضوح النقشة الزائدة', 'الوعي بالأقمشة',
                'التقييم العام', 'مدى الفائدة', 'التوصية',
                'أكثر ما أعجبها', 'اقتراحات التطوير', 'أفكار تصميمية',
                'اللغة', 'الوقت (ثانية)', 'نوع الجهاز',
            ]);

            foreach ($responses as $r) {
                fputcsv($out, [
                    $r->id,
                    $r->created_at->format('Y-m-d H:i'),
                    $r->participant_code,
                    $r->participant_name,
                    $r->fabric_chosen,
                    $r->pattern_chosen,
                    $r->tool_ease_rating,
                    $r->tool_visual_rating,
                    $r->morris_knowledge_before,
                    $r->morris_knowledge_after,
                    $r->technique_clarity,
                    $r->eco_fabric_awareness,
                    $r->app_overall_rating,
                    $r->app_usefulness,
                    $r->would_recommend,
                    $r->most_liked,
                    $r->improvement_suggestions,
                    $r->design_ideas,
                    $r->language_used,
                    $r->time_spent_seconds,
                    $r->device_type,
                ]);
            }

            fclose($out);
        }, 'rawnaq-responses.csv', $headers);
    }
}
