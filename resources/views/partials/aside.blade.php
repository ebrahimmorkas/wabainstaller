{{-- Sidebar /resources/views/partials/aside.blade.php --}}
<div id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg border-r border-gray-200 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
  {{-- Logo --}}
  <div class="flex items-center justify-between h-16 px-6 border-b border-gray-200">
    <div class="flex items-center space-x-3">
      <div class="w-8 h-8 bg-whatsapp rounded-lg flex items-center justify-center">
        <i class="fab fa-whatsapp text-white text-lg"></i>
      </div>
      <span class="text-xl font-bold text-gray-900">WhatsApp Panel</span>
    </div>
    <button id="sidebar-close" class="p-1 rounded-md hover:bg-gray-100 lg:hidden">
      <i class="fas fa-times text-gray-500"></i>
    </button>
  </div>

  {{-- Quick Access --}}
  <div class="px-6 py-4 border-b border-gray-100">
    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Quick Access</h3>
    <div class="flex space-x-2">
      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-whatsapp/10 text-whatsapp">
        <i class="fas fa-inbox mr-1"></i> Inbox
      </span>
      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
        <i class="fas fa-bullhorn mr-1"></i> Campaigns
      </span>
    </div>
  </div>

  {{-- Nav (scrollable) --}}
  <div class="flex-1 flex flex-col">
    <nav class="flex-1 px-4 py-4 space-y-2 overflow-y-auto">
      {{-- Dashboard --}}
      <div class="space-y-1">
        <a href="{{ route('dashboard') }}" class="bg-whatsapp/10 text-whatsapp group flex items-center px-3 py-2 text-sm font-medium rounded-md">
          <i class="fas fa-chart-line mr-3 text-whatsapp"></i> Dashboard
        </a>
        <div class="ml-6 space-y-1">
          <a href="{{ route('dashboard') }}" class="text-whatsapp bg-whatsapp/5 group flex items-center px-3 py-1.5 text-xs rounded-md">Overview</a>
          <a href="#" class="text-gray-600 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-3 py-1.5 text-xs rounded-md">Real-time Activity</a>
        </div>
      </div>

      {{-- Collapsible sections (Messaging, Campaigns, etc.) --}}
      <div class="space-y-1">
        <button class="menu-toggle text-gray-700 hover:text-gray-900 hover:bg-gray-50 group flex items-center w-full px-3 py-2 text-sm font-medium rounded-md">
          <i class="fas fa-comments mr-3 text-gray-400"></i> Messaging
          <i class="fas fa-chevron-right ml-auto text-gray-400 transform transition-transform duration-200"></i>
        </button>
        <div class="submenu ml-6 space-y-1 hidden">
          <a href="#" class="text-gray-600 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-3 py-1.5 text-xs rounded-md">Inbox</a>
          <a href="#" class="text-gray-600 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-3 py-1.5 text-xs rounded-md">Sent Messages</a>
          <a href="#" class="text-gray-600 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-3 py-1.5 text-xs rounded-md">Scheduled</a>
        </div>
      </div>

      <div class="space-y-1">
        <button class="menu-toggle text-gray-700 hover:text-gray-900 hover:bg-gray-50 group flex items-center w-full px-3 py-2 text-sm font-medium rounded-md">
          <i class="fas fa-bullhorn mr-3 text-gray-400"></i> Campaigns
          <span class="ml-auto bg-blue-100 text-blue-800 text-xs font-medium px-2 py-0.5 rounded-full mr-2">3</span>
          <i class="fas fa-chevron-right text-gray-400 transform transition-transform duration-200"></i>
        </button>
        <div class="submenu ml-6 space-y-1 hidden">
          <a href="#" class="text-gray-600 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-3 py-1.5 text-xs rounded-md">Active Campaigns</a>
          <a href="#" class="text-gray-600 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-3 py-1.5 text-xs rounded-md">Create New</a>
          <a href="#" class="text-gray-600 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-3 py-1.5 text-xs rounded-md">Campaign History</a>
        </div>
      </div>

      <div class="space-y-1">
        <button class="menu-toggle text-gray-700 hover:text-gray-900 hover:bg-gray-50 group flex items-center w-full px-3 py-2 text-sm font-medium rounded-md">
          <i class="fas fa-file-alt mr-3 text-gray-400"></i> Templates
          <i class="fas fa-chevron-right ml-auto text-gray-400 transform transition-transform duration-200"></i>
        </button>
        <div class="submenu ml-6 space-y-1 hidden">
          <a href="#" class="text-gray-600 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-3 py-1.5 text-xs rounded-md">All Templates</a>
          <a href="#" class="text-gray-600 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-3 py-1.5 text-xs rounded-md">Create Template</a>
          <a href="#" class="text-gray-600 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-3 py-1.5 text-xs rounded-md">Approval Status</a>
        </div>
      </div>

      <div class="space-y-1">
        <button class="menu-toggle text-gray-700 hover:text-gray-900 hover:bg-gray-50 group flex items-center w-full px-3 py-2 text-sm font-medium rounded-md">
          <i class="fas fa-chart-bar mr-3 text-gray-400"></i> Reports
          <i class="fas fa-chevron-right ml-auto text-gray-400 transform transition-transform duration-200"></i>
        </button>
        <div class="submenu ml-6 space-y-1 hidden">
          <a href="#" class="text-gray-600 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-3 py-1.5 text-xs rounded-md">Message Analytics</a>
          <a href="#" class="text-gray-600 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-3 py-1.5 text-xs rounded-md">Campaign Reports</a>
          <a href="#" class="text-gray-600 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-3 py-1.5 text-xs rounded-md">Export Data</a>
        </div>
      </div>

      <div class="space-y-1">
        <button class="menu-toggle text-gray-700 hover:text-gray-900 hover:bg-gray-50 group flex items-center w-full px-3 py-2 text-sm font-medium rounded-md">
          <i class="fas fa-tools mr-3 text-gray-400"></i> Tools
          <i class="fas fa-chevron-right ml-auto text-gray-400 transform transition-transform duration-200"></i>
        </button>
        <div class="submenu ml-6 space-y-1 hidden">
          <a href="#" class="text-gray-600 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-3 py-1.5 text-xs rounded-md">Contact Manager</a>
          <a href="#" class="text-gray-600 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-3 py-1.5 text-xs rounded-md">Bulk Import</a>
          <a href="#" class="text-gray-600 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-3 py-1.5 text-xs rounded-md">API Integration</a>
        </div>
      </div>

      <div class="space-y-1">
        <button class="menu-toggle text-gray-700 hover:text-gray-900 hover:bg-gray-50 group flex items-center w-full px-3 py-2 text-sm font-medium rounded-md">
          <i class="fas fa-cog mr-3 text-gray-400"></i> System
          <i class="fas fa-chevron-right ml-auto text-gray-400 transform transition-transform duration-200"></i>
        </button>
        <div class="submenu ml-6 space-y-1 hidden">
          <a href="#" class="text-gray-600 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-3 py-1.5 text-xs rounded-md">Settings</a>
          <a href="#" class="text-gray-600 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-3 py-1.5 text-xs rounded-md">User Management</a>
          <a href="#" class="text-gray-600 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-3 py-1.5 text-xs rounded-md">Backup & Restore</a>
        </div>
      </div>
    </nav>

    {{-- User box --}}
    <div class="border-t border-gray-200 p-4 mt-auto">
      <div class="flex items-center space-x-3">
        <div class="w-8 h-8 bg-gradient-to-r from-whatsapp to-emerald-glow rounded-full flex items-center justify-center">
          <span class="text-white text-sm font-medium">{{ auth()->user()->name[0] ?? 'U' }}</span>
        </div>
        <div class="flex-1 min-w-0">
          <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
          <p class="text-xs text-gray-500 truncate">Admin</p>
        </div>
        <div class="relative">
          <button id="profile-menu-button" class="p-1 rounded-md hover:bg-gray-100">
            <i class="fas fa-ellipsis-v text-gray-400"></i>
          </button>
          <div id="profile-dropdown" class="absolute bottom-full right-0 mb-2 w-48 bg-white rounded-md shadow-lg border border-gray-200 hidden z-50">
            <div class="py-1">
              <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"><i class="fas fa-user mr-3 text-gray-400"></i> Profile Settings</a>
              <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"><i class="fas fa-key mr-3 text-gray-400"></i> Change Password</a>
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
</div>
