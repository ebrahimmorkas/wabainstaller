{{-- Top navbar /resources/views/partials/nav.blade.php --}}
<header class="bg-white shadow-sm border-b border-gray-200">
  <div class="px-4 lg:px-6 py-4">
    <div class="flex items-center justify-between">
      <div class="flex items-center space-x-4">
        <button id="mobile-menu-button" class="p-2 rounded-md hover:bg-gray-100 lg:hidden">
          <i class="fas fa-bars text-gray-500"></i>
        </button>

        {{-- Breadcrumb --}}
        <nav class="flex" aria-label="Breadcrumb">
          <ol class="flex items-center space-x-2">
            <li><i class="fas fa-home text-gray-400 text-sm"></i></li>
            <li class="flex items-center">
              <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
              <span class="text-sm font-medium text-whatsapp">@yield('crumb','Dashboard')</span>
            </li>
            @hasSection('crumb_sub')
              <li class="hidden sm:flex items-center">
                <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                <span class="text-sm text-gray-500">@yield('crumb_sub')</span>
              </li>
            @endif
          </ol>
        </nav>
      </div>

      <div class="flex items-center space-x-2 lg:space-x-4">
        {{-- Search (md+) --}}
        <div class="relative hidden md:block">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <i class="fas fa-search text-gray-400"></i>
          </div>
          <input type="text" placeholder="Search contacts, campaigns, templates..."
                 class="block w-64 lg:w-80 pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-whatsapp focus:border-whatsapp">
        </div>

        {{-- Mobile search --}}
        <button class="p-2 text-gray-400 hover:text-gray-500 md:hidden"><i class="fas fa-search"></i></button>

        {{-- Notifications --}}
        <div class="relative">
          <button id="notification-button" class="p-2 text-gray-400 hover:text-gray-500 relative">
            <i class="fas fa-bell text-lg"></i>
            <span class="absolute -top-1 -right-1 h-4 w-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
          </button>
          <div id="notification-dropdown" class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg border border-gray-200 hidden z-50">
            <div class="p-4 border-b border-gray-100">
              <h3 class="text-sm font-medium text-gray-900">Notifications</h3>
            </div>
            <div class="max-h-64 overflow-y-auto">
              {{-- …sample items (left from your HTML)… --}}
              <div class="p-3 hover:bg-gray-50 border-b border-gray-50">
                <div class="flex items-start space-x-3">
                  <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center"><i class="fas fa-check text-green-600 text-sm"></i></div>
                  <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">Template Approved</p>
                    <p class="text-xs text-gray-500">Your "Welcome Message" template has been approved</p>
                    <p class="text-xs text-gray-400 mt-1">2 minutes ago</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="p-3 border-t border-gray-100">
              <a href="#" class="text-sm text-whatsapp hover:text-whatsapp/80">View all notifications</a>
            </div>
          </div>
        </div>

        {{-- Profile button --}}
        <div class="relative">
          <button id="navbar-profile-button" class="flex items-center space-x-2 p-2 rounded-md hover:bg-gray-50">
            <div class="w-8 h-8 bg-gradient-to-r from-whatsapp to-emerald-glow rounded-full flex items-center justify-center">
              <span class="text-white text-sm font-medium">{{ auth()->user()->name[0] ?? 'U' }}</span>
            </div>
            <span class="hidden sm:block text-sm font-medium text-gray-700">{{ auth()->user()->name ?? 'Admin' }}</span>
            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
          </button>
          <div id="navbar-profile-dropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-gray-200 hidden z-50">
            <div class="py-1">
              <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"><i class="fas fa-user mr-3 text-gray-400"></i> Profile Settings</a>
              <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"><i class="fas fa-cog mr-3 text-gray-400"></i> Account Settings</a>
              <div class="border-t border-gray-100"></div>
              <form method="post" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                  <i class="fas fa-sign-out-alt mr-3 text-red-400"></i> Sign Out
                </button>
              </form>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</header>
