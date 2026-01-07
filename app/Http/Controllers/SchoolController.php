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
            $response = Http::get("https://sekolah.devapi.id/sekolah", [
                'npsn' => $npsn
            ]);

            if ($response->successful()) {
                $responseData = $response->json();

                // Cek apakah ada data sekolah yang ditemukan
                if (isset($responseData['data']) && !empty($responseData['data'])) {
                    // Ambil data pertama dari array hasil pencarian
                    $schoolData = $responseData['data'][0];

                    // Mapping data sesuai kebutuhan FE
                    // Jenjang pendidikan diambil dari 'bentukPendidikan'
                    $mappedData = [
                        'nama_sekolah' => $schoolData['nama'] ?? null,
                        'npsn_sekolah' => $schoolData['npsn'] ?? null,
                        'jenjang_pendidikan' => $schoolData['bentukPendidikan'] ?? null,
                    ];

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
