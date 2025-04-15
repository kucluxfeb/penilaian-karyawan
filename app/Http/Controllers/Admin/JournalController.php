<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Journals;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function index()
    {
        $journals = Journals::with('employee')->get();

        return view('pages.journals.index', compact('journals'));   
    }

    public function create()
    {
        $employees = Employee::all();

        return view('pages.journals.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id' => 'required',
            'date' => 'required',
            'activity' => 'required',
            'problem' => 'nullable',
            'solution' => 'nullable',
            'note' => 'nullable',
        ], [
            'employee_id.required' => "Nama Karyawan tidak boleh kosong!",
            'date.required' => "Tanggal tidak boleh kosong!",
            'activity.required' => "Aktivitas tidak boleh kosong!",
        ]);

        Journals::create($data);

        return redirect()->route('index.journals')->with('success', 'Jurnal berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $journal = Journals::findOrFail($id);
        $employees = Employee::all();

        return view('pages.journals.edit', compact('journal', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $journal = Journals::findOrFail($id);

        $data = $request->validate([
            'employee_id' => 'required',
            'date' => 'required',
            'activity' => 'required',
            'problem' => 'nullable',
            'solution' => 'nullable',
            'note' => 'nullable',
        ], [
            'employee_id.required' => "Nama Karyawan tidak boleh kosong!",
            'date.required' => "Tanggal tidak boleh kosong!",
            'activity.required' => "Aktivitas tidak boleh kosong!",
        ]);

        $journal->update($data);

        return redirect()->route('index.journals')->with('success', 'Jurnal berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $journal = Journals::FindOrFail($id);
        $journal->delete();

        return redirect()->route('index.journals')->with('success', 'Jurnal berhasil dihapus!');
    }
}
