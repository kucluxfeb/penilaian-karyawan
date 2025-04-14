<?php

namespace App\Http\Controllers\Assessment;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\AssessmentDetail;
use App\Models\Criteria;
use App\Models\Employee;
use App\Models\SubCriterias;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        $criterias = Criteria::with('subCriterias')->get();

        return view('pages.assessments.index', compact('employees', 'criterias'));
    }

    public function store(Request $request)
    {
        $employeeId = $request->input('save');
        // $userId = auth()->user()->id;
        $period = now()->format('Y-m');

        $scores = $request->input("scores.$employeeId");

        $assessment = Assessment::create([
            'employee_id' => $employeeId,
            'user_id' => 1,
            'period' => $period,
            'score' => 0,
        ]);

        $totalScore = 0;

        foreach ($scores as $criteriaId => $subCriteriaId) {
            $subCriteria = SubCriterias::find($subCriteriaId);
            $weight = $subCriteria->weight ?? 0;

            AssessmentDetail::create([
                'assessment_id' => $assessment->id,
                'sub_criteria_id' => $subCriteriaId,
                'value' => $weight,
            ]);

            $totalScore += $weight;
        }

        $assessment->update([
            'score' => $totalScore,
        ]);

        return back()->with('success', 'Penilaian berhasil disimpan!');
    }
}
