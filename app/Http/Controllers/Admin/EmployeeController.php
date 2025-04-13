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
        $data = $request->validate([
            'fullname' => 'required',
            'division_id' => 'required',
            'nip' => 'required',
            'gender' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required|date|before_or_equal:today',
            'address' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'fullname.required' => "Nama lengkap tidak boleh kosong!",
            'division_id.required' => "Divisi tidak boleh kosong!",
            'nip.required' => "NIP tidak boleh kosong!",
            'gender.required' => "Jenis kelamin tidak boleh kosong!",
            'birth_place.required' => "Tempat lahir tidak boleh kosong!",
            'birth_date.required' => "Tanggal lahir tidak boleh kosong!",
            'birth_date.before_or_equal' => "Tanggal lahir tidak boleh melebihi hari ini!",
            'address.required' => "Alamat tidak boleh kosong!",
            'photo.image' => "File yang diunggah harus berupa gambar!",
            'photo.mimes' => "Format foto harus jpeg, png, atau jpg!",
            'photo.max' => "Ukuran foto maksimal 2MB!",
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('employees', 'public');
        }

        Employee::create($data);

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
            'division_id' => 'required',
            'nip' => 'required',
            'gender' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required|date|before_or_equal:today',
            'address' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'fullname.required' => "Nama lengkap tidak boleh kosong!",
            'division_id.required' => "Divisi tidak boleh kosong!",
            'nip.required' => "NIP tidak boleh kosong!",
            'gender.required' => "Jenis kelamin tidak boleh kosong!",
            'birth_place.required' => "Tempat lahir tidak boleh kosong!",
            'birth_date.required' => "Tanggal lahir tidak boleh kosong!",
            'birth_date.before_or_equal' => "Tanggal lahir tidak boleh melebihi hari ini!",
            'address.required' => "Alamat tidak boleh kosong!",
            'photo.image' => "File yang diunggah harus berupa gambar!",
            'photo.mimes' => "Format foto harus jpeg, png, atau jpg!",
            'photo.max' => "Ukuran foto maksimal 2MB!",
        ]);

        if ($request->hasFile('photo')) {
            if ($employee->photo && \Storage::disk('public')->exists($employee->photo)) {
                \Storage::disk('public')->delete($employee->photo);
            }

            $data['photo'] = $request->file('photo')->store('employees', 'public');
        }

        $employee->update($data);

        return redirect()->route('index.employees')->with('success', 'Karyawan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $employee = Employee::FindOrFail($id);

        if ($employee->photo && \Storage::disk('public')->exists($employee->photo)) {
            \Storage::disk('public')->delete($employee->photo);
        }

        $employee->delete();

        return redirect()->route('index.employees')->with('success', 'Karyawan berhasil dihapus!');
    }
}
