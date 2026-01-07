@extends('layouts.app')

@section('content')
  <div class="min-h-screen bg-background">

    {{-- Header --}}
    <header class="bg-linear-to-r from-[#0a2a66] via-[#0b4f8a] to-[#0b74a5] py-6 px-4 sm:px-6">
      <div class="container mx-auto flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-lg bg-secondary flex items-center justify-center">
            {{-- Icon BookOpen --}}
            <img src="{{ asset('icon/book.svg') }}" alt="Icon Book Open" class="w-6 h-6 text-secondary-foreground">
          </div>
          <div>
            <h1 class="text-primary-foreground font-bold text-lg">TKA Center</h1>
            <p class="text-primary-foreground/70 text-xs">Tes Kemampuan Akademik</p>
          </div>
        </div>
      </div>
    </header>

    {{-- Hero Section --}}
    <section class="bg-linear-to-r from-[#0a2a66] via-[#0b4f8a] to-[#0b74a5] relative overflow-hidden">
      <div class="absolute inset-0 opacity-10">
        <img src="{{ asset('img/general/hero-education.jpg') }}" alt="Education illustration"
          class="w-full h-full object-cover" />
      </div>

      <div class="container mx-auto px-4 sm:px-6 py-16 sm:py-24 relative z-10">
        <div class="max-w-3xl mx-auto text-center animate-fade-in">
          <span class="inline-block bg-yellow-400/10 text-yellow-500 px-4 py-1 rounded-full text-sm font-semibold">
            Pendaftaran Dibuka!
          </span>
          <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-primary-foreground mb-6 leading-tight">
            Pendaftaran Tes Kemampuan Akademik
            <span class="block text-gradient mt-2 text-yellow-500">SD & SMP</span>
          </h1>
          <p class="text-primary-foreground/80 text-lg sm:text-xl max-w-2xl mx-auto mb-32">
            Ukur potensi akademik putra-putri Anda dengan Tes Kemampuan Akademik yang terstandar dan terpercaya.
          </p>
        </div>
      </div>

      {{-- Wave Decoration --}}
      <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
          <path
            d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z"
            fill="var(--color-background)" />
        </svg>
      </div>
    </section>

    {{-- Form Section --}}
    <section class="py-12 sm:py-16 bg-muted/50" id="daftar">
      <div class="container mx-auto px-4 sm:px-6">
        <div class="max-w-2xl mx-auto">
          <div class="text-center mb-8">
            <h2 class="text-2xl sm:text-3xl font-bold text-foreground mb-3">
              Formulir Pendaftaran
            </h2>
            <p class="text-muted-foreground">
              Lengkapi data di bawah ini untuk mendaftarkan siswa
            </p>
          </div>

          {{-- Form Container --}}
          <div class="bg-card rounded-2xl shadow-sm border border-border p-6 sm:p-8 animate-slide-up">
            @livewire('registration-form')
          </div>
        </div>
      </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-linear-to-r from-[#0a2a66] via-[#0b4f8a] to-[#0b74a5] py-8 px-4 sm:px-6">
      <div class="container mx-auto text-center">
        <div class="flex items-center justify-center gap-2 mb-4">
          <div class="w-8 h-8 rounded-lg bg-secondary flex items-center justify-center">
            <svg class="w-4 h-4 text-secondary-foreground" xmlns="http://www.w3.org/2000/svg" width="24"
              height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round">
              <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
              <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
            </svg>
          </div>
          <span class="text-primary-foreground font-bold">TKA Center</span>
        </div>
        <p class="text-primary-foreground/70 text-sm">
          © 2025 Excellent Team. All Rights Reserved.
        </p>
      </div>
    </footer>
  </div>
@endsection
