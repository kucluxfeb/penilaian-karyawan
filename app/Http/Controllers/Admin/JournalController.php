<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Journals;
use Auth;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'Karyawan') {
            $employee = $user->employee;

            if (!$employee) {
                return redirect()->route('dashboard.admin')->with('error', 'Karyawan tidak ditemukan! Tunggu admin menambahkan data anda.');
            }

            $journals = Journals::with('employee')->where('employee_id', $employee->id)->get();
        } else {
            $journals = Journals::with('employee')->get();
        }

        return view('pages.journals.index', compact('journals'));   
    }

    public function create()
    {
        if (Auth::user()->role !== 'Karyawan') {
            abort(403, 'Akses ditolak');
        }

        return view('pages.journals.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'Karyawan') {
            abort(403, 'Akses ditolak');
        }

        $data = $request->validate([
            'date' => 'required',
            'activity' => 'required',
            'problem' => 'nullable',
            'solution' => 'nullable',
            'note' => 'nullable',
        ], [
            'date.required' => "Tanggal tidak boleh kosong!",
            'activity.required' => "Aktivitas tidak boleh kosong!",
        ]);

        $data['employee_id'] = Auth::user()->employee->id;

        Journals::create($data);

        return redirect()->route('index.journals')->with('success', 'Jurnal berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (Auth::user()->role !== 'Karyawan') {
            abort(403, 'Akses ditolak');
        }

        $journal = Journals::findOrFail($id);
        $employees = Employee::all();

        return view('pages.journals.edit', compact('journal', 'employees'));
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'Karyawan') {
            abort(403, 'Akses ditolak');
        }

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
        if (Auth::user()->role !== 'Karyawan') {
            abort(403, 'Akses ditolak');
        }
        
        $journal = Journals::FindOrFail($id);
        $journal->delete();

        return redirect()->route('index.journals')->with('success', 'Jurnal berhasil dihapus!');
    }
}
