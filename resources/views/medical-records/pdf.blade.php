<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Karta Medyczna - {{ $animal->name }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #ea580c;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #ea580c;
            margin: 0 0 5px 0;
            font-size: 24px;
        }
        .header p {
            margin: 0;
            color: #666;
        }
        .info-box {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #e5e7eb;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f3f4f6;
            font-weight: bold;
        }
        .badge {
            background-color: #dcfce7;
            color: #166534;
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Karta Medyczna Pacjenta</h1>
        <p>Wygenerowano automatycznie w systemie Azyl - {{ date('Y-m-d H:i') }}</p>
    </div>

    <div class="info-box">
        <strong>Imię pacjenta:</strong> {{ $animal->name }}<br>
        <strong>Gatunek/Rasa:</strong> {{ $animal->breed?->species?->name ?? 'Brak' }} / {{ $animal->breed->name ?? 'Brak' }}<br>
        <strong>Wiek (miesiące):</strong> {{ $animal->age_months }}<br>
        <strong>Płeć:</strong> {{ $animal->genders == 0 ? 'Samiec' : 'Samica' }}
    </div>

    <h3>Historia Leczenia</h3>

    <table>
        <thead>
            <tr>
                <th width="15%">Data</th>
                <th width="20%">Typ leczenia</th>
                <th width="50%">Opis</th>
                <th width="15%">Koszt (zł)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($animal->medicalRecords as $record)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($record->treatment_date)->format('Y-m-d') }}</td>
                    <td><span class="badge">{{ $record->treatment_type }}</span></td>
                    <td>{{ $record->description }}</td>
                    <td>{{ number_format($record->cost, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center; color:#999;">Brak historii medycznej dla tego zwierzęcia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dokument wewnętrzny schroniska Azyl. Nie wymaga podpisu.
    </div>

</body>
</html>
