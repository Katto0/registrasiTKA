<div class="space-y-6">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Jadwal Sesi Ujian TKA</h1>
            <p class="text-slate-500">Generate pembagian 3 sesi berdasarkan jumlah perangkat per sekolah.</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 text-sm">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-slate-800">Waktu Sesi (Fix)</h2>
                <p class="text-sm text-slate-500">Pembagian hanya diacak penempatan siswanya, bukan waktunya.</p>
            </div>
            <div class="text-sm text-slate-600">
                Mulai Tanggal: <span class="font-semibold">{{ $startDate }}</span>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Sesi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @foreach($sessionDefinitions as $num => $time)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">Sesi {{ $num }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ substr($time['start'], 0, 5) }} - {{ substr($time['end'], 0, 5) }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">
                                Latihan (10 menit), Bahasa Indonesia (60 menit), Matematika (60 menit)
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if (!empty($results))
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="font-semibold text-slate-800">Hasil Generate</h2>
            </div>
            <div class="divide-y divide-slate-200">
                @foreach($results as $r)
                    <div class="px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                        <div class="text-sm text-slate-800">
                            <span class="font-semibold">Sekolah ID:</span> {{ $r['school_id'] }}
                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $r['status'] === 'ok' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                {{ $r['status'] === 'ok' ? 'OK' : 'Gagal' }}
                            </span>
                        </div>
                        <div class="text-sm text-slate-600">{{ $r['message'] }}</div>
                        @if (($r['status'] ?? '') === 'ok' && isset($r['counts']))
                            <div class="text-xs text-slate-500">
                                S1: {{ $r['counts'][1] ?? 0 }} | S2: {{ $r['counts'][2] ?? 0 }} | S3: {{ $r['counts'][3] ?? 0 }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="font-semibold text-slate-800">Pilih Sekolah</h2>
                    <p class="text-sm text-slate-500">Rule: Max 3 sesi/hari. Jika siswa > kapasitas harian, jadwal otomatis lanjut ke hari berikutnya.</p>
                </div>
                <div class="text-sm text-slate-600">
                    Terpilih: <span class="font-semibold">{{ count($selectedSchoolIds) }}</span>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <!-- Search -->
                <div class="relative w-full lg:w-72">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input wire:model.live="search" type="text" placeholder="Cari sekolah / NPSN..." class="block w-full pl-10 pr-3 py-2 border border-slate-200 rounded-lg text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>

                <!-- Actions -->
                <div class="flex flex-wrap items-center gap-3">
                    <!-- Date Picker -->
                    <div class="flex items-center gap-2 bg-slate-50 px-3 py-2 rounded-lg border border-slate-200">
                        <span class="text-sm font-medium text-slate-600 whitespace-nowrap">Mulai:</span>
                        <input wire:model.live="startDate" type="date" class="bg-transparent border-none text-sm text-slate-700 font-medium focus:ring-0 p-0 cursor-pointer" />
                    </div>

                    <button wire:click="selectAllVisible" class="inline-flex items-center justify-center px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 text-sm font-medium rounded-lg border border-slate-200 transition-all">
                        Pilih Semua
                    </button>

                    <button wire:click="clearSelection" class="inline-flex items-center justify-center px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 text-sm font-medium rounded-lg border border-slate-200 transition-all">
                        Reset
                    </button>

                    <button wire:click="generate" wire:loading.attr="disabled" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm hover:shadow transition-all disabled:opacity-70 disabled:cursor-not-allowed">
                        <svg wire:loading.remove wire:target="generate" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2" />
                        </svg>
                        <svg wire:loading wire:target="generate" class="w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Generate
                    </button>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Pilih</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Sekolah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">NPSN</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Operator</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Perangkat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Siswa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Kapasitas Harian</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($schools as $school)
                        @php
                            $devices = (int) $school->jumlah_perangkat;
                            $studentsCount = (int) $school->students_count;
                            $capacity = $devices * 3;
                            $ok = $devices > 0 && $studentsCount > 0;
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                                    wire:click="toggleSchool({{ $school->id }})"
                                    @checked(in_array($school->id, $selectedSchoolIds)) />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">{{ $school->nama_sekolah }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $school->npsn_sekolah }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $school->operator->nama_operator ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $devices }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $studentsCount }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $capacity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $ok ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ $ok ? 'Siap' : 'Cek Data' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-10 text-center text-sm text-slate-500">Tidak ada sekolah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $schools->links() }}
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200">
            <h2 class="font-semibold text-slate-800">Ringkasan Jadwal (Sekolah Terpilih)</h2>
            <p class="text-sm text-slate-500">Menampilkan jadwal yang sudah tersimpan untuk tanggal terpilih.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Sesi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Terisi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Kapasitas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($sessions->groupBy('school_id') as $schoolId => $schoolSessions)
                        @php $schoolName = \App\Models\School::find($schoolId)->nama_sekolah ?? 'Unknown'; @endphp
                        <tr class="bg-slate-100">
                            <td colspan="6" class="px-6 py-3">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-slate-700">{{ $schoolName }} (ID: {{ $schoolId }})</span>
                                    <div class="flex gap-2">
                                        <button wire:click="exportExcel({{ $schoolId }})" class="inline-flex items-center gap-1 px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                            Excel
                                        </button>
                                        <button wire:click="exportPdf({{ $schoolId }})" class="inline-flex items-center gap-1 px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            PDF
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @foreach($schoolSessions as $s)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-800 font-medium pl-10">{{ \Carbon\Carbon::parse($s->exam_date)->translatedFormat('d F Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">Sesi {{ $s->session_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                {{ substr($s->start_time, 0, 5) }} - {{ substr($s->end_time, 0, 5) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                <span class="font-medium text-slate-900">{{ $s->assignments_count }}</span> siswa
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $s->capacity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <button wire:click="showSessionDetails({{ $s->id }})" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Lihat Detail</button>
                            </td>
                        </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-sm text-slate-500">Belum ada jadwal yang di-generate untuk sekolah terpilih.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Detail Modal -->
    @if($showDetailModal && $selectedSession)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" wire:click.self="closeSessionDetails">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">
                        Detail Sesi {{ $selectedSession->session_number }} - {{ $selectedSession->school->nama_sekolah }}
                    </h3>
                    <p class="text-sm text-slate-500">
                        Waktu: {{ substr($selectedSession->start_time, 0, 5) }} - {{ substr($selectedSession->end_time, 0, 5) }} |
                        Total: {{ $selectedSession->assignments->count() }} Siswa
                    </p>
                </div>
                <button wire:click="closeSessionDetails" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="flex-1 overflow-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No Kursi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NISN</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($selectedSession->assignments->sortBy('seat_number') as $assignment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $assignment->seat_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $assignment->student->fname ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $assignment->student->nisn ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    Tidak ada siswa di sesi ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-3 border-t border-slate-200 bg-slate-50 flex justify-end">
                <button type="button" class="inline-flex justify-center rounded-md border border-slate-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" wire:click="closeSessionDetails">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
