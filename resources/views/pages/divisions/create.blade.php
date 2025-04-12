@extends('layouts.main')

@section('content')

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Divisi</h6>
        </div>

        <div class="card-body">
            <form action="{{ route('store.division') }}" method="POST">
                @csrf
                @method('POST')

                <div class="form-group">
                    <label for="name" class="form-label">Nama Divisi</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="card-footer d-flex justify-content-end">
                    <a href="{{ route('index.divisions') }}" class="btn btn-outline-secondary mr-3">Batal</a>
                    <button type="submit" class="btn btn-primary">Tambah Divisi</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection