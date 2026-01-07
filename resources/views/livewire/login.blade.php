<div class="flex min-h-screen items-center justify-center bg-slate-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg border border-slate-200">
        <div class="flex flex-col items-center">
            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50">
                <svg class="h-6 w-6 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                </svg>
            </div>
            <h2 class="text-center text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
                Admin Pendaftaran TKA
            </h2>
            <p class="mt-1 text-center text-sm text-slate-500">
                Masuk untuk mengelola data pendaftar
            </p>
        </div>

        <form class="mt-6 space-y-5" wire:submit="login">
            <div>
                <x-ui.label for="email" value="Email" />
                <div class="relative mt-1">
                    <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 7.5l-9.75 6-9.75-6m19.5 0v9a2.25 2.25 0 01-2.25 2.25h-13.5A2.25 2.25 0 013 16.5v-9m19.5 0L12 13.5M3 7.5l9 6" />
                        </svg>
                    </span>
                    <x-ui.input
                        id="email"
                        type="email"
                        wire:model="email"
                        placeholder="email"
                        :error="$errors->first('email')"
                        class="pl-10"
                    />
                </div>
            </div>

            <div>
                <x-ui.label for="password" value="Kata Sandi" />
                <div class="relative mt-1">
                    <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V9a4.5 4.5 0 10-9 0v1.5m11.25 0h-13.5a1.5 1.5 0 00-1.5 1.5v6a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5v-6a1.5 1.5 0 00-1.5-1.5z" />
                        </svg>
                    </span>
                    <x-ui.input
                        id="password"
                        :type="$showPassword ? 'text' : 'password'"
                        wire:model="password"
                        placeholder="Masukkan kata sandi"
                        :error="$errors->first('password')"
                        class="pl-10 pr-10"
                    />
                    <button type="button" class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-slate-600" wire:click="$set('showPassword', ! $showPassword)" aria-label="Tampilkan/ sembunyikan kata sandi">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6 9.75-6 9.75 6 9.75 6-3.75 6-9.75 6-9.75-6-9.75-6z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="pt-2">
                <x-ui.button type="submit" class="w-full">
                    Masuk
                </x-ui.button>
            </div>
        </form>

        <div class="mt-6 text-center text-xs text-slate-500">
            © {{ date('Y') }} TKA Admin System
        </div>
    </div>
</div>
