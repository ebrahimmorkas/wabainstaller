<div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
  {{-- Messages Over Time --}}
  <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-6">
      <h3 class="text-lg font-semibold text-gray-900">Messages Over Time</h3>
      <div class="flex items-center space-x-4 text-sm">
        <div class="flex items-center space-x-2"><div class="w-3 h-3 bg-whatsapp rounded-full"></div><span class="text-gray-600">Sent</span></div>
        <div class="flex items-center space-x-2"><div class="w-3 h-3 bg-blue-500 rounded-full"></div><span class="text-gray-600">Delivered</span></div>
        <div class="flex items-center space-x-2"><div class="w-3 h-3 bg-green-500 rounded-full"></div><span class="text-gray-600">Read</span></div>
      </div>
    </div>
    <div class="h-64"><canvas id="messagesChart"></canvas></div>
  </div>

  {{-- Template Usage --}}
  <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-6"><h3 class="text-lg font-semibold text-gray-900">Template Usage</h3></div>
    <div class="h-64 flex items-center justify-center"><canvas id="templateChart"></canvas></div>
    <div class="mt-4 space-y-2">
      <div class="flex items-center justify-between text-sm"><div class="flex items-center space-x-2"><div class="w-3 h-3 bg-green-500 rounded-full"></div><span class="text-gray-600">Approved</span></div><span class="font-medium">70%</span></div>
      <div class="flex items-center justify-between text-sm"><div class="flex items-center space-x-2"><div class="w-3 h-3 bg-yellow-500 rounded-full"></div><span class="text-gray-600">Drafts</span></div><span class="font-medium">20%</span></div>
      <div class="flex items-center justify-between text-sm"><div class="flex items-center space-x-2"><div class="w-3 h-3 bg-red-500 rounded-full"></div><span class="text-gray-600">Rejected</span></div><span class="font-medium">10%</span></div>
    </div>
  </div>
</div>
