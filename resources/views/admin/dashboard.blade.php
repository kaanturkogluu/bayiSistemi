@extends('layouts.admin')

@section('header', 'Hızlı Erişim')

@section('content')
<script>
function errorReportComponent() {
    return {
        reportModalOpen: false,
        reportDescription: '',
        isSubmitting: false,
        async submitErrorReport() {
            if (this.reportDescription.length < 10) {
                alert('Lütfen en az 10 karakterlik bir açıklama yazın.');
                return;
            }
            
            this.isSubmitting = true;
            const formData = new FormData();
            formData.append('description', this.reportDescription);
            const screenshotInput = document.getElementById('reportScreenshot');
            if (screenshotInput && screenshotInput.files.length > 0) {
                formData.append('screenshot', screenshotInput.files[0]);
            }
            formData.append('_token', '{{ csrf_token() }}');

            try {
                const response = await fetch('{{ route('admin.error_report.store') }}', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();
                
                if (data.success) {
                    alert(data.message);
                    this.reportModalOpen = false;
                    this.reportDescription = '';
                    if (screenshotInput) screenshotInput.value = '';
                } else {
                    alert(data.message || 'Bir hata oluştu.');
                }
            } catch (error) {
                alert('Bir iletişim hatası oluştu. Lütfen bağlantınızı kontrol edin.');
            } finally {
                this.isSubmitting = false;
            }
        }
    }
}
</script>
<div x-data="errorReportComponent()">


    {{-- ── Bilgilendirme Bildirimi ─────────────────────────── --}}
    <div
        x-data="{ show: !localStorage.getItem('howto_notice_v2_dismissed') }"
        x-show="show"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        style="display:none; background-color: #4f46e5;"
        class="mb-6 flex items-start gap-4 text-white rounded-2xl p-4 shadow-lg border border-indigo-400/20"
    >
        {{-- İkon --}}
        <div class="flex-shrink-0 w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9.663 17h4.674M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
            </svg>
        </div>

        {{-- Metin --}}
        <div class="flex-1 min-w-0">
            <p class="font-bold text-sm leading-tight">📋 Kullanım Kılavuzu Güncellendi!</p>
            <p class="text-white/80 text-xs mt-0.5 leading-relaxed">
                Sistemin tüm modüllerini (Bakım, Motor Stok, Satış, Cari, Kullanıcı Yönetimi vb.) adım adım anlatan
                detaylı kılavuz yenilendi. Mutlaka inceleyin!
            </p>
            <a href="{{ route('admin.how_to_use') }}"
               style="color: #4338ca;"
               class="inline-flex items-center gap-1.5 mt-2 bg-white text-xs font-bold px-3 py-1.5 rounded-lg hover:bg-indigo-50 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Kılavuzu İncele →
            </a>
        </div>

        {{-- Kapat butonu --}}
        <button
            @click="show = false; localStorage.setItem('howto_notice_v2_dismissed', '1')"
            class="flex-shrink-0 w-7 h-7 bg-white/10 hover:bg-white/25 rounded-lg flex items-center justify-center transition-colors"
            title="Kapat"
        >
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

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
                        class="w-14 h-14 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-purple-200 transition-all duration-300">
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
                        class="w-14 h-14 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-emerald-200 transition-all duration-300">
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
                        class="w-14 h-14 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-blue-200 transition-all duration-300">
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

            <!-- Card 4: Motor Satışı (NEW) -->
            <a href="{{ route('admin.motorcycle-sales.index') }}"
                class="group block h-full bg-white rounded-2xl shadow-sm border border-slate-200 hover:border-emerald-600 hover:shadow-md transition-all duration-300 overflow-hidden relative">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-emerald-600/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                </div>
                <div class="p-6 relative z-10 flex flex-col h-full">
                    <div
                        class="w-14 h-14 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-emerald-200 transition-all duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04M12 2.944a11.955 11.955 0 01-8.618 3.04m16.732 3.04A11.955 11.955 0 0112 11a11.955 11.955 0 01-6.114-1.976M12 11a11.955 11.955 0 01-6.114-1.976m11.228 1.976A11.955 11.955 0 0112 21.056a11.955 11.955 0 01-9.112-4.056M12 21.056a11.955 11.955 0 01-9.112-4.056">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-emerald-600 transition-colors">Motor Satışı</h3>
                    <div class="mb-4 flex-1">
                        <p class="text-slate-500 text-sm mb-2">Stoktaki motorları müşterilere satın ve satış kaydı oluşturun.</p>
                    </div>
                    <div class="text-emerald-600 font-medium text-sm flex items-center">
                        Satış Yap / Geçmiş <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform"
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

            <!-- Card 2.5: Motorcycles (Inventory) -->
            <a href="{{ route('admin.motorcycles.index') }}"
                class="group block h-full bg-white rounded-2xl shadow-sm border border-slate-200 hover:border-indigo-500 hover:shadow-md transition-all duration-300 overflow-hidden relative">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                </div>
                <div class="p-6 relative z-10 flex flex-col h-full">
                    <div
                        class="w-14 h-14 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-indigo-200 transition-all duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-indigo-600 transition-colors">Motorlar (Stok)</h3>
                    <div class="mb-4 flex-1">
                        <p class="text-slate-500 text-sm mb-2">Motosiklet ve envanter stok durumunu yönetin.</p>
                        <div class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-indigo-100 text-indigo-700">
                            Toplam Stok: {{ $motorcycleCount }} Adet
                        </div>
                    </div>
                    <div class="text-indigo-600 font-medium text-sm flex items-center">
                        Stokları Gör <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Card 3: User Management -->
            <a href="{{ route('admin.users.index') }}"
                class="group block h-full bg-white rounded-2xl shadow-sm border border-slate-200 hover:border-blue-500 hover:shadow-md transition-all duration-300 overflow-hidden relative">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                </div>
                <div class="p-6 relative z-10 flex flex-col h-full">
                    <div
                        class="w-14 h-14 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-blue-200 transition-all duration-300">
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
                        class="w-14 h-14 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-amber-200 transition-all duration-300">
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

            <!-- Card 5 (Nasıl Kullanılır?) -->
            <a href="{{ route('admin.how_to_use') }}"
                class="group block h-full bg-white rounded-2xl shadow-sm border border-slate-200 hover:border-amber-500 hover:shadow-md transition-all duration-300 overflow-hidden relative">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                </div>
                <div class="p-6 relative z-10 flex flex-col h-full">
                    <div
                        class="w-14 h-14 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-amber-200 transition-all duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.663 17h4.674a1 1 0 0 1 .922.617l.334.834A1 1 0 0 1 14.674 20H9.326a1 1 0 0 1-.922-.549l-.334-.834A1 1 0 0 1 8.992 18h.671m4.674-1a10.04 10.04 0 0 0 3-7.5A10 10 0 1 0 5.177 15.303 3.23 3.23 0 0 0 8 18h8a3.23 3.23 0 0 0 2.823-2.697 10.04 10.04 0 0 0-3-7.5l-2.163 2.163">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-amber-600 transition-colors">Nasıl
                        Kullanılır?</h3>
                    <div class="text-slate-500 text-xs space-y-2 flex-1">
                        <p class="flex items-start gap-2">
                            <span
                                class="w-4 h-4 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center text-[10px] shrink-0 mt-0.5">1</span>
                            <span>Müşteri ve araç kaydını oluşturun.</span>
                        </p>
                        <p class="flex items-start gap-2">
                            <span
                                class="w-4 h-4 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center text-[10px] shrink-0 mt-0.5">2</span>
                            <span>"Servis Oluştur" ile yeni bakım kaydı açın.</span>
                        </p>
                        <p class="flex items-start gap-2">
                            <span
                                class="w-4 h-4 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center text-[10px] shrink-0 mt-0.5">3</span>
                            <span>Bakımı tamamlayın ve ödemeyi (cari) kaydedin.</span>
                        </p>
                    </div>
                </div>
            </a>

            <!-- Card 6: Data Center / Veri Merkezi -->
            <a href="{{ route('admin.data_center.index') }}"
                class="group block h-full bg-white rounded-2xl shadow-sm border border-slate-200 hover:border-indigo-500 hover:shadow-md transition-all duration-300 overflow-hidden relative">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                </div>
                <div class="p-6 relative z-10 flex flex-col h-full">
                    <div
                        class="w-14 h-14 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-indigo-200 transition-all duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-indigo-600 transition-colors">Veri
                        Merkezi</h3>
                    <p class="text-slate-500 text-sm mb-4 flex-1">Marka, Renk ve Model tanımlamalarını tek merkezden yönetin.
                    </p>
                    <div class="text-indigo-600 font-medium text-sm flex items-center">
                        Merkeze Git <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Card 7: Audit Logs / Sistem Kayıtları -->
            <a href="{{ route('admin.audits.index') }}"
                class="group block h-full bg-white rounded-2xl shadow-sm border border-slate-200 hover:border-gray-500 hover:shadow-md transition-all duration-300 overflow-hidden relative">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-gray-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                </div>
                <div class="p-6 relative z-10 flex flex-col h-full">
                    <div
                        class="w-14 h-14 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-gray-200 transition-all duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-gray-600 transition-colors">Sistem Kayıtları</h3>
                    <p class="text-slate-500 text-sm mb-4 flex-1">Ekleme, silme ve düzenleme işlemlerinin detaylı denetim kayıtları.</p>
                    <div class="text-gray-600 font-medium text-sm flex items-center">
                        Kayıtları Gör <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Card 8: Report Error / Hata Bildir -->
            <button @click="reportModalOpen = true"
                class="group block w-full text-left h-full bg-white rounded-2xl shadow-sm border border-slate-200 hover:border-red-500 hover:shadow-md transition-all duration-300 overflow-hidden relative">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-red-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                </div>
                <div class="p-6 relative z-10 flex flex-col h-full">
                    <div
                        class="w-14 h-14 rounded-full bg-red-100 text-red-600 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-red-200 transition-all duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-red-600 transition-colors">Hata Bildir</h3>
                    <p class="text-slate-500 text-sm mb-4 flex-1">Sistemde karşılaştığınız hataları ekran görüntüsü ile bildirin.</p>
                    <div class="text-red-600 font-medium text-sm flex items-center">
                        Bildirim Yap <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </button>

        </div>
    @endif

    @if(Auth::user()->role === 'usta')
        <!-- Usta (Technician) Dashboard -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">


            <!-- Pending Maintenances -->
            <a href="{{ route('admin.usta.maintenances', ['status' => 'bekliyor']) }}"
                class="group block h-full bg-white rounded-2xl shadow-sm border border-slate-200 hover:border-amber-500 hover:shadow-md transition-all duration-300 overflow-hidden relative">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                </div>
                <div class="p-8 relative z-10 flex flex-col items-center text-center h-full">
                    <div
                        class="w-20 h-20 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-amber-200 transition-all duration-300 shadow-sm">
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
                        class="w-20 h-20 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-emerald-200 transition-all duration-300 shadow-sm">
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

            <!-- Card 3: Report Error / Hata Bildir (Usta) -->
            <button @click="reportModalOpen = true"
                class="group block w-full text-left h-full bg-white rounded-2xl shadow-sm border border-slate-200 hover:border-red-500 hover:shadow-md transition-all duration-300 overflow-hidden relative">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-red-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                </div>
                <div class="p-8 relative z-10 flex flex-col items-center text-center h-full">
                    <div
                        class="w-20 h-20 rounded-full bg-red-100 text-red-600 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-red-200 transition-all duration-300 shadow-sm">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-3 group-hover:text-red-600 transition-colors">Hata Bildir</h3>
                    <p class="text-slate-500 text-base mb-6 flex-1">Sistem hatalarını ekran görüntüsü ile bildirin.
                    </p>
                    <div class="text-red-600 font-bold text-base flex items-center bg-red-50 px-4 py-2 rounded-lg">
                        Bildirim Yap
                        <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </button>


        </div>
    @endif

    <!-- Error Report Modal -->
    <div x-show="reportModalOpen" 
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="absolute inset-0 transition-opacity" aria-hidden="true" @click="reportModalOpen = false">
                <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-200 relative z-10"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                
                <div class="bg-white px-6 py-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                            <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            Hata Bildir
                        </h3>
                        <button @click="reportModalOpen = false" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form @submit.prevent="submitErrorReport">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Hata Açıklaması</label>
                                <textarea x-model="reportDescription" required minlength="10" rows="4" 
                                          class="w-full rounded-xl border-slate-200 border bg-slate-50 focus:border-red-500 focus:ring-red-500 text-sm p-3 transition-all"
                                          placeholder="Karşılaştığınız sorunu lütfen detaylıca açıklayın..."></textarea>
                                <p class="text-[10px] text-slate-400 mt-1">Lütfen en az 10 karakter yazın.</p>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Ekran Görüntüsü (Opsiyonel)</label>
                                <div class="relative">
                                    <input type="file" id="reportScreenshot" accept="image/*"
                                           class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 cursor-pointer border border-dashed border-slate-300 rounded-xl p-1">
                                </div>
                                <p class="text-[10px] text-slate-400 mt-1">Resim formatında (jpg, png) ve maks 5MB olmalıdır.</p>
                            </div>
                        </div>

                        <div class="mt-8 flex gap-3">
                            <button type="button" @click="reportModalOpen = false"
                                    class="flex-1 px-4 py-3 bg-slate-100 text-slate-700 rounded-xl font-bold hover:bg-slate-200 transition-all">
                                Vazgeç
                            </button>
                            <button type="submit" :disabled="isSubmitting"
                                    class="flex-1 px-4 py-3 bg-red-600 text-white rounded-xl font-bold hover:bg-red-700 transition-all disabled:opacity-50 flex items-center justify-center gap-2 shadow-lg shadow-red-200">
                                <template x-if="isSubmitting">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </template>
                                <span x-text="isSubmitting ? 'Gönderiliyor...' : 'Bildirimi Gönder'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection