@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <h3 class="mb-4">Daftar Sub Kriteria {{ $criteria->name }} [{{ $criteria->type }}]</h3>

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="{{ route('index.criterias') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-left-circle"></i>
                    </a>
                    <a href="{{ route('create.subCriteria', $criteria->id) }}" class="btn btn-primary">
                        Tambah Sub Kriteria
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Bobot</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subCriterias as $subCriteria)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $subCriteria->name }}</td>
                                    <td>{{ $subCriteria->weight }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <form id="deleteForm{{ $subCriteria->id }}" action="{{ route('destroy.subCriteria', $subCriteria->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete({{ $subCriteria->id }})" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>

                                            <a href="{{ route('edit.subCriteria', $subCriteria->id) }}" class="btn btn-warning btn-sm mx-2">
                                                <i class="bi bi-pencil-square"></i>
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