<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
  {{-- Live Feed --}}
  <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-6">
      <h3 class="text-lg font-semibold text-gray-900">Live Feed</h3>
      <div class="flex items-center space-x-2"><div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div><span class="text-xs text-gray-500">Live</span></div>
    </div>
    <div class="space-y-3 max-h-64 overflow-y-auto">
      {{-- sample items --}}
      <div class="flex items-center space-x-3 p-2 bg-green-50 rounded-lg"><i class="fas fa-arrow-down text-green-600 text-sm"></i><div class="flex-1"><p class="text-sm text-gray-900">New message from Rajesh Sharma</p><p class="text-xs text-gray-500">2 seconds ago</p></div></div>
      <div class="flex items-center space-x-3 p-2 bg-blue-50 rounded-lg"><i class="fas fa-paper-plane text-blue-600 text-sm"></i><div class="flex-1"><p class="text-sm text-gray-900">Template sent to 50 contacts</p><p class="text-xs text-gray-500">1 minute ago</p></div></div>
      <div class="flex items-center space-x-3 p-2 bg-yellow-50 rounded-lg"><i class="fas fa-exclamation-triangle text-yellow-600 text-sm"></i><div class="flex-1"><p class="text-sm text-gray-900">Campaign delivery delayed</p><p class="text-xs text-gray-500">3 minutes ago</p></div></div>
    </div>
  </div>

  {{-- Quick Actions --}}
  <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-6"><h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3></div>
    <div class="grid grid-cols-2 gap-4">
      <button class="flex flex-col items-center justify-center p-4 bg-whatsapp/10 hover:bg-whatsapp/20 rounded-lg transition-colors duration-200"><i class="fas fa-bullhorn text-whatsapp text-2xl mb-2"></i><span class="text-sm font-medium text-gray-900">Start Campaign</span></button>
      <button class="flex flex-col items-center justify-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors duration-200"><i class="fas fa-user-plus text-blue-600 text-2xl mb-2"></i><span class="text-sm font-medium text-gray-900">Add Contact</span></button>
      <button class="flex flex-col items-center justify-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors duration-200"><i class="fas fa-upload text-purple-600 text-2xl mb-2"></i><span class="text-sm font-medium text-gray-900">Upload Media</span></button>
      <button class="flex flex-col items-center justify-center p-4 bg-orange-50 hover:bg-orange-100 rounded-lg transition-colors duration-200"><i class="fas fa-file-alt text-orange-600 text-2xl mb-2"></i><span class="text-sm font-medium text-gray-900">New Template</span></button>
    </div>
  </div>

  {{-- Monthly Target --}}
  <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-6"><h3 class="text-lg font-semibold text-gray-900">Monthly Target</h3><span class="text-sm text-gray-500">August 2024</span></div>
    <div class="text-center">
      <div class="relative w-32 h-32 mx-auto mb-4">
        <svg class="w-32 h-32 transform -rotate-90" viewBox="0 0 36 36">
          <path class="text-gray-200" stroke="currentColor" stroke-width="3" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"></path>
          <path class="text-whatsapp" stroke="currentColor" stroke-width="3" fill="none" stroke-linecap="round" stroke-dasharray="75, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"></path>
        </svg>
        <div class="absolute inset-0 flex items-center justify-center"><div><div class="text-2xl font-bold text-gray-900">75%</div><div class="text-xs text-gray-500">Complete</div></div></div>
      </div>
      <div class="space-y-2">
        <div class="flex justify-between text-sm"><span class="text-gray-600">Target</span><span class="font-medium">100,000</span></div>
        <div class="flex justify-between text-sm"><span class="text-gray-600">Achieved</span><span class="font-medium text-whatsapp">75,240</span></div>
        <div class="flex justify-between text-sm"><span class="text-gray-600">Remaining</span><span class="font-medium text-gray-900">24,760</span></div>
      </div>
    </div>
  </div>
</div>
