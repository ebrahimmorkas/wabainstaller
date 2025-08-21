<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Installer</title>

    {{-- Tailwind CDN + same color config as your HTML --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3b82f6', /* blue-500 */
                        secondary: '#1e40af' /* blue-900 */
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-primary rounded-full mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Application Installer</h1>
            <p class="text-gray-600">Let's get your application up and running</p>
        </div>

        {{-- Steps (1..5) with the same look as your HTML --}}
        @php
          $map = ['install.step1'=>1,'install.step2'=>2,'install.step3'=>3,'install.step4'=>4,'install.final'=>5];
          $current = 1; foreach ($map as $r=>$n) if(request()->routeIs($r)){$current=$n;break;}
          $labels = [1=>'System Check',2=>'Database',3=>'License',4=>'Admin',5=>'Complete'];
        @endphp
        <div class="flex justify-center mb-8">
            <div class="flex items-center space-x-4">
                @for($i=1;$i<=5;$i++)
                    <div class="flex items-center">
                        <div class="w-8 h-8 {{ $i==$current ? 'bg-primary text-white' : 'bg-gray-300 text-gray-500' }}
                                    rounded-full flex items-center justify-center text-sm font-medium">{{ $i }}</div>
                        <span class="ml-2 text-sm font-medium {{ $i==$current ? 'text-primary' : 'text-gray-500' }}">
                            {{ $labels[$i] }}
                        </span>
                    </div>
                    @if($i<5)
                        <div class="w-8 h-px bg-gray-300"></div>
                    @endif
                @endfor
            </div>
        </div>

        {{-- Page content goes here --}}
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl p-8">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
