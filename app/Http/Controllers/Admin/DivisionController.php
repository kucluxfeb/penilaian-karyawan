<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function index()
    {
        $divisions = Division::all();

        return view('pages.divisions.index', compact('divisions'));
    }

    public function create()
    {
        return view('pages.divisions.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ], [
            'name.required' => "Nama divisi tidak boleh kosong!",
        ]);

        Division::create($data);

        return redirect()->route('index.divisions')->with('success', 'Divisi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $division = Division::findOrFail($id);

        return view('pages.divisions.edit', compact('division'));
    }

    public function update(Request $request, $id)
    {
        $division = Division::findOrFail($id);

        $data = $request->validate([
            'name' => 'required',
            'description' => 'nullable'
        ], [
            'name.required' => "Nama divisi tidak boleh kosong!",
        ]);

        $division->update($data);

        return redirect()->route('index.divisions')->with('success', 'Divisi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $division = Division::FindOrFail($id);
        $division->delete();

        return redirect()->route('index.divisions')->with('success', 'Divisi berhasil dihapus!');
    }
}