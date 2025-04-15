@extends('layouts.main')

@section('content')

<div class="container-fluid">
    <form action="{{ route('update.journal', $journal->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Ubah Jurnal</h6>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label for="employee_id" class="form-label">Nama Karyawan</label>
                    <select name="employee_id" id="employee_id" class="form-control @error('employee_id') is-invalid @enderror">
                        <option value="" disabled selected>Pilih Nama Karyawan</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('employee_id', $journal->employee_id) == $employee->id ? 'selected' : '' }}>{{ $employee->fullname }}</option>
                        @endforeach
                    </select>
                    @error('employee_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="date" class="form-label">Tanggal</label>
                    <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', $journal->date) }}">
                    @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="activity" class="form-label">Aktivitas</label>
                    <input type="text" name="activity" id="activity" class="form-control @error('activity') is-invalid @enderror" value="{{ old('activity', $journal->activity) }}">
                    @error('activity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="problem" class="form-label">Masalah</label>
                    <textarea name="problem" id="problem" class="form-control @error('problem') is-invalid @enderror" rows="3">{{ old('problem', $journal->problem) }}</textarea>
                    @error('problem')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="solution" class="form-label">Solusi</label>
                    <textarea name="solution" id="solution" class="form-control @error('solution') is-invalid @enderror" rows="3">{{ old('solution', $journal->solution) }}</textarea>
                    @error('solution')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="note" class="form-label">Catatan</label>
                    <textarea name="note" id="note" class="form-control @error('note') is-invalid @enderror" rows="3">{{ old('note', $journal->note) }}</textarea>
                    @error('note')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
    
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('index.journals') }}" class="btn btn-outline-secondary mr-3">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
            </div>
        </div>
    </form>
</div>

@endsection