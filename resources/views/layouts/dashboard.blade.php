{{-- Base layout for the app dashboard (Tailwind + Chart.js + FontAwesome) --}}
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title','Dashboard') — SimpleWaba</title>

  {{-- Tailwind + Chart.js + FontAwesome --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            'whatsapp': '#25D366',
            'whatsapp-dark': '#128C7E',
            'emerald-glow': '#10B981',
            'royal-blue': '#3B82F6',
            'sunset-orange': '#F97316'
          }
        }
      }
    }
  </script>

  @stack('head')
</head>
<body class="h-full bg-gray-50 font-sans">
  {{-- Mobile overlay for sidebar --}}
  <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden hidden"></div>

  {{-- Sidebar --}}
  @include('partials.aside')

  {{-- Page wrapper --}}
  <div class="lg:ml-64 flex flex-col min-h-screen">
    {{-- Top navbar --}}
    @include('partials.nav')

    {{-- Main content area --}}
    <main class="flex-1 p-4 lg:p-6">
      @yield('content')
    </main>
  </div>

  {{-- Common behaviors used by nav/aside --}}
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const mobileMenuButton = document.getElementById('mobile-menu-button');
      const sidebar = document.getElementById('sidebar');
      const sidebarOverlay = document.getElementById('sidebar-overlay');
      const sidebarClose = document.getElementById('sidebar-close');

      function closeSidebar(){ sidebar.classList.add('-translate-x-full'); sidebarOverlay.classList.add('hidden'); }
      function openSidebar(){ sidebar.classList.remove('-translate-x-full'); sidebarOverlay.classList.remove('hidden'); }

      if (mobileMenuButton) mobileMenuButton.addEventListener('click', openSidebar);
      if (sidebarClose) sidebarClose.addEventListener('click', closeSidebar);
      if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeSidebar);

      // Sidebar submenus
      const toggles = document.querySelectorAll('.menu-toggle');
      toggles.forEach(t => {
        t.addEventListener('click', function() {
          const submenu = this.nextElementSibling;
          const chevron = this.querySelector('.fa-chevron-right');
          // close others
          toggles.forEach(o => { if (o!==this){ const s=o.nextElementSibling; const c=o.querySelector('.fa-chevron-right'); s?.classList?.add('hidden'); c?.classList?.remove('rotate-90'); }});
          submenu?.classList?.toggle('hidden'); chevron?.classList?.toggle('rotate-90');
        });
      });

      // Dropdowns
      const els = {
        profileMenuBtn: document.getElementById('profile-menu-button'),
        profileDropdown: document.getElementById('profile-dropdown'),
        navbarProfileBtn: document.getElementById('navbar-profile-button'),
        navbarProfileDropdown: document.getElementById('navbar-profile-dropdown'),
        notifBtn: document.getElementById('notification-button'),
        notifDropdown: document.getElementById('notification-dropdown')
      };
      function closeDrops(){ els.profileDropdown?.classList?.add('hidden'); els.navbarProfileDropdown?.classList?.add('hidden'); els.notifDropdown?.classList?.add('hidden'); }
      els.profileMenuBtn?.addEventListener('click', (e)=>{ e.stopPropagation(); els.profileDropdown?.classList?.toggle('hidden'); els.navbarProfileDropdown?.classList?.add('hidden'); els.notifDropdown?.classList?.add('hidden');});
      els.navbarProfileBtn?.addEventListener('click', (e)=>{ e.stopPropagation(); els.navbarProfileDropdown?.classList?.toggle('hidden'); els.profileDropdown?.classList?.add('hidden'); els.notifDropdown?.classList?.add('hidden');});
      els.notifBtn?.addEventListener('click', (e)=>{ e.stopPropagation(); els.notifDropdown?.classList?.toggle('hidden'); els.profileDropdown?.classList?.add('hidden'); els.navbarProfileDropdown?.classList?.add('hidden');});
      document.addEventListener('click', closeDrops);
    });
  </script>

  @stack('scripts')
</body>
</html>
