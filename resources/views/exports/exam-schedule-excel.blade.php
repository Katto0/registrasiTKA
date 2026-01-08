<table>
    <thead>
    <tr>
        <th colspan="7" style="text-align: center; font-weight: bold; font-size: 16px;">JADWAL UJIAN TKA - {{ $school->nama_sekolah }}</th>
    </tr>
    <tr>
        <th colspan="7" style="text-align: center;">Mulai Tanggal: {{ \Carbon\Carbon::parse($date)->isoFormat('D MMMM Y') }}</th>
    </tr>
    <tr>
        <th style="font-weight: bold; border: 1px solid #000000; background-color: #cccccc;">No</th>
        <th style="font-weight: bold; border: 1px solid #000000; background-color: #cccccc;">Nama Siswa</th>
        <th style="font-weight: bold; border: 1px solid #000000; background-color: #cccccc;">NISN</th>
        <th style="font-weight: bold; border: 1px solid #000000; background-color: #cccccc;">Sesi</th>
        <th style="font-weight: bold; border: 1px solid #000000; background-color: #cccccc;">Waktu</th>
        <th style="font-weight: bold; border: 1px solid #000000; background-color: #cccccc;">No. Kursi</th>
    </tr>
    </thead>
    <tbody>
    @php $no = 1; @endphp
    @foreach($sessions as $session)
        @foreach($session->assignments->sortBy('seat_number') as $assignment)
            <tr>
                <td style="border: 1px solid #000000;">{{ $no++ }}</td>
                <td style="border: 1px solid #000000;">{{ $assignment->student->nama_siswa }}</td>
                <td style="border: 1px solid #000000;">{{ $assignment->student->nisn_siswa }}</td>
                <td style="border: 1px solid #000000; text-align: center;">{{ \Carbon\Carbon::parse($session->exam_date)->isoFormat('D MMMM Y') }}</td>
                <td style="border: 1px solid #000000; text-align: center;">{{ $session->session_number }}</td>
                <td style="border: 1px solid #000000; text-align: center;">{{ substr($session->start_time, 0, 5) }} - {{ substr($session->end_time, 0, 5) }}</td>
                <td style="border: 1px solid #000000; text-align: center;">{{ $assignment->seat_number }}</td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>
