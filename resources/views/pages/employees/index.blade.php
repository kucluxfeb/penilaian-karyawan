@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <h3 class="mb-4">Daftar Karyawan</h3>

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    @if (auth()->user()->role === 'Admin')
                    <a href="{{ route('create.employee') }}" class="btn btn-primary mb-3">Tambah Karyawan</a>
                    @endif
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Nama Lengkap</th>
                                <th>Divisi</th>
                                <th>NIP</th>
                                <th>Jenis Kelamin</th>
                                <th>Tempat Lahir</th>
                                <th>Tanggal Lahir</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($employee->photo)
                                        <img src="{{ asset('storage/' . $employee->photo) }}" alt="{{ $employee->fullname }}" width="100">
                                    @else
                                        <p>Tidak ada foto</p>
                                    @endif
                                    </td>
                                    <td>{{ $employee->fullname }}</td>
                                    <td>{{ $employee->division->name }}</td>
                                    <td>{{ $employee->nip }}</td>
                                    <td>{{ $employee->gender }}</td>
                                    <td>{{ $employee->birth_place }}</td>
                                    <td>{{ \Carbon\Carbon::parse($employee->birth_date)->format('d-m-Y') }}</td>
                                    <td>{{ $employee->address }}</td>
                                    @if (auth()->user()->role === 'Admin')
                                    <td>
                                        <div class="d-flex">
                                            <form id="deleteForm{{ $employee->id }}" action="{{ route('destroy.employee', $employee->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <button type="button" onclick="confirmDelete({{ $employee->id }})" class="btn btn-danger btn-sm mr-2">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>

                                            <a href="{{ route('edit.employee', $employee->id) }}" class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection