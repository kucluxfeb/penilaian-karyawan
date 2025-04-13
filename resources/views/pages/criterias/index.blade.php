@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <h3 class="mb-4">Daftar Kriteria</h3>

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <a href="{{ route('create.criteria') }}" class="btn btn-primary mb-3">Tambah Kriteria</a>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama Kriteria</th>
                                <th>Bobot</th>
                                <th>Tipe</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($criterias as $criteria)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $criteria->code }}</td>
                                    <td>{{ $criteria->name }}</td>
                                    <td>{{ $criteria->weight }}</td>
                                    <td>{{ $criteria->type }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <form id="deleteForm{{ $criteria->id }}" action="{{ route('destroy.criteria', $criteria->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <button type="button" onclick="confirmDelete({{ $criteria->id }})" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>

                                            <a href="{{ route('edit.criteria', $criteria->id) }}" class="btn btn-warning btn-sm mx-2">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <a href="{{ route('index.subCriterias', $criteria->id) }}" class="btn btn-success btn-sm">
                                                <i class="bi bi-diagram-3"></i>
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