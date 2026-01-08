<div class="space-y-6">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Data Pendaftaran</h1>
            <p class="text-slate-500">Kelola data sekolah, operator, dan siswa yang terdaftar.</p>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-3">
            <!-- Search & Filter Group -->
            <div class="flex flex-1 sm:flex-none gap-2 bg-white p-1 rounded-xl border border-slate-200 shadow-sm">
                <!-- Filter Dropdown -->
                <div class="relative">
                    <select wire:model.live="jenjang" class="appearance-none pl-3 pr-8 py-2 bg-slate-50 hover:bg-slate-100 text-slate-700 text-sm font-medium rounded-lg cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition-colors border-none h-full">
                        <option value="">Semua Jenjang</option>
                        <option value="SD">SD</option>
                        <option value="SMP">SMP</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <div class="w-px bg-slate-200 my-1"></div>

                <!-- Search Input -->
                <div class="relative flex-1 sm:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input wire:model.live="search" type="text" placeholder="Cari sekolah, NPSN, operator..." class="block w-full pl-9 pr-3 py-2 bg-transparent border-none text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-0 text-sm">
                </div>
            </div>

            <!-- Export Button -->
            <button wire:click="export" wire:loading.attr="disabled" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-xl shadow-sm hover:shadow transition-all disabled:opacity-70 disabled:cursor-not-allowed">
                <svg wire:loading.remove wire:target="export" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                <svg wire:loading wire:target="export" class="w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="hidden sm:inline">Export Excel</span>
                <span class="sm:hidden">Export</span>
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center">
            <div class="p-3 bg-blue-100 rounded-lg text-blue-600 mr-4">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Total Sekolah</p>
                <p class="text-xl font-bold text-slate-800">{{ $stats['total_sekolah'] }}</p>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center">
            <div class="p-3 bg-purple-100 rounded-lg text-purple-600 mr-4">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Total Siswa</p>
                <p class="text-xl font-bold text-slate-800">{{ $stats['total_siswa'] }}</p>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center">
            <div class="p-3 bg-green-100 rounded-lg text-green-600 mr-4">
                <span class="font-bold text-lg">SD</span>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Sekolah SD</p>
                <p class="text-xl font-bold text-slate-800">{{ $stats['total_sd'] }}</p>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center">
            <div class="p-3 bg-indigo-100 rounded-lg text-indigo-600 mr-4">
                <span class="font-bold text-lg">SMP</span>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Sekolah SMP</p>
                <p class="text-xl font-bold text-slate-800">{{ $stats['total_smp'] }}</p>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="sticky left-0 z-20 bg-slate-50 px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider shadow-[2px_0_5px_-2px_rgba(0,0,0,0.1)]">Nama Sekolah</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider whitespace-nowrap">NPSN</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider whitespace-nowrap">Jenjang</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider whitespace-nowrap">Operator</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider whitespace-nowrap">Jml Siswa</th>
                        <th scope="col" class="sticky right-0 z-20 bg-slate-50 px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider shadow-[-2px_0_5px_-2px_rgba(0,0,0,0.1)]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($schools as $school)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="sticky left-0 z-20 bg-white group-hover:bg-slate-50 px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.1)]">{{ $school->nama_sekolah }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $school->npsn_sekolah }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $school->jenjang_pendidikan == 'SD' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $school->jenjang_pendidikan }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                            {{ $school->operator->nama_operator ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                            {{ $school->students->count() }}
                        </td>
                        <td class="sticky right-0 z-20 bg-white group-hover:bg-slate-50 px-6 py-4 whitespace-nowrap text-right text-sm font-medium shadow-[-2px_0_5px_-2px_rgba(0,0,0,0.1)]">
                            <button wire:click="showDetail({{ $school->id }})" class="text-blue-600 hover:text-blue-900 font-semibold mr-3">Lihat Detail</button>
                            <button wire:click="confirmDelete({{ $school->id }})" class="text-red-600 hover:text-red-900 font-semibold" title="Hapus Data">
                                <svg class="w-5 h-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500 sticky left-0 right-0 w-full">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                                <p class="text-lg font-medium text-slate-900">Belum ada data</p>
                                <p class="text-sm text-slate-500">Belum ada sekolah yang mendaftar atau tidak ditemukan data yang cocok.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $schools->links() }}
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
    <div class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" wire:click.self="cancelDelete">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden transform transition-all">
            <div class="p-6 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-slate-900">Hapus Data Pendaftaran?</h3>
                <div class="mt-2">
                    <p class="text-sm text-slate-500">
                        Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan dan akan menghapus data sekolah beserta siswa terkait.
                    </p>
                </div>
            </div>
            <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                <button wire:click="delete" type="button" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Hapus
                </button>
                <button wire:click="cancelDelete" type="button" class="mt-3 w-full inline-flex justify-center rounded-lg border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Batal
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Detail Modal -->
    @if($showDetailModal && $selectedSchool)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" wire:click.self="closeDetail">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50">
                <div>
                    <h2 class="text-xl font-bold text-slate-800">{{ $selectedSchool->nama_sekolah }}</h2>
                    <p class="text-sm text-slate-500">NPSN: {{ $selectedSchool->npsn_sekolah }}</p>
                </div>
                <button wire:click="closeDetail" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Content (Scrollable) -->
            <div class="flex-1 overflow-y-auto p-6 space-y-8">
                <!-- Info Operator -->
                <div>
                    <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        Informasi Operator
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <div>
                            <p class="text-xs font-medium text-slate-500 uppercase">Nama Operator</p>
                            <p class="mt-1 text-sm font-semibold text-slate-900">{{ $selectedSchool->operator->nama_operator ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-slate-500 uppercase">Email Sekolah</p>
                            <p class="mt-1 text-sm font-semibold text-slate-900">{{ $selectedSchool->operator->email_sekolah ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-slate-500 uppercase">WhatsApp</p>
                            <p class="mt-1 text-sm font-semibold text-slate-900">{{ $selectedSchool->operator->no_whatsapp ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Info Perangkat -->
                <div>
                     <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        Data Perangkat
                    </h3>
                    <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                        <p class="text-sm text-blue-800">Jumlah Perangkat yang dilaporkan: <span class="font-bold">{{ $selectedSchool->jumlah_perangkat }} Unit</span></p>
                    </div>
                </div>

                <!-- Daftar Siswa -->
                <div>
                    <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        Daftar Siswa ({{ $selectedSchool->students->count() }})
                    </h3>
                    <div class="border border-slate-200 rounded-xl overflow-hidden">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">NISN</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Nama Lengkap</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">L/P</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">TTL</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                @forelse($selectedSchool->students as $student)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-slate-900">{{ $student->nisn }}</td>
                                    <td class="px-4 py-2 text-sm text-slate-900 font-medium">{{ $student->fname }}</td>
                                    <td class="px-4 py-2 text-sm text-slate-500">{{ $student->jenis_kelamin }}</td>
                                    <td class="px-4 py-2 text-sm text-slate-500">{{ $student->tempat_lahir }}, {{ \Carbon\Carbon::parse($student->tanggal_lahir)->format('d/m/Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-sm text-slate-500">Tidak ada data siswa.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex justify-end">
                <button wire:click="closeDetail" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 font-medium text-sm transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
