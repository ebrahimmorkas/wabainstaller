@extends('install.layout')

@section('content')
@php
  // Tailwind + layout already applied from your base. We just render the form/status.
@endphp

<div class="text-center mb-8">
  <h2 class="text-2xl font-bold text-gray-800 mb-2">License Verification</h2>
  <p class="text-gray-600">Enter your Codecanyon purchase code to verify your license</p>
</div>

{{-- Info card (where to find code) --}}
<div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-6 mb-6">
  <div class="flex items-start">
    <svg class="w-6 h-6 text-blue-600 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <div>
      <h3 class="font-semibold text-blue-800 mb-2">Where to find your purchase code?</h3>
      <ul class="text-sm text-blue-700 space-y-1">
        <li>• Log in to your Codecanyon account</li>
        <li>• Go to Downloads section</li>
        <li>• Click "Download" next to this item</li>
        <li>• Select "License certificate &amp; purchase code"</li>
      </ul>
    </div>
  </div>
</div>

{{-- Success flash (if you decide to set one; currently we redirect to step4 immediately) --}}
@if(session('success'))
  <div class="p-4 bg-green-50 border border-green-200 rounded-lg mb-6">
    <div class="flex items-center">
      <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
      </svg>
      <p class="text-green-700 text-sm">{{ session('success') }}</p>
    </div>
  </div>
@endif

{{-- Error message (failed verify or server error) --}}
@if(session('error'))
  <div class="p-4 bg-red-50 border border-red-200 rounded-lg mb-6">
    <div class="flex items-center">
      <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
      <p class="text-red-700 text-sm">{{ session('error') }}</p>
    </div>
  </div>
@endif

@if($errors->any())
  <div class="p-4 bg-red-50 border border-red-200 rounded-lg mb-6">
    <div class="flex items-start">
      <svg class="w-5 h-5 text-red-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
      <div class="text-red-700 text-sm">
        {{ $errors->first() }}
      </div>
    </div>
  </div>
@endif

<form method="post" action="{{ route('install.step3.verify') }}" class="space-y-6">
  @csrf
  <div>
    <label for="purchase_code" class="block text-sm font-medium text-gray-700 mb-2">Purchase Code</label>
    <input type="text" id="purchase_code" name="purchase_code"
           value="{{ old('purchase_code') }}"
           placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx"
           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors font-mono text-sm">
    <p class="text-xs text-gray-500 mt-2">Format: xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx</p>
  </div>

  <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
    <div class="flex items-start">
      <input type="checkbox" id="terms" name="terms" class="mt-1 mr-3 text-primary focus:ring-primary" {{ old('terms') ? 'checked' : '' }}>
      <label for="terms" class="text-sm text-gray-600">
        I agree that this license will be registered to this domain and IP address.
        <a href="#" class="text-primary hover:underline">View license terms</a>
      </label>
    </div>
  </div>

  <div class="flex justify-between pt-6">
    <a href="{{ route('install.step2') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
      <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
      </svg>
      Back
    </a>
    <button type="submit" class="px-8 py-3 bg-primary text-white rounded-lg hover:bg-secondary transition-colors font-medium">
      Verify License
      <svg class="w-4 h-4 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
      </svg>
    </button>
  </div>
</form>
@endsection
