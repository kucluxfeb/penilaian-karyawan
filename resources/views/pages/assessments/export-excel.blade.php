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