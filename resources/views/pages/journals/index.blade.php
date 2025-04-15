@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <h3 class="mb-4">Daftar Jurnal</h3>

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    @auth
                    @if (auth()->user()->role === 'Karyawan')
                    <a href="{{ route('create.journal') }}" class="btn btn-primary mb-3">Tambah Jurnal</a>
                    @endif
                    @endauth
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Karyawan</th>
                                <th>Tanggal</th>
                                <th>Aktivitas</th>
                                <th>Masalah</th>
                                <th>Solusi</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($journals as $journal)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $journal->employee->fullname }}</td>
                                    <td>{{ \Carbon\Carbon::parse($journal->date)->format('d-m-Y') }}</td>
                                    <td>{{ $journal->activity }}</td>
                                    <td>{{ $journal->problem }}</td>
                                    <td>{{ $journal->solution }}</td>
                                    <td>{{ $journal->note }}</td>
                                    <td>
                                        @if (auth()->user()->role === 'Karyawan')
                                        <div class="d-flex">
                                            <form id="deleteForm{{ $journal->id }}" action="{{ route('destroy.journal', $journal->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <button type="button" onclick="confirmDelete({{ $journal->id }})" class="btn btn-danger btn-sm mr-2">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>

                                            <a href="{{ route('edit.journal', $journal->id) }}" class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                        </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection