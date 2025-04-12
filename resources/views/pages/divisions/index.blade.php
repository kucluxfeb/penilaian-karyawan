@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <h3 class="mb-4">Daftar Divisi</h3>

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <a href="{{ route('create.division') }}" class="btn btn-primary mb-3">Tambah Divisi</a>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Divisi</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($divisions as $division)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $division->name }}</td>
                                    <td>{{ $division->description }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <form id="deleteForm{{ $division->id }}" action="{{ route('destroy.division', $division->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <button type="button" onclick="confirmDelete({{ $division->id }})" class="btn btn-danger btn-sm mr-2">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>

                                            <a href="{{ route('edit.division', $division->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </div>
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