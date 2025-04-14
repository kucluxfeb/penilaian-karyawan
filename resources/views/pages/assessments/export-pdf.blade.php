<!DOCTYPE html>
<html>
<head>
    <title>Hasil Penilaian Pegawai</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 5px; text-align: center; }
    </style>
</head>
<body>
    <h2>Hasil Penilaian Pegawai</h2>
    <table>
        <thead>
            <tr>
                <th>Nama Pegawai</th>
                @php
                    $criterias = $data->first()?->assessmentDetails->map(fn($d) => $d->subCriteria->criteria->name)->unique();
                @endphp
                @foreach ($criterias as $criteria)
                    <th>{{ $criteria }}</th>
                @endforeach
                <th>Total Skor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $assessment)
                <tr>
                    <td>{{ $assessment->employee->fullname }}</td>
                    @foreach ($criterias as $criteriaName)
                        @php
                            $value = $assessment->assessmentDetails
                                ->firstWhere(fn($d) => $d->subCriteria->criteria->name === $criteriaName)?->value ?? '-';
                        @endphp
                        <td>{{ $value }}</td>
                    @endforeach
                    <td>{{ $assessment->score }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>