<?php

namespace App\Exports;

use App\Models\Assessment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AssessmentExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $data = Assessment::with(['employee', 'assessmentDetails.subCriteria', 'assessmentDetails.subCriteria.criteria'])->get();

        return view('pages.assessments.export-excel', compact('data'));
    }
}
