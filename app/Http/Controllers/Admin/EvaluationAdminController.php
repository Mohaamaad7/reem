<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpertEvaluation;
use App\Models\DesignerEvaluation;
use Illuminate\Http\Request;

class EvaluationAdminController extends Controller
{
    public function indexExpert()
    {
        $evaluations = ExpertEvaluation::latest()->get();
        return view('admin.evaluations.expert', compact('evaluations'));
    }

    public function indexDesigner()
    {
        $evaluations = DesignerEvaluation::latest()->get();
        return view('admin.evaluations.designer', compact('evaluations'));
    }

    public function exportDesigner()
    {
        $evaluations = DesignerEvaluation::latest()->get();

        $questionLabels = [
            1 => 'وضوح أهداف التطبيق',
            2 => 'ساعدني التطبيق على التعلم بسهولة في أي وقت',
            3 => 'ساعدني التطبيق على التعلم بسهولة في أي مكان',
            4 => 'المادة العلمية منظمة بشكل منطقي',
            5 => 'يحتوي على أشكال وصور توضيحية كافية',
            6 => 'يلبي الاحتياجات الفعلية للمهتمين بالتصميم',
            7 => 'يسهم في تحسين مستوى الأداء',
            8 => 'أحد الأساليب الحديثة لتعلم التصميم',
            9 => 'استخدام الهواتف المحمولة في التعلم مشجع',
            10 => 'يساير التطور العلمي والتكنولوجي',
            11 => 'شعرت بملل أثناء الأداء',
            12 => 'وجدت صعوبة في التعامل',
            13 => 'أسلوب الدراسة شيق',
        ];

        $headers = [
            'Content-Type'        => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="designer-evaluations.csv"',
        ];

        return response()->streamDownload(function () use ($evaluations, $questionLabels) {
            $out = fopen('php://output', 'w');
            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));

            $headerRow = ['#', 'اسم المصمم', 'المصنع', 'التاريخ'];
            for ($i = 1; $i <= 13; $i++) {
                $headerRow[] = "س{$i}: " . $questionLabels[$i];
            }
            fputcsv($out, $headerRow);

            foreach ($evaluations as $eval) {
                $row = [
                    $eval->id,
                    $eval->designer_name ?: 'غير محدد',
                    $eval->factory_name ?: 'غير محدد',
                    $eval->created_at->format('Y-m-d H:i'),
                ];
                for ($i = 1; $i <= 13; $i++) {
                    $val = $eval->{"f2_$i"};
                    $row[] = $val == 1 ? 'متوفر' : 'غير متوفر';
                }
                fputcsv($out, $row);
            }

            fclose($out);
        }, 'designer-evaluations.csv', $headers);
    }
}
