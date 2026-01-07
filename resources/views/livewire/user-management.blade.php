<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Manajemen Pengguna</h1>
            <p class="text-slate-500">Kelola akun administrator sistem.</p>
        </div>
        <button wire:click="showCreateForm" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Pengguna
        </button>
    </div>

    <!-- Feedback Message -->
    @if($successMessage)
    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-md flex justify-between items-center">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-green-700">{{ $successMessage }}</p>
            </div>
        </div>
        <button wire:click="$set('successMessage', '')" class="text-green-700 hover:text-green-900">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>
    @endif

    <!-- Form Modal/Card -->
    @if($showForm)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" wire:click.self="cancel">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
                <h2 class="text-lg font-bold text-slate-800">{{ $editingId ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}</h2>
                <button wire:click="cancel" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form wire:submit.prevent="save" class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                    <input wire:model="form.name" type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('form.name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input wire:model="form.email" type="email" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('form.email') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Password {{ $editingId ? '(Kosongkan jika tidak diubah)' : '' }}</label>
                    <input wire:model="form.password" type="password" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('form.password') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" wire:click="cancel" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 text-sm font-medium">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Terdaftar</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs mr-3">
                                    {{ substr($user->name, 0, 2) }}
                                </div>
                                <div class="text-sm font-medium text-slate-900">{{ $user->name }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $user->created_at->diffForHumans() }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button wire:click="editUser({{ $user->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                            <button wire:click="deleteUser({{ $user->id }})" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin ingin menghapus pengguna ini?') || event.stopImmediatePropagation()">Hapus</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-500">Tidak ada pengguna ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $users->links() }}
        </div>
    </div>
</div>
