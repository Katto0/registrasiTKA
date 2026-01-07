<div class="min-h-screen bg-slate-50">
    <div class="md:flex">
        <aside class="hidden md:block md:fixed md:inset-y-0 md:left-0 md:w-64 bg-white border-r border-slate-200 flex flex-col">
            <div class="flex h-16 items-center px-6 border-b border-slate-200">
                <div class="mr-3 flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                    </svg>
                </div>
                <span class="text-xl font-bold text-slate-800">TKA Center</span>
            </div>
            <nav class="px-3 py-4 space-y-1">
                <a href="{{ route('dashboard') }}" class="group flex items-center rounded-md px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900">
                    <svg class="mr-3 h-5 w-5 text-slate-500 group-hover:text-slate-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
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
                <a href="{{ route('users') }}" class="group flex items-center rounded-md px-3 py-2 text-sm font-medium bg-blue-600 text-white">
                    <svg class="mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75a3.75 3.75 0 00-7.5 0m10.5 0A6.75 6.75 0 006 18.75m10.5 0h3.75M3 18.75h3.75M18 9.75a6 6 0 11-12 0 6 6 0 0112 0z" />
                    </svg>
                    Manajemen Pengguna
                </a>
            </nav>
            <form method="POST" action="{{ route('logout') }}" class="mt-auto px-3 pt-2 pb-4">
                @csrf
                <x-ui.button variant="outline" class="w-full">Keluar</x-ui.button>
            </form>
        </aside>

        <div class="md:pl-64 flex w-full flex-col">
            <header class="bg-white border-b border-slate-200">
                <div class="flex h-16 items-center justify-between px-4 sm:px-6 lg:px-8">
                    <h1 class="text-lg sm:text-2xl font-semibold text-slate-900">Manajemen Pengguna</h1>
                    <x-ui.button type="button" class="ml-4" wire:click="showCreateForm">Tambah Pengguna</x-ui.button>
                </div>
            </header>
            <main>
                <div class="px-4 py-8 sm:px-6 lg:px-8">
                    @if ($successMessage)
                        <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700 border border-green-200">
                            {{ $successMessage }}
                        </div>
                    @endif

                    <div class="fixed inset-0 z-50 {{ $showForm ? '' : 'pointer-events-none' }}">
                        <div
                            class="absolute inset-0 bg-slate-900/50 transition-opacity duration-300 {{ $showForm ? 'opacity-100 pointer-events-auto' : 'opacity-0 pointer-events-none' }}"
                            wire:click="cancel"
                        ></div>
                        <div
                            class="relative mx-auto max-w-lg p-4 sm:p-6"
                            role="{{ $showForm ? 'dialog' : '' }}"
                            aria-modal="{{ $showForm ? 'true' : 'false' }}"
                        >
                            <div class="mx-auto rounded-xl bg-white shadow-xl border border-slate-200 transform transition-all duration-300 ease-out {{ $showForm ? 'opacity-100 scale-100 translate-y-0' : 'opacity-0 scale-95 -translate-y-2 pointer-events-none' }}">
                                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200">
                                    <h2 class="text-base font-semibold text-slate-900">
                                        {{ $editingId ? 'Edit Pengguna' : 'Tambah Pengguna' }}
                                    </h2>
                                    <button type="button" class="rounded-md p-2 text-slate-500 hover:bg-slate-100" wire:click="cancel" aria-label="Tutup">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="px-6 py-5">
                                    <form wire:submit="save" class="space-y-4">
                                        <div>
                                            <x-ui.label for="name" value="Nama Lengkap" />
                                            <x-ui.input
                                                id="name"
                                                type="text"
                                                wire:model="form.name"
                                                placeholder="Masukkan nama lengkap"
                                                :error="$errors->first('form.name')"
                                                class="mt-1"
                                            />
                                        </div>
                                        <div>
                                            <x-ui.label for="email" value="Email" />
                                            <x-ui.input
                                                id="email"
                                                type="email"
                                                wire:model="form.email"
                                                placeholder="Masukkan email"
                                                :error="$errors->first('form.email')"
                                                class="mt-1"
                                            />
                                        </div>
                                        <div>
                                            <x-ui.label for="password" value="Kata Sandi" />
                                            <x-ui.input
                                                id="password"
                                                type="password"
                                                wire:model="form.password"
                                                placeholder="{{ $editingId ? 'Kosongkan jika tidak ingin mengubah' : 'Masukkan kata sandi (min. 8 karakter)' }}"
                                                :error="$errors->first('form.password')"
                                                class="mt-1"
                                            />
                                        </div>
                                        <div class="flex items-center gap-2 pt-2">
                                            <x-ui.button type="submit">
                                                Simpan
                                            </x-ui.button>
                                            <x-ui.button type="button" variant="outline" wire:click="cancel">
                                                Batal
                                            </x-ui.button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h2 class="text-lg font-medium leading-6 text-slate-900">Daftar Pengguna</h2>
                        <div class="mt-4 overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg bg-white">
                            <table class="min-w-full divide-y divide-slate-300">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-slate-900 sm:pl-6">Nama</th>
                                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Email</th>
                                        <th class="relative py-3.5 pl-3 pr-4 sm:pr-6"><span class="sr-only">Aksi</span></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200">
                                    @forelse ($users as $user)
                                        <tr>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-slate-900 sm:pl-6">{{ $user->name }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">{{ $user->email }}</td>
                                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                <x-ui.button type="button" variant="secondary" class="mr-2" wire:click="editUser({{ $user->id }})">Edit</x-ui.button>
                                                <x-ui.button
                                                    type="button"
                                                    variant="destructive"
                                                    onclick="confirm('Yakin ingin menghapus pengguna ini?') || event.stopImmediatePropagation()"
                                                    wire:click="deleteUser({{ $user->id }})"
                                                >Hapus</x-ui.button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-4 text-sm text-slate-500">Belum ada pengguna.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>
