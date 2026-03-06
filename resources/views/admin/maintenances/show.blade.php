@extends('layouts.admin')

@section('header', 'Bakım Kaydı Detayı')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div class="flex items-center">
            <a href="{{ route('admin.maintenances.index') }}" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 hover:text-blue-600 mr-4 transition-colors shadow-sm">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Geri Dön
            </a>
            <h1 class="text-2xl font-bold text-slate-800">Bakım Kaydı: <span class="text-slate-500 text-xl font-medium">#{{ str_pad($maintenance->id, 5, '0', STR_PAD_LEFT) }}</span></h1>
        </div>
        <div>
            <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-slate-800 border border-transparent rounded-lg font-medium text-white hover:bg-slate-900 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900">
                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Yazdır
            </button>
        </div>
    </div>

    <!-- Main Print Box Container -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden print:shadow-none print:border-none">
        
        <!-- Header Info block -->
        <div class="p-6 sm:p-8 grid grid-cols-1 md:grid-cols-2 gap-6 border-b border-slate-200 bg-slate-50">
            <div>
                <!-- Customer Details -->
                <h2 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-3">Müşteri Bilgileri</h2>
                <p class="text-lg font-bold text-slate-900 mb-1">{{ $maintenance->customer->name_surname ?? 'Bilinmeyen / Silinmiş Müşteri' }}</p>
                <p class="text-slate-600 flex items-center mb-2">
                    <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    {{ $maintenance->customer->phone ?? 'Telefon Belirtilmemiş' }}
                </p>
                @if($maintenance->vehicle)
                <p class="text-slate-600 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-800 uppercase border border-slate-200">
                        {{ $maintenance->vehicle->plate }}
                    </span>
                </p>
                @endif
            </div>
            
            <div class="md:text-right">
                <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Bakım Detayları</h3>
                <div class="text-slate-600 text-sm grid grid-cols-2 md:grid-cols-none gap-2 md:gap-0 justify-end">
                    <div class="flex md:justify-end py-1">
                        <span class="font-medium mr-2">Oluşturulma:</span> {{ $maintenance->created_at->format('d.m.Y H:i') }}
                    </div>
                    <div class="flex md:justify-end py-1">
                        <span class="font-medium mr-2">Fatura No:</span> #{{ str_pad($maintenance->id, 6, '0', STR_PAD_LEFT) }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Parts Table Block -->
        <div class="px-6 sm:px-8 py-6">
            <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                Kullanılan Parçalar ve Ücretler
            </h2>

            <!-- Mobile friendly table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead>
                        <tr class="bg-slate-50">
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider rounded-l-lg">Parça Adı</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Açıklama</th>
                            <th scope="col" class="px-4 py-3 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">Miktar</th>
                            <th scope="col" class="px-4 py-3 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">Birim Fiyat</th>
                            <th scope="col" class="px-4 py-3 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider rounded-r-lg">Tutar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($maintenance->parts as $part)
                        <tr>
                            <td class="px-4 py-4 text-sm font-medium text-slate-900 align-top">{{ $part->name }}</td>
                            <td class="px-4 py-4 text-sm text-slate-500 max-w-xs truncate align-top">{{ $part->note ?? '-' }}</td>
                            <td class="px-4 py-4 text-sm text-slate-900 text-right align-top">{{ $part->quantity }}</td>
                            <td class="px-4 py-4 text-sm text-slate-500 text-right align-top">{{ number_format($part->unit_price, 2, ',', '.') }} ₺</td>
                            <td class="px-4 py-4 text-sm font-medium text-slate-900 text-right align-top">{{ number_format($part->quantity * $part->unit_price, 2, ',', '.') }} ₺</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-sm text-slate-500 italic">Bu bakıma ait parça kaydı bulunmuyor. Sadece işçilik ücreti yazılmış.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Summary Block -->
            <div class="mt-8 flex flex-col md:flex-row justify-between items-start md:items-end">
                <div class="mb-6 md:mb-0 max-w-xs hidden print:block text-xs text-slate-400">
                    <p>İmzalı ve onaylı bakım fişidir. Yapılan işçilik ve kullanılan parçalar garanti kapsamındadır.</p>
                </div>
                
                <div class="w-full md:w-80 bg-slate-50 rounded-xl p-5 border border-slate-100">
                    <div class="flex justify-between py-2 text-sm text-slate-600 border-b border-dashed border-slate-200">
                        <span>Parçalar Ara Toplam:</span>
                        @php
                            $partsTotal = $maintenance->parts->sum(function($p) { return $p->quantity * $p->unit_price; });
                        @endphp
                        <span class="font-medium text-slate-900">{{ number_format($partsTotal, 2, ',', '.') }} ₺</span>
                    </div>
                    <div class="flex justify-between py-2 text-sm text-slate-600 border-b border-dashed border-slate-200">
                        <span>İşçilik Ücreti:</span>
                        <span class="font-medium text-slate-900">{{ number_format($maintenance->labor_cost, 2, ',', '.') }} ₺</span>
                    </div>
                    <div class="flex justify-between py-3 mt-1 items-center bg-blue-50/50 -mx-5 px-5 -mb-5 rounded-b-xl border-t border-blue-100">
                        <span class="text-base font-bold text-slate-900">Genel Toplam:</span>
                        <span class="text-xl font-black text-blue-700">{{ number_format($maintenance->total_cost, 2, ',', '.') }} ₺</span>
                    </div>
                </div>
            </div>

        </div>

        <div class="bg-slate-800 text-slate-300 text-center py-3 text-xs hidden print:block">
            Müşterimizi bizi tercih ettiği için teşekkür ederiz. - Uygulama Demo Servisi
        </div>
    </div>
@endsection
