@extends('layouts.admin')

@section('header', 'Bakım Kaydı Detayı')

@section('content')
    <!-- ACTION BUTTONS -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 print:hidden">
        <div class="flex items-center">
            <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('admin.maintenances.index') }}"
                class="inline-flex items-center px-3 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 hover:text-blue-600 mr-4 transition-colors shadow-sm">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Geri Dön
            </a>
            <h1 class="text-2xl font-bold text-slate-800">Bakım Kaydı: <span
                    class="text-slate-500 text-xl font-medium">#{{ str_pad($maintenance->id, 5, '0', STR_PAD_LEFT) }}</span>
            </h1>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.maintenances.edit', $maintenance) }}"
                class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-lg font-medium text-slate-700 hover:bg-slate-50 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                </svg>
                Düzenle
            </a>
            @if($maintenance->status === 'bekliyor')
                <form action="{{ route('admin.maintenances.complete', $maintenance) }}" method="POST" class="inline-block"
                    onsubmit="return confirm('Bu bakımı ve tüm parçalarını tamamlandı olarak işaretlemek istediğinize emin misiniz?');">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg font-medium text-white hover:bg-emerald-700 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Bakımı Tamamla
                    </button>
                </form>
            @endif
            <button onclick="window.print()"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-medium text-white hover:bg-blue-700 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                    </path>
                </svg>
                Yazdır / Fatura Al
            </button>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- NORMAL SCREEN VIEW (Original Look) -->
    <!-- ========================================== -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden print:hidden">
        <!-- Header Info block -->
        <div class="p-6 sm:p-8 grid grid-cols-1 md:grid-cols-2 gap-6 border-b border-slate-200 bg-slate-50">
            <div>
                <!-- Customer Details -->
                <h2 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-3">Müşteri Bilgileri</h2>
                <p class="text-lg font-bold text-slate-900 mb-1">
                    {{ $maintenance->customer?->name_surname ?? 'Bilinmeyen / Silinmiş Müşteri' }}</p>
                <p class="text-slate-600 flex items-center mb-2">
                    <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                        </path>
                    </svg>
                    {{ $maintenance->customer->phone ?? 'Telefon Belirtilmemiş' }}
                </p>
                @if($maintenance->vehicle)
                    <p class="text-slate-600 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-800 uppercase border border-slate-200">
                            {{ $maintenance->vehicle->plate }}
                        </span>
                    </p>
                @endif
            </div>

            <div class="md:text-right">
                <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Bakım Detayları</h3>
                <div class="text-slate-600 text-sm grid grid-cols-2 md:grid-cols-none gap-2 md:gap-0 justify-end">
                    @if($maintenance->km)
                    <div class="flex md:justify-end py-1">
                        <span class="font-medium mr-2">Araç Kilometresi:</span>
                        {{ number_format($maintenance->km, 0, ',', '.') }} KM
                    </div>
                    @endif
                    <div class="flex md:justify-end py-1">
                        <span class="font-medium mr-2">Oluşturulma:</span>
                        {{ $maintenance->created_at->format('d.m.Y H:i') }}
                    </div>
                    @if($maintenance->status === 'tamamlandi' && $maintenance->completedBy)
                        <div class="flex md:justify-end py-1 text-emerald-600">
                            <span class="font-medium mr-2">Tamamlayan Usta:</span>
                            {{ $maintenance->completedBy->username ?? 'Araç Kabul' }}
                        </div>
                    @endif
                    <div class="flex md:justify-end py-1">
                        <span class="font-medium mr-2">Kayıt No:</span>
                        #{{ str_pad($maintenance->id, 5, '0', STR_PAD_LEFT) }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Parts Table Block -->
        <div class="px-6 sm:px-8 py-6">
            <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                    </path>
                </svg>
                Kullanılan Parçalar ve Ücretler
            </h2>

            <!-- Mobile friendly table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead>
                        <tr class="bg-slate-50">
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider rounded-l-lg">
                                Parça Adı</th>
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Açıklama</th>
                            <th scope="col"
                                class="px-4 py-3 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Miktar</th>
                            <th scope="col"
                                class="px-4 py-3 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Birim Fiyat</th>
                            <th scope="col"
                                class="px-4 py-3 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider rounded-r-lg">
                                Tutar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($maintenance->parts as $part)
                            <tr>
                                <td class="px-4 py-4 text-sm font-medium text-slate-900 align-top">{{ $part->name }}</td>
                                <td class="px-4 py-4 text-sm text-slate-500 max-w-xs truncate align-top">
                                    {{ $part->note ?? '-' }}</td>
                                <td class="px-4 py-4 text-sm text-slate-900 text-right align-top">{{ $part->quantity }}</td>
                                <td class="px-4 py-4 text-sm text-slate-500 text-right align-top">
                                    {{ number_format($part->unit_price, 2, ',', '.') }} ₺</td>
                                <td class="px-4 py-4 text-sm font-medium text-slate-900 text-right align-top">
                                    {{ number_format($part->quantity * $part->unit_price, 2, ',', '.') }} ₺</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-sm text-slate-500 italic">Bu bakıma ait parça
                                    kaydı bulunmuyor. Sadece işçilik ücreti yazılmış.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Summary Block -->
            <div class="mt-8 flex flex-col md:flex-row justify-end items-start md:items-end">
                <div class="w-full md:w-80 bg-slate-50 rounded-xl p-5 border border-slate-100">
                    <div class="flex justify-between py-2 text-sm text-slate-600 border-b border-dashed border-slate-200">
                        <span>Parçalar Ara Toplam:</span>
                        @php
                            $partsTotal = $maintenance->parts->sum(function ($p) {
                                return $p->quantity * $p->unit_price;
                            });
                        @endphp
                        <span class="font-medium text-slate-900">{{ number_format($partsTotal, 2, ',', '.') }} ₺</span>
                    </div>
                    <div class="flex justify-between py-2 text-sm text-slate-600 border-b border-dashed border-slate-200">
                        <span>İşçilik Ücreti:</span>
                        <span class="font-medium text-slate-900">{{ number_format($maintenance->labor_cost, 2, ',', '.') }}
                            ₺</span>
                    </div>
                    <div
                        class="flex justify-between py-3 mt-1 items-center bg-blue-50/50 -mx-5 px-5 -mb-5 rounded-b-xl border-t border-blue-100">
                        <span class="text-base font-bold text-slate-900">Genel Toplam:</span>
                        <span
                            class="text-xl font-black text-blue-700">{{ number_format($maintenance->total_cost, 2, ',', '.') }}
                            ₺</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ========================================== -->
    <!-- INVOICE PRINT VIEW (Hidden on screen)    -->
    <!-- ========================================== -->
    @php
        $setting = \App\Models\InvoiceSetting::first();
    @endphp
    <div class="hidden print:block w-full max-w-[21cm] mx-auto bg-white" style="font-family: Arial, sans-serif;">

        <!-- Header: Logo/Company & Title -->
        <div class="flex justify-between items-start mb-6">
            <div class="w-2/3">
                <h1 class="text-[#3b82f6] text-2xl font-bold uppercase tracking-wide">
                    {{ $setting->company_name ?? 'MOTO JET YETKİLİ SERVİS' }}</h1>
                <div class="text-[#1e293b] text-xs mt-3 leading-tight font-medium space-y-1">
                    <p>Adres: {{ $setting->address ?? 'Bülbülzade mahallesi yeşilvadi bulvarı no 97/D' }}</p>
                    <p>Şehir: {{ $setting->city ?? 'GAZİANTEP / ŞAHİNBEY' }}</p>
                    <p>Tel: {{ $setting->phone ?? '+90 546 132 01 06' }}</p>
                    <p>Email: {{ $setting->email ?? 'info@motojetservis.com' }}</p>
                </div>
            </div>
            <div class="w-1/3 flex flex-col items-end pt-2">
                @if($setting && $setting->logo_path)
                    <div class="w-24 h-24 mb-4 flex items-center justify-center">
                        <img src="{{ Storage::url($setting->logo_path) }}" alt="Logo"
                            class="max-w-full max-h-full object-contain" />
                    </div>
                @else
                    <div
                        class="w-24 h-24 mb-4 border border-gray-300 rounded-full flex items-center justify-center bg-gray-50 text-[10px] text-gray-400 text-center">
                        [LOGO YERİ]
                    </div>
                @endif
                <div class="text-right text-[#64748b] text-xs space-y-1">
                    <p>Tarih: {{ date('d.m.Y') }}</p>
                    <p>Servis Tarihi: {{ $maintenance->created_at->format('d.m.Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Thick Blue Divider -->
        <div class="h-1.5 w-full bg-[#1d4ed8] mb-6 rounded-sm print:bg-slate-800"></div>

        <!-- Customer Block -->
        <div class="bg-[#f8fafc] p-4 mb-6 border border-gray-100 rounded-sm print:bg-transparent print:border-slate-300">
            <h3 class="text-[#3b82f6] font-bold text-xs uppercase mb-3 print:text-slate-800">MÜŞTERİ BİLGİLERİ</h3>
            <div class="text-[#1e293b] text-xs space-y-1.5 font-medium print:text-black">
                <p>Müşteri Adı: <span
                        class="font-normal">{{ mb_strtoupper($maintenance->customer?->name_surname ?? 'Silinmiş Müşteri') }}</span>
                </p>
                <p>Telefon: <span class="font-normal">{{ $maintenance->customer?->phone ?? '—' }}</span></p>
                <p>Plaka: <span class="font-normal">{{ $maintenance->vehicle?->plate ?? '—' }}</span></p>
            </div>
        </div>

        <!-- Blue Table Header & Body -->
        <table class="w-full text-left border-collapse text-xs mb-1">
            <thead>
                <tr
                    class="bg-[#007bff] text-white print:bg-transparent print:text-black print:border-b-2 print:border-slate-800">
                    <th class="py-2.5 px-3 font-semibold text-center w-8">#</th>
                    <th class="py-2.5 px-2 font-semibold">Parça Adı</th>
                    <th class="py-2.5 px-2 font-semibold text-center w-20">Adet</th>
                    <th class="py-2.5 px-2 font-semibold text-right w-24">Birim Fiyat</th>
                    <th class="py-2.5 px-3 font-semibold text-right w-28">Toplam</th>
                </tr>
            </thead>
            <tbody class="text-[#1e293b] font-medium print:text-black">
                @php $index = 1; @endphp
                @forelse ($maintenance->parts as $part)
                    <tr class="border-b border-gray-200 print:border-slate-300">
                        <td class="py-2.5 px-3 text-center text-[#64748b] print:text-slate-600">{{ $index++ }}</td>
                        <td class="py-2.5 px-2">{{ mb_strtoupper($part->name) }}</td>
                        <td class="py-2.5 px-2 text-center">{{ $part->quantity }}</td>
                        <td class="py-2.5 px-2 text-right">{{ number_format($part->unit_price, 2, '.', ',') }} ₺</td>
                        <td class="py-2.5 px-3 text-right">{{ number_format($part->quantity * $part->unit_price, 2, '.', ',') }}
                            ₺</td>
                    </tr>
                @empty
                @endforelse

                @if($maintenance->labor_cost > 0)
                    <tr class="border-b border-gray-200 print:border-slate-300">
                        <td class="py-2.5 px-3 text-center text-[#64748b] print:text-slate-600">{{ $index++ }}</td>
                        <td class="py-2.5 px-2 text-[#334155] font-bold print:text-black">İŞÇİLİK</td>
                        <td class="py-2.5 px-2 text-center">1</td>
                        <td class="py-2.5 px-2 text-right">{{ number_format($maintenance->labor_cost, 2, '.', ',') }} ₺</td>
                        <td class="py-2.5 px-3 text-right">{{ number_format($maintenance->labor_cost, 2, '.', ',') }} ₺</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Calculation Area -->
        <div class="flex justify-end pt-4 pb-4">
            <div class="w-64 text-xs font-bold text-[#334155] print:text-black">
                <div class="flex justify-between py-1">
                    <span>Parça Toplamı:</span>
                    @php
                        $partsTotal = $maintenance->parts->sum(function ($p) {
                            return $p->quantity * $p->unit_price; });
                    @endphp
                    <span>{{ number_format($partsTotal, 2, '.', ',') }} ₺</span>
                </div>
                <div class="flex justify-between py-1 print:mb-2 text-[#334155] print:text-black">
                    <span>İşçilik Ücreti:</span>
                    <span>{{ number_format($maintenance->labor_cost, 2, '.', ',') }} ₺</span>
                </div>
            </div>
        </div>

        <!-- Thick Blue Divider -->
        <div class="h-0.5 w-full bg-[#007bff] mb-4 print:bg-slate-800"></div>

        <!-- Grand Total -->
        <div class="flex justify-end items-center text-[#007bff] mb-8 print:text-black">
            <span class="text-sm font-bold mr-4 uppercase tracking-wide">TOPLAM TUTAR:</span>
            <span class="text-xl font-bold">{{ number_format($maintenance->total_cost, 2, '.', ',') }} ₺</span>
        </div>

        <!-- Info / Warning Block -->
        <div
            class="bg-[#f0f8ff] p-3 rounded-sm text-[#334155] text-[11px] font-medium mb-12 print:bg-transparent print:border print:border-slate-300">
            <p class="font-bold flex items-center mb-0.5 text-[#334155] text-xs print:text-black">
                <span class="mr-1 text-sm">⚠</span> ÖDEME BEKLİYOR
            </p>
            <p class="text-[#334155] font-normal leading-tight ml-[18px] print:text-black">Lütfen ödeme yapınız.</p>
        </div>

        <!-- Footer -->
        <div class="text-center text-[#64748b] text-[10px] leading-tight pt-16 mt-24 print:text-black">
            <p class="font-bold mb-0.5 text-[#334155] print:text-black">Teşekkür ederiz!</p>
            <p>{{ $setting->company_name ?? 'Motojet Servis' }} - Güvenilir Teknik Servis Hizmetleri</p>
            <p>Bu fatura elektronik ortamda oluşturulmuştur.</p>
        </div>
    </div>
@endsection