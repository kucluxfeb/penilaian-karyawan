<?php

namespace App\Http\Controllers\Assessment;

use App\Exports\AssessmentExport;
use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\AssessmentDetail;
use App\Models\Criteria;
use App\Models\Employee;
use App\Models\SubCriterias;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $scores = $request->input("scores.$employeeId");

        // Ambil dari form
        $month = $request->input('month');
        $year = $request->input('year');
        $period = "$year-$month"; // Format: YYYY-MM

        $assessment = Assessment::create([
            'employee_id' => $employeeId,
            'user_id' => 1, // sementara default user
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

    public function result(Request $request)
    {
        $period = $request->input('period', now()->format('Y-m'));

        $assessments = Assessment::with(['employee', 'assessmentDetails.subCriteria', 'assessmentDetails.subCriteria.criteria'])
            ->where('period', $period)
            ->get();

        $periods = Assessment::select('period')->distinct()->pluck('period');

        return view('pages.assessments.result', compact('assessments', 'periods', 'period'));
    }

    public function export($format)
    {
        if ($format === 'excel') {
            return Excel::download(new AssessmentExport, 'hasil_penilaian.xlsx');
        } elseif ($format === 'pdf') {
            $data = Assessment::with(['employee', 'assessmentDetails.subCriteria', 'assessmentDetails.subCriteria.criteria'])->get();
            $pdf = app('dompdf.wrapper');
            $pdf->loadView('pages.assessments.export-pdf', compact('data'));

            return $pdf->download('hasil_penilaian.pdf');
        }

        return back()->with('error', 'Format tidak valid!');
    }
}