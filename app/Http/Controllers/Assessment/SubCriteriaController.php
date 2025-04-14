<?php

namespace App\Http\Controllers\Assessment;

use App\Http\Controllers\Controller;
use App\Models\Criteria;
use App\Models\SubCriterias;
use Illuminate\Http\Request;

class SubCriteriaController extends Controller
{
    public function index(Criteria $criteria)
    {
        $subCriterias = $criteria->subCriterias;

        return view('pages.sub_criterias.index', compact('subCriterias', 'criteria'));
    }

    public function create(Criteria $criteria)
    {
        return view('pages.sub_criterias.create', compact('criteria'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'criteria_id' => 'required|exists:criterias,id',
            'name' => 'required',
            'weight' => 'required',
        ], [
            'name.required' => "Nama sub divisi tidak boleh kosong!",
            'weight.required' => "Bobot tidak boleh kosong!",
        ]);

        SubCriterias::create($data);

        return redirect()->route('index.subCriterias', $request->criteria_id)->with('success', 'Sub kriteria berhasil ditambahkan!');
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
