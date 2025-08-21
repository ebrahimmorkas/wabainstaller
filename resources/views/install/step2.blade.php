@extends('install.layout')

@section('content')
@php $v = fn($k,$d=null)=>old($k, $d); @endphp

<div class="text-center mb-8">
  <h2 class="text-2xl font-bold text-gray-800 mb-2">Database Configuration</h2>
  <p class="text-gray-600">Enter your database connection details</p>
</div>

@if($errors->has('db_error'))
  <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
    <div class="flex items-center">
      <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
      </svg>
      <p class="text-red-700 text-sm">{{ $errors->first('db_error') }}</p>
    </div>
  </div>
@endif

@if(!empty($detectError ?? null) && empty($canRunMigrations))
  <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg text-sm text-yellow-800">
    Current .env connection test failed: {{ $detectError }}
  </div>
@endif

@if(session('migrate_output'))
  <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
    <pre class="text-xs whitespace-pre-wrap text-blue-900">{{ session('migrate_output') }}</pre>
  </div>
@endif

{{-- Show the form ONLY if connection is not yet valid --}}
@if(empty($canRunMigrations))
  <form id="db-form" class="space-y-6" method="post" action="{{ route('install.step2') }}">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Database Host</label>
        <input name="db_host" value="{{ $v('db_host', $envHost ?? '127.0.0.1') }}"
               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Database Port</label>
        <input name="db_port" value="{{ $v('db_port', $envPort ?? '3306') }}"
               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent">
      </div>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">Database Name</label>
      <input name="db_name" value="{{ $v('db_name', $envName ?? '') }}"
             class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">Database Username</label>
      <input name="db_user" value="{{ $v('db_user', $envUser ?? 'root') }}"
             class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">Database Password</label>
      <input name="db_pass" type="password" value="{{ $v('db_pass') }}"
             class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent">
    </div>

    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-blue-700 text-sm">
      Make sure the database exists and the user has privileges.
    </div>

    <div class="flex justify-between pt-6">
      <a href="{{ route('install.step1') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-medium">Back</a>
      <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">
        Test, Save & Continue
      </button>
    </div>
  </form>
@else
  {{-- Connection already works: don't ask again. Just proceed. --}}
  <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-green-800 mb-6">
    Database connection verified. You can proceed to the next step.
  </div>

  <div class="flex justify-between pt-2">
    <a href="{{ route('install.step1') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-medium">Back</a>
    <a href="{{ route('install.step3') }}" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">Continue</a>
  </div>
@endif
@endsection
