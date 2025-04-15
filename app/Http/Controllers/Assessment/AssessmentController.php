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
        $period = "$year-$month-01"; // Format: YYYY-MM

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
    // Ambil semua tahun unik dari data assessment
    $years = Assessment::selectRaw('YEAR(period) as year')
        ->distinct()
        ->orderByDesc('year')
        ->pluck('year');

    $filterBy = $request->input('filter_by', 'bulanan'); // default bulanan
    $year = $request->input('year', now()->year);
    $month = $request->input('month', now()->format('m'));
    $semester = $request->input('semester');

    $query = Assessment::with(['employee', 'assessmentDetails.subCriteria.criteria']);

    if ($filterBy === 'bulanan') {
        $query->whereYear('period', $year)
              ->whereMonth('period', $month);
    } elseif ($filterBy === 'tahunan') {
        $query->whereYear('period', $year);
    } elseif ($filterBy === 'semester') {
        $query->whereYear('period', $year);
        if ($semester == 1) {
            $query->whereMonth('period', '>=', 1)->whereMonth('period', '<=', 6);
        } else {
            $query->whereMonth('period', '>=', 7)->whereMonth('period', '<=', 12);
        }
    }

    $assessments = $query->get();

    return view('pages.assessments.result', [
        'assessments' => $assessments,
        'filter_by' => $filterBy,
        'year' => $year,
        'month' => $month,
        'semester' => $semester,
        'years' => $years,
    ]);
}
    
public function export($format, Request $request)
{
    $filterBy = $request->input('filter_by', 'bulanan');
    $year = $request->input('year', now()->year);
    $month = $request->input('month', now()->format('m'));
    $semester = $request->input('semester');

    $query = Assessment::with(['employee', 'assessmentDetails.subCriteria', 'assessmentDetails.subCriteria.criteria']);

    if ($filterBy === 'bulanan') {
        $query->whereYear('period', $year)
              ->whereMonth('period', $month);
    } elseif ($filterBy === 'tahunan') {
        $query->whereYear('period', $year);
    } elseif ($filterBy === 'semester') {
        $query->whereYear('period', $year);
        if ($semester == 1) {
            $query->whereMonth('period', '>=', 1)->whereMonth('period', '<=', 6);
        } else {
            $query->whereMonth('period', '>=', 7)->whereMonth('period', '<=', 12);
        }
    }

    $data = $query->get();

    if ($format === 'excel') {
        return Excel::download(new AssessmentExport($data, $filterBy, $year, $month, $semester), 'hasil_penilaian.xlsx');
    } elseif ($format === 'pdf') {
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('pages.assessments.export-pdf', [
            'data' => $data,
            'filter_by' => $filterBy,
            'year' => $year,
            'month' => $month,
            'semester' => $semester,
        ]);

        return $pdf->download('hasil_penilaian.pdf');
    }

    return back()->with('error', 'Format tidak valid!');
}
}