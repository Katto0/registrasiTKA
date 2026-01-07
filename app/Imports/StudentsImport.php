<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use Exception;

class StudentsImport implements ToCollection, WithHeadingRow
{
    protected $school_id;

    public function __construct($school_id)
    {
        $this->school_id = $school_id;
    }

    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            // Skip jika baris kosong
            if (!isset($row['nisn'])) continue;

            // Validasi per baris
            $validator = Validator::make($row->toArray(), [
                'nisn' => 'required|numeric', // Unique check dihandle manual atau via try-catch
                'fname' => 'required|string',
                'tanggal_lahir' => 'required', // Bisa format excel serial date atau string
                'tempat_lahir' => 'required|string',
                'jenis_kelamin' => 'required|in:L,P',
                'nama_orangtua' => 'nullable|string',
                'nomor_orangtua' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                throw new Exception("Error pada baris ke-" . ($index + 2) . ": " . implode(', ', $validator->errors()->all()));
            }

            // Konversi Tanggal Lahir jika format Excel (integer serial date)
            $tanggal_lahir = $row['tanggal_lahir'];
            if (is_numeric($tanggal_lahir)) {
                $tanggal_lahir = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tanggal_lahir)->format('Y-m-d');
            }

            // Simpan Data Siswa
            Student::create([
                'school_id' => $this->school_id,
                'nisn' => $row['nisn'],
                'fname' => $row['fname'],
                'tanggal_lahir' => $tanggal_lahir,
                'tempat_lahir' => $row['tempat_lahir'],
                'jenis_kelamin' => $row['jenis_kelamin'],
                'nama_orangtua' => $row['nama_orangtua'],
                'nomor_orangtua' => $row['nomor_orangtua'],
            ]);
        }
    }
}
