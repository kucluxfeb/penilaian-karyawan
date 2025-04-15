@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">Hasil Penilaian</h3>

    {{-- Filter Periode --}}
    <form method="GET" action="{{ route('result.assessment') }}" class="d-flex gap-2 align-items-center">
        <label for="filter_by" class="form-label mb-0">Filter Berdasarkan:</label>
    
        <select name="filter_by" id="filter_by" class="form-select" onchange="this.form.submit()">
            <option value="bulanan" {{ $filter_by == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
            <option value="tahunan" {{ $filter_by == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
            <option value="semester" {{ $filter_by == 'semester' ? 'selected' : '' }}>Semester</option>
        </select>
    
        @if ($filter_by == 'bulanan')
            <select name="month" class="form-select">
                @for ($m = 1; $m <= 12; $m++)
                    <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}" {{ $month == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                    </option>
                @endfor
            </select>
        @endif
    
        @if ($filter_by == 'semester')
            <select name="semester" class="form-select">
                <option value="1" {{ $semester == 1 ? 'selected' : '' }}>Semester 1</option>
                <option value="2" {{ $semester == 2 ? 'selected' : '' }}>Semester 2</option>
            </select>
        @endif
    
        {{-- TAHUN tampil di semua filter --}}
        <select name="year" class="form-select">
            @foreach ($years as $y)
                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                    {{ $y }}
                </option>
            @endforeach
        </select>
    
        <button type="submit" class="btn btn-primary">Tampilkan</button>
    </form>
    

    {{-- Tombol Export --}}
    @if ($assessments->isNotEmpty())
        <div class="mb-3">
            <a href="{{ route('export.assessment', ['format' => 'pdf', 'filter_by' => $filter_by, 'year' => $year, 'month' => $month, 'semester' => $semester]) }}" target="_blank">Export PDF</a>

            <a href="{{ route('export.assessment', ['format' => 'excel', 'filter_by' => $filter_by, 'year' => $year, 'month' => $month, 'semester' => $semester]) }}">Export Excel</a>
            
        </div>
    @endif

    {{-- Tabel Hasil --}}
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Nama Pegawai</th>
                    @if ($assessments->isNotEmpty())
                        @foreach ($assessments->first()->assessmentDetails as $detail)
                            <th>{{ $detail->subCriteria->criteria->name }}</th>
                        @endforeach
                    @endif
                    <th>Total Skor</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($assessments as $assessment)
                    <tr>
                        <td>{{ $assessment->employee->fullname }}</td>
                        @foreach ($assessment->assessmentDetails as $detail)
                            <td>{{ $detail->value }}</td>
                        @endforeach
                        <td><strong>{{ $assessment->score }}</strong></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%" class="text-center">Belum ada data penilaian.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection