@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <h3 class="mb-4">Daftar Penilaian</h3>

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <form action="" method="POST">
                        @csrf
                        @method('POST')

                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pegawai</th>
                                    @foreach ($criterias as $criteria)
                                        <th>{{ $criteria->name }}</th>
                                    @endforeach
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $employee->fullname }}</td>
                                        @foreach ($criterias as $criteria)
                                            <td>
                                                <select name="scores[{{ $employee->id }}][{{ $criteria->id }}]" id="" required>
                                                    <option value="">Pilih</option>
                                                    @foreach ($criteria->subCriterias as $subCriteria)
                                                        <option value="{{ $subCriteria->id }}">{{ $subCriteria->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        @endforeach
                                        <td>
                                            <button type="submit" name="save" value="{{ $employee->id }}" class="btn btn-primary">Simpan</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection 