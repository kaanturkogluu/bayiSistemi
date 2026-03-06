<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Yetkisiz Erişim - 403</title>

    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 font-sans antialiased flex items-center justify-center min-h-screen p-4">

    <div
        class="max-w-md w-full bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-200 text-center p-10">

        <div class="mb-8 flex justify-center">
            <div class="w-24 h-24 bg-red-50 text-red-500 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                    </path>
                </svg>
            </div>
        </div>

        <h1 class="text-6xl font-black text-slate-900 mb-2">403</h1>
        <h2 class="text-2xl font-bold text-slate-800 mb-4">Yetkisiz Erişim</h2>

        <p class="text-slate-500 mb-8 leading-relaxed">
            Bu sayfayı görüntülemek için gerekli yetkilere sahip değilsiniz. Sisteme giriş yaptığınız hesabın bu alanda
            izni bulunmuyor.
        </p>

        <a href="javascript:history.back()"
            class="inline-flex items-center justify-center w-full px-6 py-3.5 bg-slate-800 text-white font-semibold rounded-xl hover:bg-slate-900 transition duration-300 shadow-md hover:shadow-lg focus:ring-4 focus:ring-slate-500/20">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Önceki Sayfaya Dön
        </a>
    </div>

</body>

</html>