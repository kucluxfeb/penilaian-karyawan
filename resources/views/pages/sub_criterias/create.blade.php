@extends('layouts.main')

@section('content')

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Sub Kriteria untuk {{ $criteria->name }}</h6>
        </div>

        <div class="card-body">
            <form action="{{ route('store.subCriteria') }}" method="POST">
                @csrf
                @method('POST')

                <input type="hidden" name="criteria_id" value="{{ $criteria->id }}">

                <div class="form-group">
                    <label for="name" class="form-label">Nama Sub Kriteria</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="weight" class="form-label">Bobot</label>
                    <input type="number" name="weight" id="weight" class="form-control @error('weight') is-invalid @enderror" value="{{ old('weight') }}">
                    @error('weight')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="card-footer d-flex justify-content-end">
                    <a href="{{ route('index.subCriterias', $criteria->id) }}" class="btn btn-outline-secondary mr-3">Batal</a>
                    <button type="submit" class="btn btn-primary">Tambah Sub Kriteria</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection