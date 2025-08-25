@extends('layouts.dashboard')

@section('title','Dashboard')
@section('crumb','Dashboard')
@section('crumb_sub','Overview')

@section('content')
  @if (in_array($stage, ['needs_migration','connection','webhook','numbers']))
      {{-- Show the 4-step wizard --}}
      @include('dashboard.partials.waba-setup', [
        'stage' => $stage,
        'waba' => $waba ?? null,
        'numbers' => $numbers ?? collect(),
        'numbersActive' => $numbersActive ?? 0,
        'templatesCount' => $templatesCount ?? 0,
      ])
  @else
      {{-- Your normal dashboard (what you pasted) --}}
      <div class="mb-6">
        <h1 class="text-xl lg:text-2xl font-bold text-gray-900">Dashboard Overview</h1>
        <p class="text-gray-600 text-sm lg:text-base">Monitor your WhatsApp business performance and analytics</p>
      </div>

      @include('dashboard.partials.kpis')
      @include('dashboard.partials.charts')
      @include('dashboard.partials.tables')
      @include('dashboard.partials.widgets')
  @endif
@endsection

@push('scripts')
  @if (!in_array($stage, ['needs_migration','connection','webhook','numbers']))
    @include('dashboard.partials.chart-js')
  @endif
@endpush
