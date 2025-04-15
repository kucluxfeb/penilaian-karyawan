@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <h3 class="mb-4">Profil Saya</h3>

        <div class="card shadow">
            <div class="card-body">
                <div class="text-center mb-3">
                    @if ($employee->photo)
                        <img src="{{ $employee->photo ? asset('storage/' . $employee->photo) : asset('default-profile.jpg') }}" alt="{{ $employee->fullname }}" width="150" class="rounded-circle">
                    @else
                        <p>Foto tidak tersedia</p>
                    @endif
                </div>

                <table class="table table-bordered">
                    <tr><th>Nama Lengkap</th><td>{{ $employee->fullname }}</td></tr>
                    <tr><th>Divisi</th><td>{{ $employee->division->name }}</td></tr>
                    <tr><th>NIP</th><td>{{ $employee->nip }}</td></tr>
                    <tr><th>Jenis Kelamin</th><td>{{ $employee->gender }}</td></tr>
                    <tr><th>Tempat Lahir</th><td>{{ $employee->birth_place }}</td></tr>
                    <tr><th>Tanggal Lahir</th><td>{{ \Carbon\Carbon::parse($employee->birth_date)->format('d-m-Y') }}</td></tr>
                    <tr><th>Alamat</th><td>{{ $employee->address }}</td></tr>
                </table>

                <a href="{{ route('edit.employee', $employee->id) }}" class="btn btn-warning mt-3">
                    <i class="bi bi-pencil-square"></i> Edit Profil
                </a>
            </div>
        </div>
    </div>
@endsection