<?php

namespace App\Http\Controllers;

use App\Exports\StudentTemplateExport;
use App\Imports\StudentsImport;
use App\Models\School;
use App\Models\Operator;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class RegistrationController extends Controller
{
    /**
     * Download Template Excel untuk Data Siswa.
     * 
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadTemplate()
    {
        return Excel::download(new StudentTemplateExport, 'template_siswa_tka.xlsx');
    }

    /**
     * Simpan data pendaftaran (Sekolah, Operator, Siswa via Excel).
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validasi input (Sekolah & Operator Wajib, File Excel Wajib)
        $validator = Validator::make($request->all(), [
            // Data Sekolah
            'nama_sekolah' => 'required|string',
            'npsn_sekolah' => 'required|string',
            'jenjang_pendidikan' => 'required|in:SMP,SD',
            'jumlah_perangkat' => 'required|integer',

            // Operator Sekolah
            'nama_operator' => 'required|string',
            'no_whatsapp' => 'required|string',
            'email_sekolah' => 'required|email',

            // Data Siswa (File Excel)
            'student_file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();

            // 1. Logic Operator: Cek apakah email sudah ada?
            // Jika ada, pakai operator lama. Jika tidak, buat baru.
            $operator = Operator::firstOrCreate(
                ['email_sekolah' => $request->email_sekolah],
                [
                    'nama_operator' => $request->nama_operator,
                    'no_whatsapp' => $request->no_whatsapp,
                ]
            );

            // Opsional: Jika operator sudah ada, kita bisa update nama/wa-nya agar data terbaru
            // tapi firstOrCreate hanya create jika belum ada. 
            // Jika ingin update data operator existing, gunakan updateOrCreate atau manual update.
            // Di sini kita asumsikan data operator existing tetap valid, atau kita update jika diperlukan.
             if (!$operator->wasRecentlyCreated) {
                 $operator->update([
                     'nama_operator' => $request->nama_operator,
                     'no_whatsapp' => $request->no_whatsapp,
                 ]);
             }

            // 2. Simpan atau Update Data Sekolah
            // Sekarang sekolah punya operator_id
            $school = School::firstOrCreate(
                ['npsn_sekolah' => $request->npsn_sekolah],
                [
                    'operator_id' => $operator->id, // Link ke operator
                    'nama_sekolah' => $request->nama_sekolah,
                    'jenjang_pendidikan' => $request->jenjang_pendidikan,
                    'jumlah_perangkat' => $request->jumlah_perangkat
                ]
            );
            
            // Pastikan jika sekolah sudah ada, operatornya disesuaikan (misal ganti operator)
            if (!$school->wasRecentlyCreated) {
                $school->update(['operator_id' => $operator->id]);
            }

            // 3. Import Data Siswa dari Excel
            // Kita pass school_id ke class import agar data siswa terhubung ke sekolah ini
            Excel::import(new StudentsImport($school->id), $request->file('student_file'));

            DB::commit();

            return response()->json([
                'message' => 'Pendaftaran berhasil disimpan dan data siswa berhasil diimport.',
                'data' => [
                    'school' => $school,
                    'operator' => $operator
                ]
            ], 201);

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            DB::rollBack();
            $failures = $e->failures();
            $errors = [];
            foreach ($failures as $failure) {
                $errors[] = 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }
            return response()->json(['message' => 'Gagal import data siswa', 'errors' => $errors], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal menyimpan pendaftaran',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
