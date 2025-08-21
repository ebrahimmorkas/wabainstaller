{{-- /resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Login — SimpleWaba</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  {{-- Tailwind (CDN) --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#3b82f6', // blue-500
            secondary: '#1e40af' // blue-900
          }
        }
      }
    }
  </script>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
  <div class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md">
      {{-- Branding --}}
      <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-primary shadow-lg shadow-blue-200/60">
          <svg class="w-8 h-8 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
        </div>
        <h1 class="mt-4 text-2xl font-bold text-gray-800">Welcome to SimpleWaba</h1>
        <p class="text-gray-600">Sign in to your account</p>
      </div>

      {{-- Flash: success / status --}}
      @if (session('status'))
        <div class="mb-4 rounded-lg border border-green-200 bg-green-50 p-3 text-sm text-green-800">
          {{ session('status') }}
        </div>
      @endif

      {{-- Flash: general error --}}
      @if (session('error'))
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-800">
          {{ session('error') }}
        </div>
      @endif

      {{-- Validation error (first) --}}
      @if ($errors->any())
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-800">
          {{ $errors->first() }}
        </div>
      @endif

      {{-- Card --}}
      <div class="rounded-2xl bg-white p-6 shadow-xl ring-1 ring-gray-100">
        <form method="POST" action="{{ url('/login') }}" class="space-y-5">
          @csrf

          <div>
            <label for="email" class="mb-2 block text-sm font-medium text-gray-700">Email</label>
            <input
              id="email"
              name="email"
              type="email"
              value="{{ old('email') }}"
              autocomplete="email"
              required
              class="block w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-900 placeholder-gray-400 shadow-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary"
              placeholder="you@example.com"
            >
          </div>

          <div>
            <label for="password" class="mb-2 block text-sm font-medium text-gray-700">Password</label>
            <input
              id="password"
              name="password"
              type="password"
              required
              autocomplete="current-password"
              class="block w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-900 placeholder-gray-400 shadow-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary"
              placeholder="••••••••"
            >
          </div>

          <div class="flex items-center justify-between">
            <label class="inline-flex items-center gap-2 text-sm text-gray-600">
              <input type="checkbox" name="remember" class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary" {{ old('remember') ? 'checked' : '' }}>
              Remember me
            </label>

            {{-- Optional: update href when you add password reset route --}}
            <a href="{{ url('/password/reset') }}" class="text-sm font-medium text-primary hover:text-secondary">Forgot password?</a>
          </div>

          <button
            type="submit"
            class="inline-flex w-full items-center justify-center rounded-lg bg-primary px-4 py-3 font-medium text-white shadow-sm transition hover:bg-blue-600 focus:outline-none focus:ring-4 focus:ring-blue-200"
          >
            Sign in
          </button>
        </form>

        {{-- Optional footer --}}
        <p class="mt-6 text-center text-sm text-gray-600">
          Don’t have an account?
          <a href="{{ url('/register') }}" class="font-medium text-primary hover:text-secondary">Create one</a>
        </p>
      </div>

      {{-- Small footer note --}}
      <p class="mt-6 text-center text-xs text-gray-500">
        &copy; {{ date('Y') }} SimpleWaba. All rights reserved.
      </p>
    </div>
  </div>
</body>
</html>
