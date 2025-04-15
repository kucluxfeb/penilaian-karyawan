<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'Karyawan') {
            $employee = Employee::where('user_id', auth()->id())->with('division')->first();

            if (!$employee) {
                return redirect()->route('dashboard.admin')->with('error', 'Karyawan tidak ditemukan! Tunggu admin menambahkan data anda.');
            }

            return view('pages.employees.show', compact('employee'));
        }

        $employees = Employee::with('division')->get();

        return view('pages.employees.index', compact('employees'));
    }

    public function create()
    {
        $divisions = Division::all();

        // Ambil user yang belum punya relasi employee dan role-nya Karyawan
        $users = User::where('role', 'Karyawan')
            ->doesntHave('employee')
            ->get();

        $employee = null;

        return view('pages.employees.create', compact('divisions', 'users', 'employee'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'fullname' => 'required',
            'user_id' => 'required|exists:users,id|unique:employees,user_id',
            'division_id' => 'required',
            'nip' => 'required',
            'gender' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required|date|before_or_equal:today',
            'address' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'fullname.required' => "Nama lengkap tidak boleh kosong!",
            'user_id.required' => "User wajib dipilih!",
            'user_id.exists' => "User tidak valid!",
            'user_id.unique' => "User ini sudah memiliki data karyawan!",
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

        $users = User::where('role', 'Karyawan')
            ->doesntHave('employee')
            ->get();

        return view('pages.employees.edit', compact('employee', 'divisions', 'users'));
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $data = $request->validate([
            'fullname' => 'required',
            'user_id' => [
                'required',
                'exists:users,id',
                Rule::unique('employees', 'user_id')->ignore($employee->id),
            ],
            'division_id' => 'required',
            'nip' => 'required',
            'gender' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required|date|before_or_equal:today',
            'address' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'fullname.required' => "Nama lengkap tidak boleh kosong!",
            'user_id.required' => "User wajib dipilih!",
            'user_id.exists' => "User tidak valid!",
            'user_id.unique' => "User ini sudah memiliki data karyawan!",
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
