@extends('layouts.admin')

@section('header', 'Bakım Geçmişi')

@section('content')
    {{-- Header --}}
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.customers.index') }}"
                class="inline-flex items-center justify-center w-10 h-10 bg-white border border-slate-200 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-slate-50 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">{{ $customer->name_surname }}</h1>
                <p class="text-slate-500 text-sm">{{ $customer->phone ?? 'Telefon belirtilmemiş' }} &bull; Bakım Geçmişi</p>
            </div>
        </div>

        {{-- Quick links --}}
        <div class="flex gap-2">
            <a href="{{ route('admin.customers.show', $customer) }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-blue-600 font-medium text-sm transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                Cari Hesap
            </a>
            <a href="{{ route('admin.maintenances.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 text-white rounded-xl font-medium text-sm hover:bg-purple-700 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Yeni Bakım
            </a>
        </div>
    </div>

    {{-- Summary chips --}}
    @php
        $total      = $maintenances->total();
        $completed  = $customer->maintenances()->where('status', 'tamamlandi')->count();
        $pending    = $customer->maintenances()->where('status', 'bekliyor')->count();
        $totalCost  = $customer->maintenances()->sum('total_cost');
    @endphp
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 text-center">
            <p class="text-2xl font-black text-slate-800">{{ $total }}</p>
            <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider mt-1">Toplam Bakım</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 text-center">
            <p class="text-2xl font-black text-amber-600">{{ $pending }}</p>
            <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider mt-1">Bekleyen</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 text-center">
            <p class="text-2xl font-black text-emerald-600">{{ $completed }}</p>
            <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider mt-1">Tamamlanan</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 text-center">
            <p class="text-2xl font-black text-slate-800">{{ number_format($totalCost, 2, ',', '.') }} ₺</p>
            <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider mt-1">Toplam Tutar</p>
        </div>
    </div>

    {{-- Maintenance list --}}
    <div class="space-y-4">
        @forelse ($maintenances as $maintenance)
            @php
                $isDone = $maintenance->status === 'tamamlandi';
            @endphp
            <div class="bg-white rounded-2xl border {{ $isDone ? 'border-emerald-200' : 'border-amber-200' }} shadow-sm overflow-hidden">
                {{-- Card header --}}
                <div class="px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 {{ $isDone ? 'bg-emerald-50' : 'bg-amber-50' }} border-b {{ $isDone ? 'border-emerald-100' : 'border-amber-100' }}">
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-black text-slate-500">#{{ str_pad($maintenance->id, 5, '0', STR_PAD_LEFT) }}</span>
                        @if($maintenance->vehicle)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white border border-slate-200 rounded-full text-sm font-bold text-slate-700 shadow-sm">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0zM13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 2h10"/>
                                </svg>
                                {{ $maintenance->vehicle->plate }}
                            </span>
                        @endif
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $isDone ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                            {{ $isDone ? 'Tamamlandı' : 'Bekliyor' }}
                        </span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-slate-500">{{ $maintenance->created_at->format('d/m/Y') }}</span>
                        <a href="{{ route('admin.maintenances.show', $maintenance) }}"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-bold text-slate-600 hover:text-blue-600 hover:border-blue-300 transition-colors shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Detay
                        </a>
                    </div>
                </div>

                {{-- Card body --}}
                <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    {{-- Costs --}}
                    <div>
                        <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-2">Ücretler</p>
                        <div class="space-y-1">
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">İşçilik</span>
                                <span class="font-semibold text-slate-700">{{ number_format($maintenance->labor_cost, 2, ',', '.') }} ₺</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">Toplam</span>
                                <span class="font-black text-slate-900">{{ number_format($maintenance->total_cost, 2, ',', '.') }} ₺</span>
                            </div>
                        </div>
                    </div>

                    {{-- Parts --}}
                    <div>
                        <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-2">Parçalar ({{ $maintenance->parts->count() }})</p>
                        @if($maintenance->parts->isEmpty())
                            <p class="text-sm text-slate-400 italic">Parça yok</p>
                        @else
                            <ul class="space-y-0.5">
                                @foreach($maintenance->parts->take(3) as $part)
                                    <li class="flex items-center gap-1.5 text-sm">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $part->is_completed ? 'bg-emerald-500' : 'bg-amber-400' }} shrink-0"></span>
                                        <span class="text-slate-600 truncate">{{ $part->name }}</span>
                                        <span class="text-slate-400 text-xs ml-auto shrink-0">x{{ $part->quantity }}</span>
                                    </li>
                                @endforeach
                                @if($maintenance->parts->count() > 3)
                                    <li class="text-xs text-slate-400 italic">+{{ $maintenance->parts->count() - 3 }} daha...</li>
                                @endif
                            </ul>
                        @endif
                    </div>

                    {{-- Completion info --}}
                    <div>
                        <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-2">Tamamlama</p>
                        @if($isDone && $maintenance->completedBy)
                            <p class="text-sm text-slate-600">
                                <span class="font-semibold">{{ $maintenance->completedBy->username }}</span> tarafından tamamlandı.
                            </p>
                        @elseif($isDone)
                            <p class="text-sm text-emerald-600 font-semibold">Tamamlandı</p>
                        @else
                            <p class="text-sm text-amber-600 font-semibold">İşlem devam ediyor</p>
                        @endif
                        <p class="text-xs text-slate-400 mt-1">{{ $maintenance->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm px-6 py-16 text-center">
                <div class="flex flex-col items-center gap-3 text-slate-400">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <p class="font-medium text-base">Bu müşteriye ait bakım kaydı bulunmuyor.</p>
                    <a href="{{ route('admin.maintenances.create') }}"
                        class="mt-2 inline-flex items-center gap-2 px-4 py-2 bg-purple-600 text-white rounded-xl font-medium text-sm hover:bg-purple-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Yeni Bakım Oluştur
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if ($maintenances->hasPages())
        <div class="mt-6">
            {{ $maintenances->links() }}
        </div>
    @endif
@endsection
