<?php

namespace App\Http\Controllers\Assessment;

use App\Http\Controllers\Controller;
use App\Models\Criteria;
use Illuminate\Http\Request;

class SubCriteriaController extends Controller
{
    public function index(Criteria $criteria)
    {
        $subCriterias = $criteria->subCriterias;

        return view('pages.sub_criterias.index', compact('subCriterias', 'criteria'));
    }

    public function create()
    {

    }

    public function store()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
