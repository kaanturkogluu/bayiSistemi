@extends('layouts.admin')

@section('header', 'Veri Merkezi')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Brands Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden group hover:border-indigo-500 transition-all">
        <div class="p-6">
            <div class="w-12 h-12 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center mb-4 group-hover:bg-indigo-100 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-1">Markalar</h3>
            <p class="text-slate-500 text-sm mb-4">Sistemde kullanılan araç markalarını yönetin.</p>
            <div class="flex items-center justify-between">
                <span class="text-2xl font-bold text-slate-700">{{ $brandsCount }}</span>
                <a href="{{ route('admin.brands.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 rounded-lg text-sm font-bold hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                    Yönet
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Models Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden group hover:border-blue-500 transition-all">
        <div class="p-6">
            <div class="w-12 h-12 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center mb-4 group-hover:bg-blue-100 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-1">Modeller</h3>
            <p class="text-slate-500 text-sm mb-4">Markalara bağlı araç modellerini yönetin.</p>
            <div class="flex items-center justify-between">
                <span class="text-2xl font-bold text-slate-700">{{ $modelsCount }}</span>
                <a href="{{ route('admin.motorcycle-models.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-lg text-sm font-bold hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                    Yönet
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Colors Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden group hover:border-emerald-500 transition-all">
        <div class="p-6">
            <div class="w-12 h-12 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center mb-4 group-hover:bg-emerald-100 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-1">Renkler</h3>
            <p class="text-slate-500 text-sm mb-4">Araç renk tanımlamalarını yönetin.</p>
            <div class="flex items-center justify-between">
                <span class="text-2xl font-bold text-slate-700">{{ $colorsCount }}</span>
                <a href="{{ route('admin.colors.index') }}" class="inline-flex items-center px-4 py-2 bg-emerald-50 text-emerald-700 rounded-lg text-sm font-bold hover:bg-emerald-600 hover:text-white transition-all shadow-sm">
                    Yönet
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
