@extends('layouts.admin')

@section('header', 'Motorlar (Stok)')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.data_center.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-indigo-600">
                    Veri Merkezi
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-slate-800 md:ml-2">Motorlar</span>
                </div>
            </li>
        </ol>
    </nav>
    <a href="{{ route('admin.motorcycles.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-lg text-sm font-bold hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Yeni Motor Ekle
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-bottom border-slate-200">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Motor Bilgisi</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Şase / Motor No</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Yıl / Renk</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Fiyat Bilgisi</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Durum</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">İşlemler</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($motorcycles as $motorcycle)
                <tr class="hover:bg-slate-50 transition-colors text-sm">
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-800">{{ $motorcycle->brand->name }}</div>
                        <div class="text-xs text-slate-500">{{ $motorcycle->motorcycleModel->name }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-xs font-mono text-slate-700">S: {{ $motorcycle->chassis_number }}</div>
                        <div class="text-xs font-mono text-slate-500">M: {{ $motorcycle->engine_number }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-slate-700">{{ $motorcycle->year }}</div>
                        <div class="text-xs text-slate-500">{{ $motorcycle->color->name }}</div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        @if($motorcycle->purchase_price)
                            <div class="text-xs text-slate-500">Alış: {{ number_format($motorcycle->purchase_price, 2, ',', '.') }} ₺</div>
                        @endif
                        @if($motorcycle->sale_price)
                            <div class="font-bold text-slate-800">Satış: {{ number_format($motorcycle->sale_price, 2, ',', '.') }} ₺</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-xs font-bold">
                        @if($motorcycle->status === 'stokta')
                            <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded">{{ strtoupper($motorcycle->status) }}</span>
                        @elseif($motorcycle->status === 'satildi')
                            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded underline decoration-dotted">{{ strtoupper($motorcycle->status) }}</span>
                        @else
                            <span class="px-2 py-1 bg-amber-100 text-amber-700 rounded decoration-dotted">{{ strtoupper($motorcycle->status) }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                        <a href="{{ route('admin.motorcycles.edit', $motorcycle) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-md text-xs font-bold hover:bg-indigo-100 transition-all">
                            Düzenle
                        </a>
                        <form action="{{ route('admin.motorcycles.destroy', $motorcycle) }}" method="POST" class="inline-block" onsubmit="return confirm('Bu kaydı silmek istediğinize emin misiniz?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-700 rounded-md text-xs font-bold hover:bg-red-100 transition-all">
                                Sil
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-500 italic">
                        Henüz stok girişi yapılmamış.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
