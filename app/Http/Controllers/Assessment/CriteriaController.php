<?php

namespace App\Http\Controllers\Assessment;

use App\Http\Controllers\Controller;
use App\Models\Criteria;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    public function index()
    {
        $criterias = Criteria::all();

        return view('pages.criterias.index', compact('criterias'));
    }

    public function create()
    {
        $criterias = Criteria::all();

        return view('pages.criterias.create', compact('criterias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required',
            'name' => 'required',
            'weight' => 'required',
            'type' => 'required',
        ], [
            'code.required' => "Kode tidak boleh kosong!",
            'name.required' => "Nama kriteria tidak boleh kosong!",
            'weight.required' => "Bobot tidak boleh kosong!",
            'type.required' => "Tipe tidak boleh kosong!",
        ]);

        Criteria::create($data);

        return redirect()->route('index.criterias')->with('success', 'Kriteria berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $criteria = Criteria::findOrFail($id);

        return view('pages.criterias.edit', compact('criteria'));
    }

    public function update(Request $request, $id)
    {
        $criteria = Criteria::findOrFail($id);

        $data = $request->validate([
            'code' => 'required',
            'name' => 'required',
            'weight' => 'required',
            'type' => 'required',
        ], [
            'code.required' => "Kode tidak boleh kosong!",
            'name.required' => "Nama kriteria tidak boleh kosong!",
            'weight.required' => "Bobot tidak boleh kosong!",
            'type.required' => "Tipe tidak boleh kosong!",
        ]);

        $criteria->update($data);

        return redirect()->route('index.criterias')->with('success', 'Kriteria berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $criteria = Criteria::FindOrFail($id);

        $criteria->delete();

        return redirect()->route('index.criterias')->with('success', 'Kriteria berhasil dihapus!');
    }
}