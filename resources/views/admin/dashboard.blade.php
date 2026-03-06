@extends('layouts.admin')

@section('header', 'Hızlı Erişim')

@section('content')

    @if(Auth::user()->role !== 'usta')
        <!-- Admin/Bayi Dashboard -->
        <!-- Priority Level 1 -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
            <!-- Card 1: Maintenances / Bakımlar (Priority 1) -->
            <a href="{{ route('admin.maintenances.index') }}"
                class="group block h-full bg-white rounded-2xl shadow-sm border border-slate-200 hover:border-purple-500 hover:shadow-md transition-all duration-300 overflow-hidden relative">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                </div>
                <div class="p-6 relative z-10 flex flex-col h-full">
                    <div
                        class="w-14 h-14 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-purple-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-purple-600 transition-colors">Yedek Parça
                        & Bakım</h3>
                    <p class="text-slate-500 text-sm mb-4 flex-1">Araçlara ait onarım, işçilik ve kullanılan parça fişlerini
                        oluşturun.</p>
                    <div class="text-purple-600 font-medium text-sm flex items-center">
                        Bakımlara Git <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Card 2: Customers (Priority 2) -->
            <a href="{{ route('admin.customers.index') }}"
                class="group block h-full bg-white rounded-2xl shadow-sm border border-slate-200 hover:border-emerald-500 hover:shadow-md transition-all duration-300 overflow-hidden relative">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                </div>
                <div class="p-6 relative z-10 flex flex-col h-full">
                    <div
                        class="w-14 h-14 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-emerald-600 transition-colors">Müşteri
                        Yönetimi</h3>
                    <p class="text-slate-500 text-sm mb-4 flex-1">Sisteme kayıtlı müşterileri ve iletişim bilgilerini yönetin.
                    </p>
                    <div class="text-emerald-600 font-medium text-sm flex items-center">
                        Yönetime Git <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Card 3: Cari & Ödeme (NEW) -->
            <a href="{{ route('admin.cari.index') }}"
                class="group block h-full bg-white rounded-2xl shadow-sm border border-slate-200 hover:border-blue-600 hover:shadow-md transition-all duration-300 overflow-hidden relative">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-blue-600/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                </div>
                <div class="p-6 relative z-10 flex flex-col h-full">
                    <div
                        class="w-14 h-14 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-blue-600 transition-colors">Cari & Ödeme
                    </h3>
                    <div class="mb-4 flex-1">
                        <p class="text-slate-500 text-sm mb-2">Müşteri borç-alacak takibi ve tahsilat işlemlerini yönetin.</p>
                        <div
                            class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold {{ $totalBalance > 0 ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-emerald-700' }}">
                            @if($totalBalance > 0)
                                Toplam Bekleyen: {{ number_format($totalBalance, 2, ',', '.') }} ₺
                            @else
                                Tüm Hesaplar Dengede
                            @endif
                        </div>
                    </div>
                    <div class="text-blue-600 font-medium text-sm flex items-center">
                        Hesapları İncele <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>

        </div>

        <!-- Divider -->
        <div class="mb-8 mt-2 flex items-center">
            <div class="h-px bg-slate-200 flex-1"></div>
            <span class="px-4 text-sm text-slate-400 font-medium uppercase tracking-wider">Diğer İşlemler</span>
            <div class="h-px bg-slate-200 flex-1"></div>
        </div>

        <!-- Priority Level 2 -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            <!-- Card 3: User Management -->
            <a href="{{ route('admin.users.index') }}"
                class="group block h-full bg-white rounded-2xl shadow-sm border border-slate-200 hover:border-blue-500 hover:shadow-md transition-all duration-300 overflow-hidden relative">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                </div>
                <div class="p-6 relative z-10 flex flex-col h-full">
                    <div
                        class="w-14 h-14 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-blue-600 transition-colors">Kullanıcı
                        Yönetimi</h3>
                    <p class="text-slate-500 text-sm mb-4 flex-1">Sistemdeki kullanıcıları, rolleri ve izinleri yönetin.</p>
                    <div class="text-blue-600 font-medium text-sm flex items-center">
                        Yönetime Git <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Card 4: Settings -->
            <a href="{{ route('admin.settings.invoice') }}"
                class="group block h-full bg-white rounded-2xl shadow-sm border border-slate-200 hover:border-amber-500 hover:shadow-md transition-all duration-300 overflow-hidden relative">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                </div>
                <div class="p-6 relative z-10 flex flex-col h-full">
                    <div
                        class="w-14 h-14 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-amber-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-amber-600 transition-colors">Fatura
                        Ayarları</h3>
                    <p class="text-slate-500 text-sm mb-4 flex-1">Fatura şablonunda kullanılacak firma, adres ve logo
                        bilgilerini güncelleyin.</p>
                    <div class="text-amber-600 font-medium text-sm flex items-center">
                        Ayarlara Git <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Card 5 (Raporlar) -->
            <a href="#"
                class="group block h-full bg-white rounded-2xl shadow-sm border border-slate-200 hover:border-pink-500 hover:shadow-md transition-all duration-300 overflow-hidden relative">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-pink-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                </div>
                <div class="p-6 relative z-10 flex flex-col h-full">
                    <div
                        class="w-14 h-14 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-pink-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-pink-600 transition-colors">Raporlar</h3>
                    <p class="text-slate-500 text-sm mb-4 flex-1">Sistem istatistikleri ve analiz raporları.</p>
                    <div class="text-pink-600 font-medium text-sm flex items-center">
                        Raporlara Git <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Card 6: Audit Logs / Sistem Kayıtları -->
            <a href="{{ route('admin.audits.index') }}"
                class="group block h-full bg-white rounded-2xl shadow-sm border border-slate-200 hover:border-gray-500 hover:shadow-md transition-all duration-300 overflow-hidden relative">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-gray-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                </div>
                <div class="p-6 relative z-10 flex flex-col h-full">
                    <div
                        class="w-14 h-14 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-gray-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-gray-600 transition-colors">Sistem
                        Kayıtları</h3>
                    <p class="text-slate-500 text-sm mb-4 flex-1">Ekleme, silme ve düzenleme işlemlerinin detaylı denetim
                        kayıtları.</p>
                    <div class="text-gray-600 font-medium text-sm flex items-center">
                        Kayıtları Gör <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>
        </div>
    @endif

    @if(Auth::user()->role === 'usta')
        <!-- Usta (Technician) Dashboard -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Pending Maintenances -->
            <a href="{{ route('admin.usta.maintenances', ['status' => 'bekliyor']) }}"
                class="group block h-full bg-white rounded-2xl shadow-sm border border-slate-200 hover:border-amber-500 hover:shadow-md transition-all duration-300 overflow-hidden relative">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                </div>
                <div class="p-8 relative z-10 flex flex-col items-center text-center h-full">
                    <div
                        class="w-20 h-20 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-amber-500 group-hover:text-white transition-all duration-300 shadow-sm">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-3 group-hover:text-amber-600 transition-colors">Bekleyen
                        Bakımlar</h3>
                    <p class="text-slate-500 text-base mb-6 flex-1">İşlem sırası bekleyen veya devam eden araçları görüntüleyin.
                    </p>
                    <div class="text-amber-600 font-bold text-base flex items-center bg-amber-50 px-4 py-2 rounded-lg">
                        Listeye Git
                        <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Completed Maintenances -->
            <a href="{{ route('admin.usta.maintenances', ['status' => 'tamamlandi']) }}"
                class="group block h-full bg-white rounded-2xl shadow-sm border border-slate-200 hover:border-emerald-500 hover:shadow-md transition-all duration-300 overflow-hidden relative">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                </div>
                <div class="p-8 relative z-10 flex flex-col items-center text-center h-full">
                    <div
                        class="w-20 h-20 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-emerald-500 group-hover:text-white transition-all duration-300 shadow-sm">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-3 group-hover:text-emerald-600 transition-colors">Tamamlanan
                        Bakımlar</h3>
                    <p class="text-slate-500 text-base mb-6 flex-1">Tüm işlemleri ve parça montajları bitmiş olan araçların
                        geçmiş kayıtları.</p>
                    <div class="text-emerald-600 font-bold text-base flex items-center bg-emerald-50 px-4 py-2 rounded-lg">
                        Listeye Git
                        <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>

        </div>
    @endif

@endsection