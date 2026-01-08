<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Registrations;
use App\Models\School;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class RegistrationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_render_component()
    {
        Livewire::test(Registrations::class)
            ->assertStatus(200);
    }

    /** @test */
    public function can_search_schools_by_name()
    {
        School::factory()->create(['nama_sekolah' => 'SD Harapan Bangsa']);
        School::factory()->create(['nama_sekolah' => 'SMP Negeri 1']);

        Livewire::test(Registrations::class)
            ->set('search', 'Harapan')
            ->assertSee('SD Harapan Bangsa')
            ->assertDontSee('SMP Negeri 1');
    }

    /** @test */
    public function can_filter_schools_by_jenjang()
    {
        School::factory()->create(['nama_sekolah' => 'SD Merdeka', 'jenjang_pendidikan' => 'SD']);
        School::factory()->create(['nama_sekolah' => 'SMP Juara', 'jenjang_pendidikan' => 'SMP']);

        Livewire::test(Registrations::class)
            ->set('jenjang', 'SD')
            ->assertSee('SD Merdeka')
            ->assertDontSee('SMP Juara');
    }

    /** @test */
    public function can_delete_school()
    {
        $school = School::factory()->create();

        Livewire::test(Registrations::class)
            ->call('confirmDelete', $school->id)
            ->assertSet('deleteId', $school->id)
            ->assertSet('showDeleteModal', true)
            ->call('delete');

        $this->assertDatabaseMissing('schools', ['id' => $school->id]);
    }

    /** @test */
    public function can_export_excel()
    {
        // Mock Excel export
        \Maatwebsite\Excel\Facades\Excel::fake();

        Livewire::test(Registrations::class)
            ->call('export');

        \Maatwebsite\Excel\Facades\Excel::assertDownloaded('data-pendaftaran-tka.xlsx');
    }
}
