@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <h3 class="mb-4">Daftar Penilaian</h3>

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <form action="{{ route("store.assessment") }}" method="POST">
                        @csrf
                        @method('POST')

                        {{-- Pilih Bulan dan Tahun --}}
                        <div class="mb-4 d-flex gap-3 align-items-center">
                            <label for="month" class="fw-bold mb-0">Periode:</label>
                            <select name="month" id="month" class="form-control" required>
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}">
                                        {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                                    </option>
                                @endfor
                            </select>

                            <select name="year" id="year" class="form-control" required>
                                @for ($y = now()->year; $y >= 2020; $y--)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endfor
                            </select>
                        </div>

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
                                                <select name="scores[{{ $employee->id }}][{{ $criteria->id }}]" required>
                                                    <option value="">Pilih</option>
                                                    @foreach ($criteria->subCriterias as $subCriteria)
                                                        <option value="{{ $subCriteria->id }}">{{ $subCriteria->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        @endforeach
                                        <td>
                                            <div class="d-flex">
                                                <button type="submit" name="save" value="{{ $employee->id }}" class="btn btn-primary btn-sm mx-2">Simpan</button>
                                            </div>
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