<div>
  @if ($isSubmitted)
    {{-- VIEW: SUCCESS STATE --}}
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
    {{-- VIEW: FORM WIZARD --}}

    {{-- Stepper --}}
    <div class="mb-8 flex items-center justify-center gap-4 text-sm font-medium">
      <div class="flex items-center gap-2 {{ $currentStep === 1 ? 'text-indigo-600' : 'text-slate-400' }}">
        <span
          class="flex h-6 w-6 items-center justify-center rounded-full {{ $currentStep === 1 ? 'bg-indigo-600 text-white' : 'bg-slate-200 text-slate-500' }} text-xs">1</span>
        Data Sekolah
      </div>
      <div class="h-px w-8 bg-slate-200"></div>
      <div class="flex items-center gap-2 {{ $currentStep === 2 ? 'text-indigo-600' : 'text-slate-400' }}">
        <span
          class="flex h-6 w-6 items-center justify-center rounded-full {{ $currentStep === 2 ? 'bg-indigo-600 text-white' : 'bg-slate-200 text-slate-500' }} text-xs">2</span>
        Data Siswa
      </div>
    </div>

    <form wire:submit="submit" enctype="multipart/form-data">

      {{-- STEP 1: DATA SEKOLAH & OPERATOR --}}
      @if ($currentStep === 1)
        <div class="animate-fade-in space-y-10">

          {{-- Section Data Sekolah --}}
          <section class="space-y-5">
            <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
              <div class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-50 text-emerald-600">
                <img src="{{ asset('icon/school.svg') }}" class="w-5 h-5 text-slate-700" alt="Icon School">
              </div>
              <div>
                <h3 class="font-semibold text-slate-900 text-lg">Asal Sekolah</h3>
                <p class="text-xs text-slate-500">Cek data sekolah berdasarkan NPSN</p>
              </div>
            </div>

            {{-- [MODIFIKASI] Grid NPSN & Nama Sekolah --}}
            <div class="grid grid-cols-1 md:grid-cols-12 gap-5">

              {{-- NPSN (Editable & Trigger Search) --}}
              <div class="md:col-span-12 space-y-2">
                <x-ui.label for="npsn" value="NPSN Sekolah *" />
                <div class="relative">
                  {{-- wire:model.blur: Trigger pencarian saat user selesai mengetik --}}
                  <x-ui.input name="npsn" id="npsn" type="text" inputmode="numeric" maxlength="8"
                    wire:model.blur="npsn" placeholder="Masukkan 8 Digit NPSN" :error="$errors->first('npsn')"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" />

                  {{-- Loading Indicator NPSN --}}
                  <div class="absolute right-3 top-2.5" wire:loading wire:target="npsn">
                    <svg class="animate-spin h-5 w-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                      viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                      <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                      </path>
                    </svg>
                  </div>
                </div>
                {{-- Pesan Loading Teks --}}
                <div wire:loading wire:target="npsn" class="text-xs text-indigo-600 font-medium">
                  Sedang mencari data sekolah...
                </div>
              </div>

              {{-- Nama Sekolah (Readonly & Auto-Filled) --}}
              <div class="md:col-span-12 space-y-2">
                <x-ui.label for="schoolName" value="Nama Sekolah (Otomatis)" />
                {{-- class="bg-slate-100" memberi efek visual terkunci --}}
                <x-ui.input name="schoolName" id="schoolName" type="text" readonly
                  class="bg-slate-100 cursor-not-allowed text-slate-600" wire:model="schoolName"
                  placeholder="Nama sekolah akan muncul otomatis" :error="$errors->first('schoolName')" />
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-1 gap-5">
              {{-- Jenjang Pendidikan --}}
              <div class="space-y-2">
                <x-ui.label for="schoolLevel" value="Jenjang Pendidikan *" />
                <div class="relative">
                  <select name="schoolLevel" wire:model="schoolLevel" id="schoolLevel"
                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 appearance-none @error('schoolLevel') border-destructive focus-visible:ring-destructive @enderror">
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
            </div>
          </section>

          {{-- Section Data Operator --}}
          <section class="space-y-5">
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

          {{-- Tombol Lanjut (Next) --}}
          <div class="pt-6 border-t border-slate-100">
            <x-ui.button type="button" wire:click="nextStep"
              class="w-full h-12 text-base font-semibold shadow-lg shadow-indigo-200/50" size="lg"
              variant="hero">
              Lanjut ke Upload File
              <svg class="w-4 h-4 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
              </svg>
            </x-ui.button>
          </div>
        </div>
      @endif

      {{-- STEP 2: UPLOAD FILE --}}
      @if ($currentStep === 2)
        <div class="animate-slide-up space-y-10">

          <section class="space-y-5">
            <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
              <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-50 text-indigo-600">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                  viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round">
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
                <p class="text-xs text-slate-500">Langkah terakhir: Upload file Excel</p>
              </div>
            </div>

            <div class="bg-slate-50 rounded-xl border border-slate-200 p-6">
              {{-- Step A: Download --}}
              <div class="flex items-start gap-4 mb-8 relative">
                <div class="absolute left-4 top-8 -bottom-5 w-px bg-slate-200"></div>
                <div
                  class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white border border-slate-200 text-sm font-bold text-slate-600 shadow-sm z-10">
                  1</div>
                <div>
                  <h4 class="text-sm font-semibold text-slate-900">Unduh Template</h4>
                  <p class="text-xs text-slate-500 mb-3">Gunakan template ini.</p>
                  <a href="#"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-white border border-slate-300 shadow-sm text-sm font-medium text-slate-700 hover:text-indigo-600 transition-colors">
                    <img src="{{ asset('icon/download.svg') }}" class="w-4 h-4" alt="Icon Download">
                    Download Template.xlsx
                  </a>
                </div>
              </div>

              {{-- Step B: Upload --}}
              <div class="flex items-start gap-4">
                <div
                  class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white border border-slate-200 text-sm font-bold text-slate-600 shadow-sm z-10">
                  2</div>
                <div class="w-full">
                  <h4 class="text-sm font-semibold text-slate-900 mb-1">Upload File</h4>
                  <div class="relative w-full group mt-2">
                    <label for="studentFile"
                      class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed rounded-xl cursor-pointer transition-all hover:bg-white hover:border-indigo-400 @error('studentFile') border-red-300 bg-red-50/50 @else border-slate-300 bg-slate-100/50 @enderror">
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
                          <p class="text-sm font-semibold text-slate-900">{{ $studentFile->getClientOriginalName() }}
                          </p>
                          <span class="mt-2 text-[10px] text-indigo-600 font-bold bg-indigo-50 px-2 py-1 rounded">Ganti
                            File</span>
                        </div>
                      @else
                        <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center">
                          <img src="{{ asset('icon/upload.svg') }}" class="w-8 h-8 mb-2" alt="Icon Upload">
                          <p class="mb-1 text-sm text-slate-700 font-medium">Klik untuk upload</p>
                          <p class="text-xs text-slate-400">Excel / CSV (Max 10MB)</p>
                        </div>
                      @endif
                      <input id="studentFile" name="studentFile" wire:model="studentFile" type="file"
                        class="hidden" accept=".xlsx,.xls,.csv" />
                    </label>
                  </div>
                  <div class="mt-2 min-h-[20px]">
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

          {{-- Tombol Navigasi (Kembali & Kirim) --}}
          <div class="pt-6 flex gap-4 border-t border-slate-100">
            <x-ui.button type="button" wire:click="previousStep" variant="outline"
              class="w-1/3 border-slate-300 text-slate-600">
              Kembali
            </x-ui.button>

            <x-ui.button class="w-2/3 h-12 text-base font-semibold shadow-lg shadow-indigo-200/50" size="lg"
              variant="hero" wire:loading.attr="disabled">
              <span wire:loading.remove>Kirim Data</span>
              <span wire:loading class="flex items-center gap-2">
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                  viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                    stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                  </path>
                </svg>
                Mengirim...
              </span>
            </x-ui.button>
          </div>
        </div>
      @endif

    </form>
  @endif
</div>
