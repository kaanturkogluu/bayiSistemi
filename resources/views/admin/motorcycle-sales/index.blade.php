@extends('layouts.admin')

@section('header', 'Motosiklet Satış Geçmişi')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="/admin" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-indigo-600">
                    Panel
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-slate-800 md:ml-2">Motor Satış Geçmişi</span>
                </div>
            </li>
        </ol>
    </nav>
    <a href="{{ route('admin.motorcycle-sales.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg text-sm font-bold hover:bg-emerald-600 hover:text-white transition-all shadow-sm">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Yeni Satış Yap
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-bottom border-slate-200">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tarih</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Müşteri</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Motosiklet</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Satış Tutarı</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">İşlemler</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($sales as $sale)
                <tr class="hover:bg-slate-50 transition-colors text-sm">
                    <td class="px-6 py-4 text-slate-600">
                        {{ \Carbon\Carbon::parse($sale->sale_date)->format('d.m.Y') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-800">{{ $sale->customer->name_surname }}</div>
                        <div class="text-xs text-slate-500">{{ $sale->customer->phone }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-800">{{ $sale->motorcycle->brand->name }} {{ $sale->motorcycle->motorcycleModel->name }}</div>
                        <div class="text-xs text-slate-500">Şase: {{ $sale->motorcycle->chassis_number }}</div>
                    </td>
                    <td class="px-6 py-4 text-right font-bold text-slate-800">
                        {{ number_format($sale->sale_price, 2, ',', '.') }} ₺
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.customers.show', $sale->customer_id) }}" class="inline-flex items-center px-3 py-1.5 bg-slate-100 text-slate-700 rounded-md text-xs font-bold hover:bg-slate-200 transition-all">
                            Cari Hareket
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-500 italic">
                        Henüz satış kaydı bulunmuyor.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($sales->hasPages())
    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
        {{ $sales->links() }}
    </div>
    @endif
</div>
@endsection
