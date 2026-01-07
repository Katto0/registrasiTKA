<div class="min-h-screen bg-slate-50">
    <div class="md:flex">
        <aside class="hidden md:block md:fixed md:inset-y-0 md:left-0 md:w-64 bg-white border-r border-slate-200">
            <div class="flex h-16 items-center px-6 border-b border-slate-200">
                <div class="mr-3 flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                    </svg>
                </div>
                <span class="text-xl font-bold text-slate-800">TKA Center</span>
            </div>
            <nav class="px-3 py-4 space-y-1">
                <a href="{{ route('dashboard') }}" class="group flex items-center rounded-md px-3 py-2 text-sm font-medium bg-blue-600 text-white">
                    <svg class="mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M3 9.75V21h6.75v-5.25A2.25 2.25 0 0112 13.5h0a2.25 2.25 0 012.25 2.25V21H21V9.75" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('registrations') }}" class="group flex items-center rounded-md px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900">
                    <svg class="mr-3 h-5 w-5 text-slate-500 group-hover:text-slate-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5h18m-12 6h12M3 12h6m-6 6h18" />
                    </svg>
                    Data Pendaftaran
                </a>
                <a href="{{ route('users') }}" class="group flex items-center rounded-md px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900">
                    <svg class="mr-3 h-5 w-5 text-slate-500 group-hover:text-slate-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75a3.75 3.75 0 00-7.5 0m10.5 0A6.75 6.75 0 006 18.75m10.5 0h3.75M3 18.75h3.75M18 9.75a6 6 0 11-12 0 6 6 0 0112 0z" />
                    </svg>
                    Manajemen Pengguna
                </a>
                <form method="POST" action="{{ route('logout') }}" class="px-3 pt-2">
                    @csrf
                    <x-ui.button variant="outline" class="w-full">Keluar</x-ui.button>
                </form>
            </nav>
        </aside>

        <div class="md:pl-64 flex w-full flex-col">
            <header class="bg-white border-b border-slate-200">
                <div class="flex h-16 items-center justify-between px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center gap-3">
                        <button class="md:hidden inline-flex items-center justify-center rounded-md p-2 text-slate-600 hover:bg-slate-100 hover:text-slate-900" aria-label="Open menu" disabled>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>
                        <h1 class="text-lg sm:text-2xl font-semibold text-slate-900">Dashboard</h1>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="hidden sm:flex items-center rounded-full bg-slate-100 px-3 py-1 text-sm text-slate-600">
                            Selamat datang, Admin
                        </div>
                    </div>
                </div>
            </header>

            <main>
                <div class="px-4 py-8 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Widget 1: Total TKA -->
                    <div class="overflow-hidden rounded-xl bg-white shadow border border-slate-200">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="truncate text-sm font-medium text-slate-500">Total Siswa Terdaftar TKA</dt>
                                        <dd>
                                            <div class="text-lg font-medium text-slate-900">128</div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <div class="bg-slate-50 px-5 py-3">
                            <div class="text-sm">
                                <a href="#" class="font-medium text-blue-700 hover:text-blue-900">Lihat semua →</a>
                            </div>
                        </div>
                    </div>

                    <!-- Widget 2: Jadwal Ujian Minggu Ini -->
                    <div class="overflow-hidden rounded-xl bg-white shadow border border-slate-200">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-yellow-50 text-yellow-600">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="truncate text-sm font-medium text-slate-500">Jadwal Ujian Minggu Ini</dt>
                                        <dd>
                                            <div class="text-lg font-medium text-slate-900">12</div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <div class="bg-slate-50 px-5 py-3">
                            <div class="text-sm">
                                <a href="#" class="font-medium text-blue-700 hover:text-blue-900">Lihat detail →</a>
                            </div>
                        </div>
                    </div>

                     <!-- Widget 3: Total Sekolah -->
                    <div class="overflow-hidden rounded-xl bg-white shadow border border-slate-200">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                   <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-50 text-green-600">
                                       <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l9.75-7.5 9.75 7.5M4.5 10.5V21h15V10.5M8.25 21v-6h7.5v6" />
                                       </svg>
                                   </div>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="truncate text-sm font-medium text-slate-500">Total Sekolah</dt>
                                        <dd>
                                            <div class="text-lg font-medium text-slate-900">48</div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <div class="bg-slate-50 px-5 py-3">
                            <div class="text-sm">
                                <a href="#" class="font-medium text-blue-700 hover:text-blue-900">Lihat sekolah →</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                    <!-- Recent Activity Table -->
                    <div class="mt-8">
                        <h2 class="text-lg font-medium leading-6 text-slate-900">Pendaftaran Baru</h2>
                        <div class="mt-4 overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-2xl bg-white border border-slate-200">
                        <table class="min-w-full divide-y divide-slate-300">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-slate-900 sm:pl-6">Nama Operator</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Nama Sekolah</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">No WhatsApp</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 bg-white">
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-slate-900 sm:pl-6">Ahmad Rizki</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">TKA Al-Hikmah</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">08xxxxxxxxxx</td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <a href="#" class="text-blue-600 hover:text-blue-900">Edit</a>
                                    </td>
                                </tr>
                                 <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-slate-900 sm:pl-6">Siti Nurhaliza</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">TKA Bunda Mulia</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">08xxxxxxxxxx</td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <a href="#" class="text-blue-600 hover:text-blue-900">Edit</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>
