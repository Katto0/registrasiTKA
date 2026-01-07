<?php

namespace Tests\Feature;

use App\Models\Operator;
use App\Models\School;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class RegistrationBackendTest extends TestCase
{
    use RefreshDatabase; // Clean DB after each test
    use WithFaker;

    /**
     * Test Download Template Excel
     */
    public function test_can_download_excel_template()
    {
        // Hit API Endpoint
        $response = $this->getJson(route('api.students.template'));

        // Assert Status OK
        $response->assertStatus(200);

        // Assert Headers for File Download
        $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->assertHeader('content-disposition', 'attachment; filename=template_siswa_tka.xlsx');
    }

    /**
     * Test Create Registration (Success)
     */
    public function test_can_create_registration_with_valid_data()
    {
        // Fake Excel Import to avoid actual file parsing logic dependency in test
        // or we can use a real file if we want integration test.
        // For feature test, we can mock Excel to ensure the controller calls it.
        Excel::fake();

        // Prepare Data
        $data = [
            'nama_sekolah' => 'SD Negeri Contoh 01',
            'npsn_sekolah' => '12345678',
            'jenjang_pendidikan' => 'SD',
            'jumlah_perangkat' => 15,
            
            'nama_operator' => 'Budi Santoso',
            'no_whatsapp' => '081234567890',
            'email_sekolah' => 'sdn01@example.com',
            
            // Fake Excel File
            'student_file' => UploadedFile::fake()->create('siswa.xlsx', 100) // 100kb
        ];

        // Hit API Endpoint
        $response = $this->postJson(route('api.registrations.store'), $data);

        // Assert Created (201)
        $response->assertStatus(201);
        
        // Assert Response Structure
        $response->assertJsonStructure([
            'message',
            'data' => [
                'school',
                'operator'
            ]
        ]);

        // Assert Database Has Records
        $this->assertDatabaseHas('operators', [
            'email_sekolah' => 'sdn01@example.com',
            'nama_operator' => 'Budi Santoso'
        ]);

        $this->assertDatabaseHas('schools', [
            'npsn_sekolah' => '12345678',
            'nama_sekolah' => 'SD Negeri Contoh 01',
            'jenjang_pendidikan' => 'SD'
        ]);

        // Assert Excel Import was called
        // Note: Since we use Excel::fake(), the StudentsImport won't actually run,
        // so 'students' table won't be populated. That's expected in Unit/Feature test with Mocks.
        Excel::assertImported('siswa.xlsx');
    }

    /**
     * Test Create Registration Validation Error
     */
    public function test_create_registration_validation_error()
    {
        // Prepare Invalid Data (Missing required fields)
        $data = [
            'nama_sekolah' => '', // Empty
            // Missing others
        ];

        // Hit API Endpoint
        $response = $this->postJson(route('api.registrations.store'), $data);

        // Assert Unprocessable Entity (422)
        $response->assertStatus(422);

        // Assert Errors structure
        $response->assertJsonValidationErrors([
            'nama_sekolah',
            'npsn_sekolah',
            'jenjang_pendidikan',
            'student_file',
            'nama_operator', 
            'email_sekolah'
        ]);
    }
}
