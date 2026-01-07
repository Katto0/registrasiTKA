<?php

namespace App\Exports;

use App\Models\School;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RegistrationsExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    protected $search;
    protected $jenjang;

    public function __construct($search = '', $jenjang = '')
    {
        $this->search = $search;
        $this->jenjang = $jenjang;
    }

    public function query()
    {
        return School::query()
            ->with(['operator', 'students'])
            ->when($this->search, function ($query) {
                $query->where('nama_sekolah', 'like', '%' . $this->search . '%')
                      ->orWhere('npsn_sekolah', 'like', '%' . $this->search . '%')
                      ->orWhereHas('operator', function ($q) {
                          $q->where('nama_operator', 'like', '%' . $this->search . '%');
                      });
            })
            ->when($this->jenjang, function ($query) {
                $query->where('jenjang_pendidikan', $this->jenjang);
            })
            ->latest();
    }

    public function headings(): array
    {
        return [
            'NPSN',
            'Nama Sekolah',
            'Jenjang',
            'Jumlah Perangkat',
            'Nama Operator',
            'No. WhatsApp',
            'Email Sekolah',
            'Jumlah Siswa Terdaftar',
            'Tanggal Daftar',
        ];
    }

    public function map($school): array
    {
        return [
            $school->npsn_sekolah,
            $school->nama_sekolah,
            $school->jenjang_pendidikan,
            $school->jumlah_perangkat,
            $school->operator->nama_operator ?? '-',
            $school->operator->no_whatsapp ?? '-',
            $school->operator->email_sekolah ?? '-',
            $school->students->count(),
            $school->created_at->format('d-m-Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
