<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Oturum Süresi Doldu - 419</title>

    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 font-sans antialiased flex items-center justify-center min-h-screen p-4">

    <div
        class="max-w-md w-full bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-200 text-center p-10">

        <div class="mb-8 flex justify-center">
            <div class="w-24 h-24 bg-amber-50 text-amber-500 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <h1 class="text-6xl font-black text-slate-900 mb-2">419</h1>
        <h2 class="text-2xl font-bold text-slate-800 mb-4">Oturum Süresi Doldu</h2>

        <p class="text-slate-500 mb-8 leading-relaxed">
            Güvenliğiniz nedeniyle uzun süre işlem yapılmadığı için oturumunuz sonlandırılmıştır. Lütfen sayfayı
            yenileyiniz veya tekrar giriş yapınız.
        </p>

        <a href="{{ route('login') }}"
            class="inline-flex items-center justify-center w-full px-6 py-3.5 bg-amber-500 text-white font-semibold rounded-xl hover:bg-amber-600 transition duration-300 shadow-md hover:shadow-lg focus:ring-4 focus:ring-amber-500/20">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                </path>
            </svg>
            Sayfayı Yenile ve Giriş Yap
        </a>
    </div>

</body>

</html>