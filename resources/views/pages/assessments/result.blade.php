@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">Hasil Penilaian</h3>

    <form method="GET" action="{{ route('result.assessment') }}" class="mb-3">
        <select name="period" onchange="this.form.submit()">
            @foreach ($periods as $p)
                <option value="{{ $p }}" {{ $period == $p ? 'selected' : '' }}>{{ $p }}</option>
            @endforeach
        </select>
    </form>

    <div class="mb-3">
        <a href="{{ route('export.assessment', 'excel') }}" class="btn btn-success">Export Excel</a>
        <a href="{{ route('export.assessment', 'pdf') }}" class="btn btn-danger">Export PDF</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Pegawai</th>
                @foreach ($assessments->first()?->assessmentDetails as $d)
                    <th>{{ $d->subCriteria->criteria->name }}</th>
                @endforeach
                <th>Total Skor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($assessments as $assessment)
                <tr>
                    <td>{{ $assessment->employee->fullname }}</td>
                    @foreach ($assessment->assessmentDetails as $detail)
                        <td>{{ $detail->value }}</td>
                    @endforeach
                    <td>{{ $assessment->score }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection