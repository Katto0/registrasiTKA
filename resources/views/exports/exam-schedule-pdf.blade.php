<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Jadwal Ujian TKA - {{ $school->nama_sekolah }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 14px;
        }
        .meta {
            margin-bottom: 20px;
        }
        .meta table {
            width: 100%;
            border: none;
        }
        .meta td {
            padding: 2px;
        }
        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .schedule-table th, .schedule-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .schedule-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
        }
        .schedule-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: right;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 5px;
        }
        .page-break {
            page-break-after: always;
        }
        .session-header {
            background-color: #e2e8f0;
            padding: 10px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            border-left: 4px solid #3b82f6;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Jadwal Ujian TKA</h1>
        <p>{{ $school->nama_sekolah }}</p>
    </div>

    <div class="meta">
        <table>
            <tr>
                <td width="15%"><strong>NPSN</strong></td>
                <td>: {{ $school->npsn_sekolah }}</td>
                <td width="15%"><strong>Tanggal</strong></td>
                <td>: {{ \Carbon\Carbon::parse($date)->isoFormat('D MMMM Y') }}</td>
            </tr>
            <tr>
                <td><strong>Operator</strong></td>
                <td>: {{ $school->operator->nama_operator ?? '-' }}</td>
                <td><strong>Total Siswa</strong></td>
                <td>: {{ $sessions->sum(fn($s) => $s->assignments->count()) }}</td>
            </tr>
        </table>
    </div>

    @foreach($sessions as $session)
        <div class="session-header">
            {{ \Carbon\Carbon::parse($session->exam_date)->isoFormat('dddd, D MMMM Y') }} - Sesi {{ $session->session_number }} 
            <span style="font-weight: normal; font-size: 0.9em; margin-left: 10px;">
                ({{ substr($session->start_time, 0, 5) }} - {{ substr($session->end_time, 0, 5) }})
            </span>
        </div>

        <table class="schedule-table">
            <thead>
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="10%" class="text-center">Kursi</th>
                    <th>Nama Siswa</th>
                    <th width="20%">NISN</th>
                </tr>
            </thead>
            <tbody>
                @forelse($session->assignments->sortBy('seat_number') as $index => $assignment)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center">{{ $assignment->seat_number }}</td>
                        <td>{{ $assignment->student->nama_siswa }}</td>
                        <td>{{ $assignment->student->nisn_siswa }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada siswa di sesi ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endforeach

    <div class="footer">
        Dicetak pada: {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
