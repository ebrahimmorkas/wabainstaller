@extends('layouts.app') {{-- your existing layout that already includes sidebar + nav --}}

@section('content')
  {{-- Show the wizard when not ready --}}
  @if ($stage !== 'ready')
    @include('dashboard.partials.waba-setup', [
      'stage' => $stage,
      'waba' => $waba,
      'numbers' => $numbers ?? collect(),
      'numbersActive' => $numbersActive ?? 0,
      'templatesCount' => $templatesCount ?? 0,
      'verification' => $verification ?? null,
    ])
  @else
    {{-- Your normal dashboard widgets here --}}
    <div class="p-6">
      <div class="grid md:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl shadow p-4">
          <div class="text-xs text-gray-500">Account</div>
          <div class="font-semibold">{{ $waba->name }}</div>
          <div class="text-xs text-gray-500">WABA ID: {{ $waba->waba_id }}</div>
        </div>
        <div class="bg-white rounded-xl shadow p-4">
          <div class="text-xs text-gray-500">Active Numbers</div>
          <div class="text-2xl font-bold">{{ $numbersActive }}</div>
        </div>
        <div class="bg-white rounded-xl shadow p-4">
          <div class="text-xs text-gray-500">Templates</div>
          <div class="text-2xl font-bold">{{ $templatesCount }}</div>
        </div>
      </div>
    </div>
  @endif
@endsection
