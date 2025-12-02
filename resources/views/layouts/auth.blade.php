<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Auth | JoyMeter')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
</head>
<body class="min-h-screen bg-[#FAEF9F]">
    <div class="flex min-h-screen">
        <div class="hidden lg:flex lg:w-1/2 items-center justify-center bg-gradient-to-b from-[#F7AA4A] to-[#F6821F] p-12">
            <div class="max-w-md text-[#3b2a07]">
                @yield('hero')
            </div>
        </div>

        <div class="flex-1 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-white">
            <div class="w-full max-w-md space-y-10">
                <div class="space-y-4 text-center lg:text-left">
                    <p class="text-sm uppercase tracking-[0.3em] text-gray-400">JoyMeter</p>
                    @yield('auth-title')
                </div>

                @yield('content')

                <div class="text-center text-sm text-gray-600">
                    @yield('auth-footer')
                </div>
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>

