@extends('layouts.dashboard')

@section('title','Dashboard')
@section('crumb','Dashboard')
@section('crumb_sub','Overview')

@section('content')
  {{-- Title --}}
  <div class="mb-6">
    <h1 class="text-xl lg:text-2xl font-bold text-gray-900">Dashboard Overview</h1>
    <p class="text-gray-600 text-sm lg:text-base">Monitor your WhatsApp business performance and analytics</p>
  </div>

  {{-- KPI CARDS (verbatim from your HTML) --}}
  @include('dashboard.partials.kpis')

  {{-- CHARTS + WIDGETS --}}
  @include('dashboard.partials.charts')

  {{-- TABLES --}}
  @include('dashboard.partials.tables')

  {{-- LIVE/QUICK/AIM --}}
  @include('dashboard.partials.widgets')
@endsection

@push('scripts')
  {{-- Chart initializers (from your HTML) --}}
  @include('dashboard.partials.chart-js')
@endpush
