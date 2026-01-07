<div>
  @if ($isSubmitted)
    {{-- ======================================================================== --}}
    {{-- VIEW: SUCCESS STATE --}}
    {{-- ======================================================================== --}}
    <div class="animate-slide-up text-center py-12">
      <div
        class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-green-50 mb-6 ring-8 ring-green-50/50">
        <img src="{{ asset('icon/check-circle.svg') }}" class="w-12 h-12 text-green-600" alt="Icon Check Circle">
      </div>

      <h3 class="text-2xl font-bold text-slate-900 mb-3 tracking-tight">
        Data Berhasil Dikirim!
      </h3>

      <p class="text-slate-500 mb-8 max-w-md mx-auto leading-relaxed">
        Terima kasih. File data siswa telah kami terima. Bukti pendaftaran akan dikirimkan ke email <span
          class="font-medium text-slate-900">{{ $email }}</span>.
      </p>

      {{-- Reset Button --}}
      <x-ui.button variant="outline" wire:click="resetForm"
        class="mx-auto block w-auto border-slate-300 text-slate-700 hover:bg-slate-50 hover:text-slate-900">
        <span class="flex items-center gap-2">
          <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
            <polyline points="17 8 12 3 7 8" />
            <line x1="12" x2="12" y1="3" y2="15" />
          </svg>
          Upload File Baru
        </span>
      </x-ui.button>
    </div>
  @else
    {{-- ======================================================================== --}}
    {{-- VIEW: FORM INPUT STATE --}}
    {{-- ======================================================================== --}}

    {{-- Info Alert --}}
    <div class="mb-8 rounded-xl bg-blue-50/50 border border-blue-100 p-4 flex gap-4 animate-fade-in">
      <div class="shrink-0 mt-0.5">
        <svg class="w-5 h-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
          viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
          stroke-linejoin="round">
          <circle cx="12" cy="12" r="10" />
          <path d="M12 16v-4" />
          <path d="M12 8h.01" />
        </svg>
      </div>
      <div class="text-sm text-blue-900">
        <h4 class="font-semibold mb-1">Mode Input Kolektif</h4>
        <p class="text-blue-800/80 leading-relaxed">
          Silakan unduh template Excel yang tersedia untuk memastikan format data siswa terbaca dengan benar.
        </p>
      </div>
    </div>

    <form wire:submit="submit" enctype="multipart/form-data" class="space-y-10">

      {{-- -------------------------------------------------------------------- --}}
      {{-- SECTION 1: UPLOAD DATA SISWA (EXCEL) --}}
      {{-- -------------------------------------------------------------------- --}}
      <section class="space-y-5 animate-slide-up" style="animation-delay: 0ms;">

        {{-- Section Header --}}
        <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
          <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-50 text-indigo-600">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
              fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
              <polyline points="14 2 14 8 20 8" />
              <path d="M8 13h2" />
              <path d="M8 17h2" />
              <path d="M14 13h2" />
              <path d="M14 17h2" />
            </svg>
          </div>
          <div>
            <h3 class="font-semibold text-slate-900 text-lg">Data Kolektif Siswa</h3>
            <p class="text-xs text-slate-500">Upload data siswa via Excel</p>
          </div>
        </div>

        <div class="bg-slate-50 rounded-xl border border-slate-200 p-6">
          {{-- Step 1: Download Template --}}
          <div class="flex items-start gap-4 mb-8 relative">
            <div class="absolute left-4 top-8 -bottom-5 w-px bg-slate-200"></div> {{-- Connector Line --}}
            <div
              class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white border border-slate-200 text-sm font-bold text-slate-600 shadow-sm z-10">
              1</div>
            <div>
              <h4 class="text-sm font-semibold text-slate-900">Unduh Template</h4>
              <p class="text-xs text-slate-500 mb-3">Gunakan template ini dan jangan ubah judul kolom.</p>

              {{-- Route Download Template --}}
              <a href="#"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-white border border-slate-300 shadow-sm text-sm font-medium text-slate-700 hover:text-indigo-600 transition-colors">
                <img src="{{ asset('icon/download.svg') }}" class="w-4 h-4" alt="Icon Download">
                Download Template.xlsx
              </a>
            </div>
          </div>

          {{-- Step 2: Upload File --}}
          <div class="flex items-start gap-4">
            <div
              class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white border border-slate-200 text-sm font-bold text-slate-600 shadow-sm z-10">
              2</div>
            <div class="w-full">
              <h4 class="text-sm font-semibold text-slate-900 mb-1">Upload File</h4>

              <div class="relative w-full group mt-2">
                <label for="studentFile"
                  class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed rounded-xl cursor-pointer transition-all hover:bg-white hover:border-indigo-400 @error('studentFile') border-red-300 bg-red-50/50 @else @enderror">

                  {{-- UI: File Selected --}}
                  @if ($studentFile)
                    <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center animate-fade-in">
                      <div
                        class="h-10 w-10 bg-green-100 text-green-600 rounded-lg flex items-center justify-center mb-2">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                          viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                          stroke-linecap="round" stroke-linejoin="round">
                          <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                          <polyline points="14 2 14 8 20 8" />
                        </svg>
                      </div>
                      <p class="text-sm font-semibold text-slate-900">{{ $studentFile->getClientOriginalName() }}</p>
                      <span class="mt-2 text-[10px] text-indigo-600 font-bold bg-indigo-50 px-2 py-1 rounded">Ganti
                        File</span>
                    </div>

                    {{-- UI: Default State --}}
                  @else
                    <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center">
                      <img src="{{ asset('icon/upload.svg') }}" class="w-8 h-8 mb-2" alt="Icon Upload">
                      <p class="mb-1 text-sm text-slate-700 font-medium">Klik untuk upload</p>
                      <p class="text-xs text-slate-400">Excel (.xlsx, .xls) / CSV (Max 10MB)</p>
                    </div>
                  @endif

                  {{-- Input File --}}
                  <input id="studentFile" name="studentFile" wire:model="studentFile" type="file" class="hidden"
                    accept=".xlsx,.xls,.csv" />
                </label>
              </div>

              {{-- UI: Loading & Error Indicator --}}
              <div class="mt-2 min-h-5">
                <div wire:loading wire:target="studentFile"
                  class="flex items-center gap-2 text-xs font-medium text-indigo-600 bg-indigo-50 px-3 py-2 rounded-md w-fit">
                  <svg class="animate-spin h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                      stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                  </svg>
                  Memproses file...
                </div>
                @error('studentFile')
                  <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
              </div>
            </div>
          </div>
        </div>
      </section>

      {{-- -------------------------------------------------------------------- --}}
      {{-- SECTION 2: DATA SEKOLAH --}}
      {{-- -------------------------------------------------------------------- --}}
      <section class="space-y-5 animate-slide-up" style="animation-delay: 100ms;">

        {{-- Section Header --}}
        <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
          <div class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-50 text-emerald-600">
            <img src="{{ asset('icon/school.svg') }}" class="w-5 h-5 text-slate-700" alt="Icon School">
          </div>
          <div>
            <h3 class="font-semibold text-slate-900 text-lg">Asal Sekolah</h3>
            <p class="text-xs text-slate-500">Informasi pendidikan sekolah asal</p>
          </div>
        </div>

        {{-- Row 1: Nama & NPSN --}}
        <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
          <div class="md:col-span-12 space-y-2">
            <x-ui.label for="schoolName" value="Nama Sekolah *" />
            <x-ui.input name="schoolName" id="schoolName" type="text" wire:model.blur="schoolName"
              placeholder="Contoh: SMP NEGERI 1 JAKARTA" :error="$errors->first('schoolName')" />
          </div>
          <div class="md:col-span-12 space-y-2">
            <x-ui.label for="npsn" value="NPSN Sekolah *" />
            <x-ui.input name="npsn" id="npsn" type="text" inputmode="numeric" maxlength="8"
              wire:model.blur="npsn" placeholder="8 Digit Angka" :error="$errors->first('npsn')"
              oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
          </div>
        </div>

        {{-- Row 2: Jenjang & Kelas --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

          {{-- Jenjang Pendidikan --}}
          <div class="space-y-2">
            <x-ui.label for="schoolLevel" value="Jenjang Pendidikan *" />
            <div class="relative">
              {{-- wire:model.live is mandatory for auto-filling logic --}}
              <select name="schoolLevel" wire:model.live="schoolLevel" id="schoolLevel"
                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 appearance-none @error('schoolLevel') @enderror">
                <option value="">Pilih jenjang</option>
                <option value="SD">SD (Sekolah Dasar)</option>
                <option value="SMP">SMP (Sekolah Menengah Pertama)</option>
              </select>
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                <svg class="h-4 w-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </div>
            </div>
            @error('schoolLevel')
              <p class="text-[0.8rem] font-medium text-destructive mt-1">{{ $message }}</p>
            @enderror
          </div>

          {{-- Kelas --}}
          <div class="space-y-2">
            <x-ui.label for="grade" value="Kelas *" />
            <div class="relative">
              {{-- [BACKEND] Disabled during loading 'schoolLevel' to prevent race condition --}}
              <select name="grade" wire:model="grade" id="grade"
                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 appearance-none @error('grade') @enderror disabled:bg-slate-50 transition-colors"
                @disabled(empty($schoolLevel)) wire:loading.attr="disabled" wire:target="schoolLevel">
                <option value="">Pilih kelas</option>
                @foreach ($availableGrades as $g)
                  <option value="{{ $g }}">Kelas {{ $g }}</option>
                @endforeach
              </select>

              {{-- Loading Spinner --}}
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3" wire:loading
                wire:target="schoolLevel">
                <svg class="animate-spin h-4 w-4 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                  viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                    stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                  </path>
                </svg>
              </div>

              {{-- Default Chevron --}}
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500"
                wire:loading.remove wire:target="schoolLevel">
                <svg class="h-4 w-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </div>
            </div>
            @error('grade')
              <p class="text-[0.8rem] font-medium text-destructive mt-1">{{ $message }}</p>
            @enderror
          </div>
        </div>
      </section>

      {{-- -------------------------------------------------------------------- --}}
      {{-- SECTION 3: DATA OPERATOR --}}
      {{-- -------------------------------------------------------------------- --}}
      <section class="space-y-5 animate-slide-up" style="animation-delay: 200ms;">

        {{-- Section Header (Image Asset) --}}
        <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
          <div class="flex h-10 w-10 items-center justify-center rounded-full bg-orange-50 text-orange-600">
            <img src="{{ asset('icon/operator.svg') }}" class="w-5 h-5 text-slate-700" alt="Icon Operator">
          </div>
          <div>
            <h3 class="font-semibold text-slate-900 text-lg">Operator Sekolah</h3>
            <p class="text-xs text-slate-500">Penanggung jawab data</p>
          </div>
        </div>

        <div class="space-y-2">
          <x-ui.label for="operatorName" value="Nama Operator *" />
          <x-ui.input name="operatorName" id="operatorName" type="text" wire:model.blur="operatorName"
            placeholder="Nama lengkap operator sekolah" :error="$errors->first('operatorName')" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
          <div class="space-y-2">
            <x-ui.label for="phoneNumber" value="No. WhatsApp *" />
            <div class="relative">
              <span class="absolute left-3 top-2.5 text-slate-400">
                <img src="{{ asset('icon/phone.svg') }}" alt="Phone Icon" class="w-4 h-4">
              </span>
              <x-ui.input name="phoneNumber" id="phoneNumber" type="tel" wire:model.blur="phoneNumber"
                class="pl-9" placeholder="08xxxxxxxxxx" :error="$errors->first('phoneNumber')"
                oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
            </div>
          </div>
          <div class="space-y-2">
            <x-ui.label for="email" value="Email Sekolah / Operator *" />
            <div class="relative">
              <span class="absolute left-3 top-2.5 text-slate-400">
                <img src="{{ asset('icon/mail.svg') }}" alt="Mail Icon" class="w-4 h-4">
              </span>
              <x-ui.input name="email" id="email" type="email" wire:model.blur="email" class="pl-9"
                placeholder="admin@sekolah.sch.id" :error="$errors->first('email')" />
            </div>
          </div>
        </div>
      </section>

      {{-- -------------------------------------------------------------------- --}}
      {{-- SUBMIT BUTTON --}}
      {{-- -------------------------------------------------------------------- --}}
      <div class="pt-6">
        <x-ui.button class="w-full h-12 text-base font-semibold shadow-lg shadow-indigo-200/50" size="lg"
          variant="hero" wire:loading.attr="disabled">
          <span wire:loading.remove>Daftar Sekarang</span>
          <span wire:loading class="flex items-center gap-2">
            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
              </path>
            </svg>
            Mengunggah File...
          </span>
        </x-ui.button>
        <p class="text-[11px] text-slate-400 text-center mt-3">
          Pastikan seluruh data dalam file Excel sudah benar sebelum dikirim.
        </p>
      </div>

    </form>
  @endif
</div>
