@extends('layouts.main')

@section('content')

<div class="container-fluid">
    <form action="{{ route('update.criteria', $criteria->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Ubah Kriteria</h6>
            </div>

            <div class="card-body">

                <div class="form-group">
                    <label for="code" class="form-label">Kode</label>
                    <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $criteria->code) }}">
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name" class="form-label">Nama Kriteria</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $criteria->name) }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="weight" class="form-label">Bobot</label>
                    <select name="weight" id="weight" class="form-control @error('weight') is-invalid @enderror">
                        <option value="" disabled selected>Pilih Bobot</option>
                        <option value="1" {{ $criteria->weight == '1' ? 'selected' : '' }}>(1) Tidak Penting</option>
                        <option value="2" {{ $criteria->weight == '2' ? 'selected' : '' }}>(2) Kurang Penting</option>
                        <option value="3" {{ $criteria->weight == '3' ? 'selected' : '' }}>(3) Cukup Penting</option>
                        <option value="4" {{ $criteria->weight == '4' ? 'selected' : '' }}>(4) Penting</option>
                        <option value="5" {{ $criteria->weight == '5' ? 'selected' : '' }}>(5) Sangat Penting</option>
                    </select>
                    @error('weight')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label d-block">Tipe</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="type" id="typeBenefit" value="Benefit" {{ old('type', $criteria->type) == 'Benefit' ? 'checked' : '' }}>
                        <label class="form-check-label" for="typeBenefit">Benefit</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="type" id="typeCost" value="Cost" {{ old('type', $criteria->type) == 'Cost' ? 'checked' : '' }}>
                        <label class="form-check-label" for="typeCost">Cost</label>
                    </div>
                    @error('type')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
    
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('index.criterias') }}" class="btn btn-outline-secondary mr-3">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
            </div>
        </div>
    </form>
</div>

@endsection