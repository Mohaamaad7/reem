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
}
