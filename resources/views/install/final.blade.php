@extends('install.layout')

@section('content')
<h2 class="text-lg font-semibold">Installation Complete 🎉</h2>
<p class="mt-4">You can now <a href="{{ url('/login') }}" class="text-emerald-600 underline">login</a> with your admin credentials.</p>
@endsection
