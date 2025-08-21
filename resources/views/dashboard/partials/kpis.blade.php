<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 lg:gap-6 mb-6 lg:mb-8">
  {{-- Messages Sent Today --}}
  <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 lg:p-6 hover:shadow-md transition-shadow duration-200">
    <div class="flex items-center justify-between mb-4">
      <div class="w-10 lg:w-12 h-10 lg:h-12 bg-whatsapp/10 rounded-lg flex items-center justify-center">
        <i class="fas fa-paper-plane text-whatsapp text-lg lg:text-xl"></i>
      </div>
      <div class="flex items-center space-x-1 text-green-600">
        <i class="fas fa-arrow-up text-sm"></i><span class="text-sm font-medium">+12%</span>
      </div>
    </div>
    <h3 class="text-xs lg:text-sm font-medium text-gray-500">Messages Sent Today</h3>
    <p class="text-xl lg:text-2xl font-bold text-gray-900 mb-1">8,240</p>
    <div class="text-xs text-gray-500">vs yesterday</div>
  </div>

  {{-- Delivery Rate --}}
  <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 lg:p-6 hover:shadow-md transition-shadow duration-200">
    <div class="flex items-center justify-between mb-4">
      <div class="w-10 lg:w-12 h-10 lg:h-12 bg-green-100 rounded-lg flex items-center justify-center">
        <i class="fas fa-check-circle text-green-600 text-lg lg:text-xl"></i>
      </div>
      <div class="flex items-center space-x-1 text-green-600"><i class="fas fa-check text-sm"></i></div>
    </div>
    <h3 class="text-xs lg:text-sm font-medium text-gray-500">Delivery Rate</h3>
    <p class="text-xl lg:text-2xl font-bold text-green-600 mb-1">96.5%</p>
    <div class="text-xs text-gray-500">Excellent</div>
  </div>

  {{-- Active Conversations --}}
  <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 lg:p-6 hover:shadow-md transition-shadow duration-200">
    <div class="flex items-center justify-between mb-4">
      <div class="w-10 lg:w-12 h-10 lg:h-12 bg-blue-100 rounded-lg flex items-center justify-center">
        <i class="fas fa-comments text-blue-600 text-lg lg:text-xl"></i>
      </div>
      <div class="flex items-center space-x-1 text-blue-600"><i class="fas fa-arrow-up text-sm"></i><span class="text-sm font-medium">+8%</span></div>
    </div>
    <h3 class="text-xs lg:text-sm font-medium text-gray-500">Active Conversations</h3>
    <p class="text-xl lg:text-2xl font-bold text-gray-900 mb-1">230</p>
    <div class="text-xs text-gray-500">Currently ongoing</div>
  </div>

  {{-- Campaigns Running --}}
  <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 lg:p-6 hover:shadow-md transition-shadow duration-200">
    <div class="flex items-center justify-between mb-4">
      <div class="w-10 lg:w-12 h-10 lg:h-12 bg-purple-100 rounded-lg flex items-center justify-center">
        <i class="fas fa-bullhorn text-purple-600 text-lg lg:text-xl"></i>
      </div>
      <div class="flex items-center space-x-1 text-orange-600"><i class="fas fa-clock text-sm"></i></div>
    </div>
    <h3 class="text-xs lg:text-sm font-medium text-gray-500">Campaigns Running</h3>
    <p class="text-xl lg:text-2xl font-bold text-gray-900 mb-1">3</p>
    <div class="text-xs text-gray-500">Scheduled: 2, Ongoing: 1</div>
  </div>

  {{-- Template Approvals --}}
  <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 lg:p-6 hover:shadow-md transition-shadow duration-200">
    <div class="flex items-center justify-between mb-4">
      <div class="w-10 lg:w-12 h-10 lg:h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
        <i class="fas fa-file-alt text-yellow-600 text-lg lg:text-xl"></i>
      </div>
      <div class="flex items-center space-x-1 text-green-600"><i class="fas fa-check text-sm"></i></div>
    </div>
    <h3 class="text-xs lg:text-sm font-medium text-gray-500">Template Approvals</h3>
    <p class="text-xl lg:text-2xl font-bold text-gray-900 mb-1">18/20</p>
    <div class="text-xs text-gray-500">2 Pending</div>
  </div>

  {{-- Unread Inbox --}}
  <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 lg:p-6 hover:shadow-md transition-shadow duration-200">
    <div class="flex items-center justify-between mb-4">
      <div class="w-10 lg:w-12 h-10 lg:h-12 bg-red-100 rounded-lg flex items-center justify-center">
        <i class="fas fa-inbox text-red-600 text-lg lg:text-xl"></i>
      </div>
      <div class="flex items-center space-x-1 text-red-600"><i class="fas fa-exclamation text-sm"></i></div>
    </div>
    <h3 class="text-xs lg:text-sm font-medium text-gray-500">Unread Messages</h3>
    <p class="text-xl lg:text-2xl font-bold text-red-600 mb-1">45</p>
    <div class="text-xs text-gray-500">Needs attention</div>
  </div>
</div>
