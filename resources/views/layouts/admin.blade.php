<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Paneli</title>

    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js & Plugins -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- jQuery (Required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body class="bg-slate-50 font-sans antialiased text-slate-800 print:bg-white" x-data="{ mobileMenuOpen: false }">

    <div class="min-h-screen flex flex-col">

        <!-- Top Navigation -->
        <nav class="bg-slate-900 shadow-md sticky top-0 z-40 print:hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">

                    <!-- Left side Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <a href="/admin"
                            class="flex items-center text-white text-xl font-bold uppercase tracking-wider">
                            <svg class="w-8 h-8 mr-2 text-blue-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            BAYİ
                        </a>
                    </div>

                    <!-- Right side User Info & Logout -->
                    <div class="flex items-center space-x-4">
                        <div class="hidden sm:flex flex-col text-right mr-6">
                            <span
                                class="font-bold text-sm leading-tight text-white">{{ ucfirst(Auth::user()->username ?? 'Misafir') }}</span>
                            <span class="text-xs text-slate-400 uppercase">{{ Auth::user()->role ?? '' }}</span>
                        </div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-red-600/10 text-red-500 hover:bg-red-600 hover:text-white rounded-lg text-sm font-medium transition-colors border border-red-500/20">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Çıkış Yap
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <!-- Header replaced by the top navbar, but we keep yield content container -->
        <main
            class="flex-1 w-full max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 print:p-0 print:m-0 print:max-w-none print:w-full">
            <!-- Page Title Area -->
            <div class="mb-4 sm:mb-8 border-b border-slate-200 pb-4 print:hidden">
                <h2 class="text-2xl font-bold leading-7 text-slate-900 sm:text-3xl sm:truncate">
                    @yield('header', 'Dashboard')
                </h2>
            </div>

            @yield('content')
        </main>

        <!-- Footer (Optional) -->
        <footer class="bg-white border-t border-slate-200 mt-auto print:hidden">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <p class="text-center text-sm text-slate-500">
                    &copy; {{ date('Y') }} Servis Yönetim Paneli. Tüm hakları saklıdır.
                </p>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>

</html>