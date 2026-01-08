<div>
  @if ($isSubmitted)
    {{-- SUCCESS STATE --}}
    <div class="animate-slide-up text-center py-12">
      <div
        class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-green-50 mb-6 ring-8 ring-green-50/50">
        <img src="{{ asset('icon/check-circle.svg') }}" class="w-12 h-12 text-green-600" alt="Success">
      </div>
      <h3 class="text-2xl font-bold text-slate-900 mb-3 tracking-tight">Pendaftaran Berhasil!</h3>
      <p class="text-slate-500 mb-8 max-w-md mx-auto leading-relaxed">
        Data sekolah dan file siswa telah kami terima. Bukti pendaftaran dikirim ke <span
          class="font-medium text-slate-900">{{ $email_sekolah }}</span>.
      </p>
      <x-ui.button variant="outline" wire:click="resetForm" class="mx-auto block w-auto">
        Daftar Baru
      </x-ui.button>
    </div>
  @else
    {{-- FORM WIZARD --}}

    <div class="mb-8 flex items-center justify-center gap-4 text-sm font-medium">
      <div class="flex items-center gap-2 {{ $currentStep === 1 ? 'text-indigo-600' : 'text-slate-400' }}">
        <span
          class="flex h-6 w-6 items-center justify-center rounded-full {{ $currentStep === 1 ? 'bg-indigo-600 text-white' : 'bg-slate-200 text-slate-500' }} text-xs">1</span>
        Data Sekolah & Operator
      </div>
      <div class="h-px w-8 bg-slate-200"></div>
      <div class="flex items-center gap-2 {{ $currentStep === 2 ? 'text-indigo-600' : 'text-slate-400' }}">
        <span
          class="flex h-6 w-6 items-center justify-center rounded-full {{ $currentStep === 2 ? 'bg-indigo-600 text-white' : 'bg-slate-200 text-slate-500' }} text-xs">2</span>
        Upload Siswa
      </div>
    </div>

    {{-- Error Handler --}}
    @if ($errors->has('npsn_sekolah') && !is_numeric($errors->first('npsn_sekolah')))
      <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-sm text-red-700">
        {{ $errors->first('npsn_sekolah') }}
      </div>
    @endif

    <form wire:submit="submit" method="POST" enctype="multipart/form-data">

      {{-- STEP 1: DATA SEKOLAH & OPERATOR --}}
      @if ($currentStep === 1)
        <div class="animate-fade-in space-y-8">

          {{-- A. IDENTITAS SEKOLAH --}}
          <div class="space-y-5">
            <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
              <div class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-50 text-emerald-600">
                <img src="{{ asset('icon/school.svg') }}" class="w-5 h-5" alt="Icon">
              </div>
              <div>
                <h3 class="font-semibold text-slate-900 text-lg">Identitas Sekolah</h3>
                <p class="text-xs text-slate-500">Cari data sekolah berdasarkan NPSN</p>
              </div>
            </div>

            {{-- Layout Vertikal 1 Kolom --}}
            <div class="grid grid-cols-1 gap-6">

              {{-- NPSN (Input Aktif + Search) --}}
              <div class="space-y-2 relative">
                <x-ui.label for="npsn_sekolah" value="NPSN Sekolah *" />
                <div class="relative">
                  <x-ui.input name="npsn_sekolah" id="npsn_sekolah" type="text" inputmode="numeric" maxlength="8"
                    wire:model.live.debounce.500ms="npsn_sekolah" placeholder="Ketik 8 Digit NPSN (Pencarian Otomatis)"
                    :error="$errors->first('npsn_sekolah')" oninput="this.value = this.value.replace(/[^0-9]/g, '')" autocomplete="off" />

                  {{-- Loading Indicator --}}
                  <div class="absolute right-3 top-2.5" wire:loading wire:target="npsn_sekolah">
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

                {{-- Dropdown Suggestion --}}
                @if ($showSuggestions && count($searchResults) > 0)
                  <div
                    class="absolute z-50 w-full bg-white border border-slate-200 rounded-lg shadow-xl mt-1 max-h-60 overflow-y-auto">
                    <ul class="py-1 text-sm text-slate-700">
                      @foreach ($searchResults as $result)
                        <li
                          class="cursor-pointer hover:bg-indigo-50 px-4 py-3 border-b border-slate-50 last:border-0 transition-colors"
                          wire:click="selectSchool('{{ $result['npsn'] }}', '{{ $result['nama'] }}', '{{ $result['jenjang'] }}', '{{ $result['alamat'] }}', '{{ $result['status'] }}')">
                          <div class="font-semibold text-indigo-700">{{ $result['nama'] }}</div>
                          <div class="text-xs text-slate-500 mt-1">
                            NPSN: {{ $result['npsn'] }} • {{ strtoupper($result['jenjang']) }}
                          </div>
                        </li>
                      @endforeach
                    </ul>
                  </div>
                @elseif($showSuggestions && count($searchResults) == 0)
                  <div
                    class="absolute z-10 w-full bg-white border border-slate-200 rounded-lg shadow-lg mt-1 p-3 text-sm text-slate-500 text-center">
                    Data sekolah tidak ditemukan.
                  </div>
                @endif
              </div>

              {{-- Nama Sekolah (Readonly) --}}
              <div class="space-y-2">
                <x-ui.label for="nama_sekolah" value="Nama Sekolah (Otomatis)" />
                <x-ui.input name="nama_sekolah" id="nama_sekolah" type="text" wire:model="nama_sekolah" readonly
                  class="bg-slate-100 text-slate-500 cursor-not-allowed border-slate-200"
                  placeholder="Terisi otomatis saat NPSN dipilih" :error="$errors->first('nama_sekolah')" />
              </div>

              {{-- Jenjang (Readonly) --}}
              <div class="space-y-2">
                <x-ui.label for="jenjang_sekolah" value="Jenjang (Otomatis)" />
                <x-ui.input name="jenjang_sekolah" id="jenjang_sekolah" type="text" wire:model="jenjang_sekolah"
                  readonly class="bg-slate-100 text-slate-500 cursor-not-allowed border-slate-200" placeholder="-"
                  :error="$errors->first('jenjang_sekolah')" />
              </div>

              {{-- Alamat (Readonly) --}}
              <div class="space-y-2">
                <x-ui.label for="alamat_sekolah" value="Alamat Sekolah (Otomatis)" />
                <textarea wire:model="alamat_sekolah" id="alamat_sekolah" rows="2" readonly
                  class="flex w-full rounded-md border border-slate-200 bg-slate-100 text-slate-500 px-3 py-2 text-sm focus:outline-none cursor-not-allowed"
                  placeholder="-"></textarea>
              </div>

              {{-- Jumlah Perangkat (Editable) --}}
              <div class="space-y-2">
                <div class="flex justify-between items-center">
                  <x-ui.label for="jumlah_perangkat" value="Jumlah Perangkat TKA *" />
                  <span class="text-[10px] text-slate-400 italic">Unit PC/Laptop tersedia</span>
                </div>
                <x-ui.input name="jumlah_perangkat" id="jumlah_perangkat" type="number" wire:model="jumlah_perangkat"
                  placeholder="0" :error="$errors->first('jumlah_perangkat')" />
              </div>
            </div>
          </div>

          {{-- B. DATA OPERATOR --}}
          <div class="space-y-5 pt-4 border-t border-slate-100">
            <div class="flex items-center gap-3">
              <div class="flex h-8 w-8 items-center justify-center rounded-full bg-orange-50 text-orange-600">
                <img src="{{ asset('icon/operator.svg') }}" class="w-4 h-4" alt="Icon">
              </div>
              <h3 class="font-medium text-slate-900">Data Operator</h3>
            </div>

            <div class="grid grid-cols-1 gap-6">
              {{-- Nama Operator --}}
              <div class="space-y-2">
                <x-ui.label for="nama_operator" value="Nama Operator *" />
                <x-ui.input name="nama_operator" id="nama_operator" type="text" wire:model="nama_operator"
                  placeholder="Nama lengkap operator" :error="$errors->first('nama_operator')" />
              </div>

              {{-- No WhatsApp --}}
              <div class="space-y-2">
                <x-ui.label for="no_whatsapp_operator" value="No. WhatsApp Operator *" />
                <div class="relative">
                  <span class="absolute left-3 top-2.5 text-slate-400">
                    <img src="{{ asset('icon/phone.svg') }}" alt="Icon" class="w-4 h-4">
                  </span>
                  <x-ui.input name="no_whatsapp_operator" id="no_whatsapp_operator" type="tel"
                    wire:model="no_whatsapp_operator" placeholder="08xxxxxxxxxx" class="pl-9" :error="$errors->first('no_whatsapp_operator')"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                </div>
              </div>

              {{-- Email Sekolah --}}
              <div class="space-y-2">
                <x-ui.label for="email_sekolah" value="Email Sekolah *" />
                <div class="relative">
                  <span class="absolute left-3 top-2.5 text-slate-400">
                    <img src="{{ asset('icon/mail.svg') }}" alt="Icon" class="w-4 h-4">
                  </span>
                  <x-ui.input name="email_sekolah" id="email_sekolah" type="email" wire:model="email_sekolah"
                    placeholder="email@sekolah.sch.id" class="pl-9" :error="$errors->first('email_sekolah')" />
                </div>
              </div>
            </div>
          </div>

          <div class="pt-6 flex gap-4 border-t border-slate-100">
            <x-ui.button type="button" wire:click="nextStep"
              class="w-full h-12 text-base font-semibold shadow-lg shadow-indigo-200/50" size="lg"
              variant="hero" wire:loading.attr="disabled">
              <span wire:loading.remove>Lanjut ke Upload Siswa</span>
              <span wire:loading class="flex items-center gap-2">
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                  viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                    stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                  </path>
                </svg>
                Memproses...
              </span>
            </x-ui.button>
          </div>
        </div>
      @endif

      {{-- STEP 2: UPLOAD SISWA --}}
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
              {{-- Step A --}}
              <div class="flex items-start gap-4 mb-8 relative">
                <div class="absolute left-4 top-8 bottom-[-20px] w-px bg-slate-200"></div>
                <div
                  class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white border border-slate-200 text-sm font-bold text-slate-600 shadow-sm z-10">
                  1</div>
                <div>
                  <h4 class="text-sm font-semibold text-slate-900">Unduh Template</h4>
                  <p class="text-xs text-slate-500 mb-3">Gunakan template ini.</p>
                  {{-- LINK DOWNLOAD API RELATIF --}}
                  <a href="/api/students/template" target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-white border border-slate-300 shadow-sm text-sm font-medium text-slate-700 hover:text-indigo-600 transition-colors">
                    <img src="{{ asset('icon/download.svg') }}" class="w-4 h-4" alt="Download">
                    Download Template.xlsx
                  </a>
                </div>
              </div>

              {{-- Step B --}}
              <div class="flex items-start gap-4">
                <div
                  class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white border border-slate-200 text-sm font-bold text-slate-600 shadow-sm z-10">
                  2</div>
                <div class="w-full">
                  <h4 class="text-sm font-semibold text-slate-900 mb-1">Upload File</h4>
                  <div class="relative w-full group mt-2">
                    <label for="file_siswa"
                      class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed rounded-xl cursor-pointer transition-all hover:bg-white hover:border-indigo-400 @error('file_siswa') border-red-300 bg-red-50/50 @else border-slate-300 bg-slate-100/50 @enderror">
                      @if ($file_siswa)
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
                          <p class="text-sm font-semibold text-slate-900">{{ $file_siswa->getClientOriginalName() }}
                          </p>
                          <span class="mt-2 text-[10px] text-indigo-600 font-bold bg-indigo-50 px-2 py-1 rounded">Ganti
                            File</span>
                        </div>
                      @else
                        <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center">
                          <img src="{{ asset('icon/upload.svg') }}" class="w-8 h-8 mb-2" alt="Upload">
                          <p class="mb-1 text-sm text-slate-700 font-medium">Klik untuk upload</p>
                          <p class="text-xs text-slate-400">Excel (.xlsx) Max 10MB</p>
                        </div>
                      @endif
                      <input id="file_siswa" name="file_siswa" wire:model="file_siswa" type="file"
                        class="hidden" accept=".xlsx,.xls" />
                    </label>
                  </div>
                  <div class="mt-2 min-h-[20px]">
                    <div wire:loading wire:target="file_siswa"
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
                    @error('file_siswa')
                      <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                  </div>
                </div>
              </div>
            </div>
          </section>

          <div class="pt-6 flex gap-4 border-t border-slate-100">
            <x-ui.button type="button" wire:click="previousStep" variant="outline"
              class="w-1/3 border-slate-300 text-slate-600">Kembali</x-ui.button>
            <x-ui.button class="w-2/3 h-12 text-base font-semibold shadow-lg shadow-indigo-200/50" size="lg"
              variant="hero" wire:loading.attr="disabled">
              <span wire:loading.remove>Submit Pendaftaran</span>
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
