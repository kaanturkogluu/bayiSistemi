@extends('layouts.admin')

@section('header', 'Cari Takip')

@section('content')
    {{-- Header --}}
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="/admin"
                class="inline-flex items-center justify-center w-10 h-10 bg-white border border-slate-200 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-slate-50 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Cari Hesaplar</h1>
                <p class="text-slate-500 text-sm">Müşteri borç - alacak ve tahsilat takibi</p>
            </div>
        </div>
    </div>

    {{-- Top Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Toplam Açık Bakiye</p>
                <p class="text-xl font-black {{ $totalDebt > 0 ? 'text-red-600' : 'text-emerald-600' }} mt-0.5">
                    {{ number_format($totalDebt, 2, ',', '.') }} ₺
                </p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Borçlu Müşteri</p>
                <p class="text-xl font-black text-slate-900 mt-0.5">{{ $inDebtCount }} Kişi</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Borçsuz Müşteri</p>
                <p class="text-xl font-black text-slate-900 mt-0.5">{{ $clearCount }} Kişi</p>
            </div>
        </div>
    </div>

    {{-- Filters & Search --}}
    <div class="mb-4 flex flex-col sm:flex-row gap-3">
        {{-- Search --}}
        <form action="{{ route('admin.cari.index') }}" method="GET" class="flex-1 relative">
            <input type="hidden" name="filter" value="{{ $filter }}">
            <input type="text" name="search" value="{{ $searchQuery ?? '' }}"
                placeholder="Müşteri adı veya telefon..."
                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </form>

        {{-- Filter tabs --}}
        <div class="flex bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm text-sm font-semibold">
            <a href="{{ route('admin.cari.index', ['filter' => 'all', 'search' => $searchQuery]) }}"
                class="px-4 py-2.5 transition-colors {{ $filter === 'all' ? 'bg-slate-800 text-white' : 'text-slate-600 hover:bg-slate-50' }}">
                Tümü
            </a>
            <a href="{{ route('admin.cari.index', ['filter' => 'indebted', 'search' => $searchQuery]) }}"
                class="px-4 py-2.5 border-l border-slate-200 transition-colors {{ $filter === 'indebted' ? 'bg-red-600 text-white' : 'text-slate-600 hover:bg-slate-50' }}">
                Borçlular
            </a>
            <a href="{{ route('admin.cari.index', ['filter' => 'clear', 'search' => $searchQuery]) }}"
                class="px-4 py-2.5 border-l border-slate-200 transition-colors {{ $filter === 'clear' ? 'bg-emerald-600 text-white' : 'text-slate-600 hover:bg-slate-50' }}">
                Kapalı
            </a>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-semibold tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3">Müşteri</th>
                        <th class="px-6 py-3">Telefon</th>
                        <th class="px-6 py-3 text-right">Toplam Borç</th>
                        <th class="px-6 py-3 text-right">Toplam Ödenen</th>
                        <th class="px-6 py-3 text-right">Kalan Bakiye</th>
                        <th class="px-6 py-3 text-center">Durum</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($customers as $customer)
                        @php
                            $debt   = $customer->total_debt   ?? 0;
                            $paid   = $customer->total_paid   ?? 0;
                            $bal    = $customer->balance;
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm shrink-0">
                                        {{ mb_substr($customer->name_surname, 0, 1) }}
                                    </div>
                                    <span class="font-semibold text-slate-800">{{ $customer->name_surname }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-slate-500">
                                {{ $customer->phone ?? '—' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right font-semibold text-slate-700">
                                {{ number_format($debt, 2, ',', '.') }} ₺
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right font-semibold text-emerald-600">
                                {{ number_format($paid, 2, ',', '.') }} ₺
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right font-black {{ $bal > 0 ? 'text-red-600' : 'text-emerald-600' }}">
                                {{ number_format($bal, 2, ',', '.') }} ₺
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($bal > 0)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">Borçlu</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">Kapalı</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <a href="{{ route('admin.customers.show', $customer) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-lg text-xs font-bold transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Detay
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center gap-2 text-slate-400">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <p class="font-medium">Bu filtrede sonuç bulunamadı.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($customers->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
                {{ $customers->links() }}
            </div>
        @endif
    </div>
@endsection
