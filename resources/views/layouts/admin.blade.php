<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TKA Admin System</title>

  {{-- Google Fonts: Inter --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @livewireStyles
</head>

<body class="bg-slate-50 font-sans text-slate-900 antialiased">

  <div class="min-h-screen flex">
    <!-- Sidebar -->
    <!-- Default: Mobile (Hidden), Tablet (Collapsed/Icon), Desktop (Expanded) -->
    <!-- Kelas 'fixed' hanya untuk mobile (<768px). Tablet ke atas pakai 'sticky' atau 'fixed' dengan margin konten yang sesuai.
         Disini kita pakai logic JS untuk toggle width. Default HTML state diset ke Expanded (w-64) untuk Desktop.
    -->
    <aside id="adminSidebar" class="bg-white border-r border-slate-200 fixed inset-y-0 left-0 z-30 flex flex-col transition-all duration-300 ease-in-out -translate-x-full md:translate-x-0 w-64">
      <!-- Logo -->
      <div id="sidebarHeader" class="h-16 flex items-center justify-between px-4 border-b border-slate-200 transition-all duration-300">
        <div id="logoGroup" class="flex items-center gap-3 overflow-hidden whitespace-nowrap transition-all duration-300">
          <div class="w-8 h-8 min-w-[2rem] rounded-lg bg-blue-600 flex items-center justify-center text-white font-bold text-lg">
            T
          </div>
          <span class="sidebar-label text-lg font-bold text-slate-800 transition-opacity duration-200">TKA Admin</span>
        </div>
        <div id="toggleGroup" class="flex items-center gap-2">
          <!-- Desktop Toggle -->
          <button id="toggleSidebar" type="button" class="hidden md:inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-500 hover:bg-slate-100 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
            </svg>
          </button>
          <!-- Mobile Close -->
          <button id="closeSidebarMobile" type="button" class="md:hidden inline-flex items-center justify-center w-9 h-9 rounded-lg text-slate-600 hover:bg-slate-100 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>

      <!-- Navigation -->
      <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto overflow-x-hidden">
        <a href="{{ route('dashboard') }}" 
           class="sidebar-item flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors whitespace-nowrap {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
          <svg class="w-5 h-5 min-w-[1.25rem]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
          </svg>
          <span class="sidebar-label transition-opacity duration-200">Dashboard</span>
        </a>

        <a href="{{ route('registrations') }}" 
           class="sidebar-item flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors whitespace-nowrap {{ request()->routeIs('registrations') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
          <svg class="w-5 h-5 min-w-[1.25rem]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
          </svg>
          <span class="sidebar-label transition-opacity duration-200">Data Pendaftaran</span>
        </a>

        <a href="{{ route('exam-schedules') }}" 
           class="sidebar-item flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors whitespace-nowrap {{ request()->routeIs('exam-schedules') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
          <svg class="w-5 h-5 min-w-[1.25rem]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
          <span class="sidebar-label transition-opacity duration-200">Jadwal Ujian</span>
        </a>

        <a href="{{ route('users') }}" 
           class="sidebar-item flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors whitespace-nowrap {{ request()->routeIs('users') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
          <svg class="w-5 h-5 min-w-[1.25rem]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
          </svg>
          <span class="sidebar-label transition-opacity duration-200">Manajemen Pengguna</span>
        </a>
      </nav>

      <!-- User Profile & Logout -->
      <div class="p-4 border-t border-slate-200">
        <div class="flex items-center gap-3 mb-4 px-2 overflow-hidden whitespace-nowrap">
          <div class="w-8 h-8 min-w-[2rem] rounded-full bg-slate-200 flex items-center justify-center text-slate-600 font-bold text-xs">
            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
          </div>
          <div class="flex-1 min-w-0 sidebar-label transition-opacity duration-200">
            <p class="text-sm font-medium text-slate-900 truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
            <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email ?? 'admin@example.com' }}</p>
          </div>
        </div>
        
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors whitespace-nowrap justify-center sidebar-item">
            <svg class="w-4 h-4 min-w-[1rem]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            <span class="sidebar-label transition-opacity duration-200">Keluar</span>
          </button>
        </form>
      </div>
    </aside>
    <!-- Overlay for mobile -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-20 hidden md:hidden transition-opacity duration-300"></div>

    <!-- Main Content -->
    <!-- Margin kiri disesuaikan dengan JS nanti (md:ml-16 atau md:ml-64) -->
    <main id="adminMain" class="flex-1 w-full md:ml-64 transition-all duration-300 ease-in-out p-4 md:p-8">
      <!-- Mobile topbar -->
      <div class="md:hidden mb-4 flex items-center justify-between">
        <button id="openSidebarMobile" type="button" class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-white border border-slate-200 shadow-sm text-slate-700">
          <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
        <div class="text-sm text-slate-500">
          Admin Panel
        </div>
      </div>
      
      <!-- Container Konten Fluid -->
      <div class="w-full">
        @isset($slot)
          {{ $slot }}
        @else
          @yield('content')
        @endisset
      </div>
    </main>
  </div>

  @livewireScripts
  <script>
    (function () {
      const sidebar = document.getElementById('adminSidebar');
      const main = document.getElementById('adminMain');
      const overlay = document.getElementById('sidebarOverlay');
      const toggleBtn = document.getElementById('toggleSidebar');
      const openMobileBtn = document.getElementById('openSidebarMobile');
      const closeMobileBtn = document.getElementById('closeSidebarMobile');
      
      const sidebarHeader = document.getElementById('sidebarHeader');
      const logoGroup = document.getElementById('logoGroup');

      // Elements that need to be hidden/adjusted on collapse
      const labels = () => document.querySelectorAll('.sidebar-label');
      const items = () => document.querySelectorAll('.sidebar-item');
      
      // State Management
      // Desktop default (> 1024px) is Expanded. Tablet (768-1024) is Collapsed.
      // Logic: If localStorage has a preference, use it.
      // Else, use default based on width.
      
      function getPreferredState() {
        const saved = localStorage.getItem('adminSidebarCollapsed');
        if (saved !== null) {
          return saved === '1';
        }
        // Default: Collapse on tablet (< 1024px), Expand on Desktop (>= 1024px)
        return window.innerWidth < 1024; 
      }

      let collapsed = getPreferredState();
      let mobileOpen = false;

      function updateUI() {
        const isDesktop = window.innerWidth >= 768; // Tablet & Desktop
        
        if (isDesktop) {
          // Reset mobile styles
          sidebar.classList.remove('-translate-x-full'); 
          sidebar.classList.add('translate-x-0'); // Always visible on md+
          overlay.classList.add('hidden');

          if (collapsed) {
            // Collapsed State (w-20 approx 80px)
            sidebar.classList.remove('w-64');
            sidebar.classList.add('w-20');
            
            main.classList.remove('md:ml-64');
            main.classList.add('md:ml-20');

            // Header adjustments for collapsed state
            sidebarHeader.classList.remove('justify-between', 'px-4');
            sidebarHeader.classList.add('justify-center', 'px-2');
            logoGroup.classList.add('hidden'); // Hide logo to save space

            // Hide labels, Center icons
            labels().forEach(el => {
              el.classList.add('opacity-0', 'w-0', 'hidden');
            });
            items().forEach(el => {
              el.classList.add('justify-center', 'px-2'); // Less padding
              el.classList.remove('px-3');
            });
          } else {
            // Expanded State
            sidebar.classList.remove('w-20');
            sidebar.classList.add('w-64');
            
            main.classList.remove('md:ml-20');
            main.classList.add('md:ml-64');

            // Header adjustments for expanded state
            sidebarHeader.classList.remove('justify-center', 'px-2');
            sidebarHeader.classList.add('justify-between', 'px-4');
            logoGroup.classList.remove('hidden');

            // Show labels
            labels().forEach(el => {
              el.classList.remove('opacity-0', 'w-0', 'hidden');
            });
            items().forEach(el => {
              el.classList.remove('justify-center', 'px-2');
              el.classList.add('px-3');
            });
          }
        } else {
          // Mobile State (< 768px)
          // Sidebar is full width (w-64) but off-canvas
          sidebar.classList.remove('w-20');
          sidebar.classList.add('w-64');
          main.classList.remove('md:ml-64', 'md:ml-20'); // No margin on mobile
          
          // Reset Header
          sidebarHeader.classList.remove('justify-center', 'px-2');
          sidebarHeader.classList.add('justify-between', 'px-4');
          logoGroup.classList.remove('hidden');

          // Ensure labels are visible when opened
          labels().forEach(el => {
            el.classList.remove('opacity-0', 'w-0', 'hidden');
          });
          items().forEach(el => {
            el.classList.remove('justify-center', 'px-2');
            el.classList.add('px-3');
          });

          if (mobileOpen) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
          } else {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
          }
        }
      }

      // Initialize
      updateUI();

      // Events
      toggleBtn?.addEventListener('click', function () {
        collapsed = !collapsed;
        localStorage.setItem('adminSidebarCollapsed', collapsed ? '1' : '0');
        updateUI();
      });

      function openMobile() {
        mobileOpen = true;
        updateUI();
      }

      function closeMobile() {
        mobileOpen = false;
        updateUI();
      }

      openMobileBtn?.addEventListener('click', openMobile);
      closeMobileBtn?.addEventListener('click', closeMobile);
      overlay?.addEventListener('click', closeMobile);

      // Handle Resize
      let resizeTimer;
      window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
          // If crossing breakpoint, update collapsed state default if not manually set?
          // For now, just keep user preference or current state, but update UI layout
          if (window.innerWidth >= 768) {
            mobileOpen = false; // Reset mobile state when going to desktop
          }
          updateUI();
        }, 100);
      });
    })();
  </script>
</body>

</html>
