@extends('install.layout')

@section('content')
@php
  $extFails    = array_filter(($results ?? []), fn($ok)=>$ok===false);
  $folderFails = array_filter(($folders ?? []), fn($ok)=>$ok===false);
  $allOk = ($phpOk ?? false) && empty($extFails) && empty($folderFails);

  $check = '<div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center">
              <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
            </div>';
  $cross = '<div class="w-6 h-6 bg-red-100 rounded-full flex items-center justify-center">
              <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </div>';
@endphp

<div class="text-center mb-8">
  <h2 class="text-2xl font-bold text-gray-800 mb-2">System Requirements Check</h2>
  <p class="text-gray-600">We're checking if your server meets the requirements</p>
</div>

<div class="space-y-6">
  {{-- PHP Version --}}
  <div class="border border-gray-200 rounded-lg p-4">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">PHP Version</h3>
    <div class="flex items-center justify-between">
      <span class="text-gray-600">PHP {{ config('installer.min_php','8.1') }} or higher required</span>
      <div class="flex items-center">
        <span class="text-sm text-gray-500 mr-2">PHP {{ $phpVersion }}</span>
        {!! $phpOk ? $check : $cross !!}
      </div>
    </div>
  </div>

  {{-- Extensions --}}
  <div class="border border-gray-200 rounded-lg p-4">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">PHP Extensions</h3>
    <div class="space-y-3">
      @foreach($results as $ext => $ok)
        <div class="flex items-center justify-between">
          <span class="text-gray-600">{{ ucfirst($ext) }} Extension</span>
          {!! $ok ? $check : $cross !!}
        </div>
      @endforeach
    </div>
  </div>

  {{-- Folders --}}
  <div class="border border-gray-200 rounded-lg p-4">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Folder Permissions</h3>
    <div class="space-y-3">
      @foreach($folders as $path => $ok)
        <div class="flex items-center justify-between">
          <span class="text-gray-600">{{ str_replace(base_path(), '', $path) }} {{ $ok ? '(writable)' : '(not writable)' }}</span>
          {!! $ok ? $check : $cross !!}
        </div>
      @endforeach
    </div>
  </div>
</div>

@if(!$allOk)
  <div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-lg">
    <div class="flex items-center">
      <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
      <p class="text-red-700 text-sm">Some requirements are not met. Please fix the issues above before continuing.</p>
    </div>
  </div>
@endif

<form method="post" action="{{ url()->current() }}" class="flex justify-between mt-8">
  @csrf
  <button type="button" onclick="location.reload()"
          class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
    Retry Check
  </button>

  <button type="submit"
          class="px-8 py-3 {{ $allOk ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-400 cursor-not-allowed' }} text-white rounded-lg font-medium"
          {{ $allOk ? '' : 'disabled' }}>
    Continue
  </button>
</form>
@endsection
