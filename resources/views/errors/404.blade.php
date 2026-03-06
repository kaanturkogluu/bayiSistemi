<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sayfa Bulunamadı - 404</title>

    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 font-sans antialiased flex items-center justify-center min-h-screen p-4">

    <div
        class="max-w-md w-full bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-200 text-center p-10">

        <div class="mb-8 flex justify-center">
            <div class="w-24 h-24 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7"></path>
                </svg>
            </div>
        </div>

        <h1 class="text-6xl font-black text-slate-900 mb-2">404</h1>
        <h2 class="text-2xl font-bold text-slate-800 mb-4">Sayfa Bulunamadı</h2>

        <p class="text-slate-500 mb-8 leading-relaxed">
            Aradığınız sayfa silinmiş, adı değiştirilmiş veya geçici olarak kullanımdışı olabilir.
        </p>

        <a href="{{ url('/admin') }}"
            class="inline-flex items-center justify-center w-full px-6 py-3.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition duration-300 shadow-md hover:shadow-lg focus:ring-4 focus:ring-blue-500/20">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                </path>
            </svg>
            Ana Sayfaya Dön
        </a>
    </div>

</body>

</html>