<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SchoolController extends Controller
{
    /**
     * Cari data sekolah berdasarkan NPSN dari API eksternal.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $npsn = $request->query('npsn');

        if (!$npsn) {
            return response()->json(['error' => 'NPSN wajib diisi'], 400);
        }

        try {
            // Mengambil data dari https://sekolah.devapi.id/sekolah
            // Menambahkan parameter limit untuk suggestion (default API biasanya 10)
            $response = Http::get("https://sekolah.devapi.id/sekolah", [
                'npsn' => $npsn,
                'limit' => 10 // Membatasi hasil suggestion
            ]);

            if ($response->successful()) {
                $responseData = $response->json();

                // Cek apakah ada data sekolah yang ditemukan
                if (isset($responseData['data']) && !empty($responseData['data'])) {
                    // Map semua data yang ditemukan untuk suggestion list
                    $mappedData = collect($responseData['data'])->map(function($school) {
                        return [
                            'nama_sekolah' => $school['nama'] ?? null,
                            'npsn_sekolah' => $school['npsn'] ?? null,
                            'jenjang_pendidikan' => $school['bentukPendidikan'] ?? null,
                        ];
                    });

                    return response()->json($mappedData);
                } else {
                    return response()->json([
                        'error' => 'Data sekolah tidak ditemukan'
                    ], 404);
                }
            } else {
                return response()->json([
                    'error' => 'Terjadi kesalahan pada API sekolah'
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan koneksi saat mengambil data sekolah'
            ], 500);
        }
    }
}
