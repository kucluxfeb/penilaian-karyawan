<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Employee;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('division')->get();

        return view('pages.employees.index', compact('employees'));
    }

    public function create()
    {
        $divisions = Division::all();

        return view('pages.employees.create', compact('divisions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required',
            'divisionId' => 'required',
            'nip' => 'required',
            'gender' => 'required',
            'birthPlace' => 'required',
            'birthDate' => 'required|date|before_or_equal:today',
            'address' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'fullname.required' => "Nama lengkap tidak boleh kosong!",
            'divisionId.required' => "Divisi tidak boleh kosong!",
            'nip.required' => "NIP tidak boleh kosong!",
            'gender.required' => "Jenis kelamin tidak boleh kosong!",
            'birthPlace.required' => "Tempat lahir tidak boleh kosong!",
            'birthDate.required' => "Tanggal lahir tidak boleh kosong!",
            'birthDate.before_or_equal' => "Tanggal lahir tidak boleh melebihi hari ini!",
            'address.required' => "Alamat tidak boleh kosong!",
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        Employee::create([
            'fullname' => $request->input('fullname'),
            'division_id' => $request->input('divisionId'),
            'nip' => $request->input('nip'),
            'gender' => $request->input('gender'),
            'birth_place' => $request->input('birthPlace'),
            'birth_date' => $request->input('birthDate'),
            'address' => $request->input('address'),
            'photo' => $photoPath,
        ]);

        return redirect()->route('index.employees')->with('success', 'Karyawan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $divisions = Division::all();

        return view('pages.employees.edit', compact('employee', 'divisions'));
    }

    public function update(Request $request, $id)
{
    $employee = Employee::findOrFail($id);

    $data = $request->validate([
        'fullname' => 'required',
        'divisionId' => 'required',
        'nip' => 'required',
        'gender' => 'required',
        'birthPlace' => 'required',
        'birthDate' => 'required|date|before_or_equal:today',
        'address' => 'required',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ], [
        'fullname.required' => "Nama lengkap tidak boleh kosong!",
        'divisionId.required' => "Divisi tidak boleh kosong!",
        'nip.required' => "NIP tidak boleh kosong!",
        'gender.required' => "Jenis kelamin tidak boleh kosong!",
        'birthPlace.required' => "Tempat lahir tidak boleh kosong!",
        'birthDate.required' => "Tanggal lahir tidak boleh kosong!",
        'birthDate.before_or_equal' => "Tanggal lahir tidak boleh melebihi hari ini!",
        'address.required' => "Alamat tidak boleh kosong!",
    ]);

    if ($request->hasFile('photo')) {
        if ($employee->photo && \Storage::exists($employee->photo)) {
            \Storage::delete($employee->photo);
        }

        $photoPath = $request->file('photo')->store('employees', 'public');
        $data['photo'] = $photoPath;
    }

    $employee->update($data);

    return redirect()->route('index.employees')->with('success', 'Karyawan berhasil diperbarui!');
}


    public function destroy($id)
    {
        $employee = Employee::FindOrFail($id);

        if ($employee->photo && \Storage::exists($employee->photo)) {
            \Storage::delete($employee->photo);
        }

        $employee->delete();

        return redirect()->route('index.employees')->with('success', 'Karyawan berhasil dihapus!');
    }
}
