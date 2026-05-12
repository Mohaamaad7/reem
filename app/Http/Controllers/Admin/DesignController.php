<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SavedDesign;

class DesignController extends Controller
{
    public function index()
    {
        $designs = SavedDesign::with('participant')
            ->latest()
            ->paginate(24);

        return view('admin.designs.index', compact('designs'));
    }
}
