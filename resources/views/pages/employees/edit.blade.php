@extends('layouts.main')

@section('content')

<div class="container-fluid">
    <form action="{{ route('update.employee', $employee->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Ubah Karyawan</h6>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label for="fullname" class="form-label">Nama Lengkap</label>
                    <input type="text" name="fullname" id="fullname" class="form-control @error('fullname') is-invalid @enderror" value="{{ old('fullname', $employee->fullname) }}">
                    @error('fullname')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="user_id">Akun User</label>
                    <select name="user_id" class="form-control">
                        <option value="" disabled selected>-- Pilih User --</option>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}" 
                            {{ optional($employee)->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} - {{ $user->email }}
                        </option>                        
                        @endforeach
                    </select>
                </div>
    
                <div class="form-group">
                    <label for="division_id" class="form-label">Divisi</label>
                    <select name="division_id" id="division_id" class="form-control @error('division_id') is-invalid @enderror">
                        @foreach ($divisions as $division)
                        <option value="{{ $division->id }}" {{ old('division_id', $employee->division_id) == $division->id ? 'selected' : '' }}>{{ $division->name }}</option>                        
                        @endforeach
                    </select>
                    @error('division_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
    
                <div class="form-group">
                    <label for="nip" class="form-label">NIP</label>
                    <input type="number" name="nip" id="nip" min="0" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip', $employee->nip) }}">
                    @error('nip')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
    
                <div class="form-group">
                    <label class="form-label d-block">Jenis Kelamin</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="genderMale" value="Laki-Laki" {{ old('gender', $employee->gender) == 'Laki-Laki' ? 'checked' : '' }}>
                        <label class="form-check-label" for="genderMale">Laki-Laki</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="Perempuan" {{ old('gender', $employee->gender) == 'Perempuan' ? 'checked' : '' }}>
                        <label class="form-check-label" for="genderFemale">Perempuan</label>
                    </div>
                    @error('gender')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
    
                <div class="form-group">
                    <label for="birth_place" class="form-label">Tempat Lahir</label>
                    <input type="text" name="birth_place" id="birth_place" max="{{ now()->toDateString() }}" class="form-control @error('birth_place') is-invalid @enderror" value="{{ old('birth_place', $employee->birth_place) }}">
                    @error('birth_place')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
    
                <div class="form-group">
                    <label for="birth_date" class="form-label">Tanggal Lahir</label>
                    <input type="date" name="birth_date" id="birth_date" class="form-control @error('birth_date') is-invalid @enderror" value="{{ old('birth_date', $employee->birth_date) }}">
                    @error('birth_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
    
                <div class="form-group">
                    <label for="address" class="form-label">Alamat</label>
                    <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $employee->address) }}">
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="photo" class="form-label">Foto</label>
                    <input type="file" name="photo" id="photo" class="form-control-file @error('photo') is-invalid @enderror" value="{{ old('photo', $employee->photo) }}">
                    @if ($employee->photo)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $employee->photo) }}" width="300" alt="foto {{ $employee->fullname }}">
                    </div>
                    @endif
                    @error('photo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">
                        Format yang diperbolehkan: <strong>jpg, jpeg, png</strong>. Maksimal ukuran: <strong>2MB</strong>.
                    </small>                
                </div>
    
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('index.employees') }}" class="btn btn-outline-secondary mr-3">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
            </div>
        </div>
    </form>
</div>

@endsection