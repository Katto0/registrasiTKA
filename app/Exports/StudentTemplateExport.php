<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentTemplateExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles
{
    public function array(): array
    {
        // 1 Baris Dummy Data
        return [
            [
                '1234567890',          // nisn
                'Ahmad Siswa',         // fname
                '2015-05-20',          // tanggal_lahir (YYYY-MM-DD)
                'Jakarta',             // tempat_lahir
                'L',                   // jenis_kelamin (L/P)
                'Budi Santoso',        // nama_orangtua
                '081234567890',        // nomor_orangtua
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'nisn',
            'fname',
            'tanggal_lahir',
            'tempat_lahir',
            'jenis_kelamin',
            'nama_orangtua',
            'nomor_orangtua',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1    => ['font' => ['bold' => true]],
        ];
    }
}
