<?php

namespace App\Http\Controllers\Assessment;

use App\Http\Controllers\Controller;
use App\Models\Criteria;
use App\Models\Employee;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        $criterias = Criteria::with('subCriterias')->get();

        return view('pages.assessments.index', compact('employees', 'criterias'));
    }
}
