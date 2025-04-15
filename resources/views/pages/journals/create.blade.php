@php
$employeeId = auth()->user()->employee->id;
$employeeName = auth()->user()->employee->fullname;
@endphp

@extends('layouts.main')

@section('content')

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Jurnal</h6>
        </div>

        <div class="card-body">
            <form action="{{ route('store.journal') }}" method="POST">
                @csrf
                @method('POST')

                <div class="form-group">
                    <label for="employee">Nama Karyawan</label>
                    <input type="text" class="form-control" value="{{ $employeeName }}" disabled>
                    <input type="hidden" name="employee_id" value="{{ $employeeId }}">
                </div>

                <div class="form-group">
                    <label for="date" class="form-label">Tanggal</label>
                    <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}">
                    @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="activity" class="form-label">Aktivitas</label>
                    <input type="text" name="activity" id="activity" class="form-control @error('activity') is-invalid @enderror" value="{{ old('activity') }}">
                    @error('activity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="problem" class="form-label">Masalah</label>
                    <textarea name="problem" id="problem" class="form-control @error('problem') is-invalid @enderror" rows="3">{{ old('problem') }}</textarea>
                    @error('problem')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="solution" class="form-label">Solusi</label>
                    <textarea name="solution" id="solution" class="form-control @error('solution') is-invalid @enderror" rows="3">{{ old('solution') }}</textarea>
                    @error('solution')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="note" class="form-label">Catatan</label>
                    <textarea name="note" id="note" class="form-control @error('note') is-invalid @enderror" rows="3">{{ old('note') }}</textarea>
                    @error('note')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="card-footer d-flex justify-content-end">
                    <a href="{{ route('index.journals') }}" class="btn btn-outline-secondary mr-3">Batal</a>
                    <button type="submit" class="btn btn-primary">Tambah Karyawan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection