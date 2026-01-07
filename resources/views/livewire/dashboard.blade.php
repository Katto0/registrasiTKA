<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Dashboard</h1>
            <p class="text-slate-500">Ringkasan data sistem pendaftaran TKA.</p>
        </div>
        <div class="text-sm text-slate-500 bg-white px-3 py-1 rounded-full border border-slate-200 shadow-sm">
            {{ now()->format('d F Y') }}
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card Sekolah -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                </div>
                <span class="text-sm font-medium text-slate-400">Total</span>
            </div>
            <h3 class="text-3xl font-bold text-slate-800">{{ $totalSchools }}</h3>
            <p class="text-sm text-slate-500 mt-1">Sekolah Terdaftar</p>
        </div>

        <!-- Card Siswa -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-green-50 rounded-lg text-green-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                </div>
                <span class="text-sm font-medium text-slate-400">Total</span>
            </div>
            <h3 class="text-3xl font-bold text-slate-800">{{ $totalStudents }}</h3>
            <p class="text-sm text-slate-500 mt-1">Siswa Terdaftar</p>
        </div>

        <!-- Card Operator -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
             <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-purple-50 rounded-lg text-purple-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <span class="text-sm font-medium text-slate-400">Total</span>
            </div>
            <h3 class="text-3xl font-bold text-slate-800">{{ $totalOperators }}</h3>
            <p class="text-sm text-slate-500 mt-1">Operator Aktif</p>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
            <h3 class="font-semibold text-slate-800">Pendaftaran Sekolah Terbaru</h3>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse($recentSchools as $school)
            <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                <div class="flex items-center space-x-4">
                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                        {{ substr($school->nama_sekolah, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-900">{{ $school->nama_sekolah }}</p>
                        <p class="text-xs text-slate-500">NPSN: {{ $school->npsn_sekolah }} • {{ $school->jenjang_pendidikan }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm text-slate-900">{{ $school->operator->nama_operator ?? 'Tanpa Operator' }}</p>
                    <p class="text-xs text-slate-500">{{ $school->created_at->diffForHumans() }}</p>
                </div>
            </div>
            @empty
            <div class="px-6 py-8 text-center text-slate-500 text-sm">
                Belum ada pendaftaran terbaru.
            </div>
            @endforelse
        </div>
        <div class="px-6 py-3 bg-slate-50 border-t border-slate-200 text-right">
            <a href="{{ route('registrations') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">Lihat Semua Data &rarr;</a>
        </div>
    </div>
</div>
