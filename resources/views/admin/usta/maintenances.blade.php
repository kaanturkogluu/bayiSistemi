@extends('layouts.admin')

@section('header')
    {{ $status === 'bekliyor' ? 'Bekleyen Bakımlar' : 'Tamamlanan Bakımlar' }}
@endsection

@section('content')
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <a href="{{ url('/admin') }}"
            class="inline-flex items-center justify-center px-4 py-2 border border-slate-200 rounded-lg shadow-sm text-sm font-medium text-slate-600 bg-white hover:bg-slate-50 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors shrink-0">
            <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Panele Dön
        </a>

        <!-- Search Form -->
        <form action="{{ route('admin.usta.maintenances') }}" method="GET" class="w-full md:w-1/2 lg:w-1/3 relative">
            <input type="hidden" name="status" value="{{ $status }}">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Plaka, İsim veya Telefon Ara..."
                class="w-full pl-10 pr-4 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            @if(request()->filled('search'))
                <a href="{{ route('admin.usta.maintenances', ['status' => $status]) }}"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-red-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
            @endif
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse ($maintenances as $maintenance)
            <a href="{{ route('admin.usta.maintenances.show', $maintenance) }}"
                class="group relative bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md hover:border-blue-400 transition-all duration-300 flex flex-col items-center justify-center text-center overflow-hidden">

                <!-- Background decorative elements -->
                <div
                    class="absolute -right-4 -top-4 w-24 h-24 {{ $status === 'bekliyor' ? 'bg-amber-50' : 'bg-emerald-50' }} rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500">
                </div>

                <div class="relative z-10 w-full flex flex-col items-center">
                    <!-- Plate Container (Turkish License Plate Style) -->
                    <div
                        class="border-4 border-slate-800 rounded-lg overflow-hidden bg-white shadow-sm flex items-stretch h-14 w-full max-w-[200px] mb-3 group-hover:scale-105 transition-transform">
                        <div class="bg-blue-600 w-10 flex flex-col items-center justify-center text-white shrink-0">
                            <span class="text-[10px] font-bold leading-none mb-1">TR</span>
                        </div>
                        <div class="flex-1 flex items-center justify-center px-2 bg-white">
                            <span class="text-2xl font-black text-slate-800 tracking-wider">
                                {{ $maintenance->vehicle ? $maintenance->vehicle->plate : 'Plakasız' }}
                            </span>
                        </div>
                    </div>

                    <div class="text-sm text-slate-500 mb-3 flex flex-col items-center justify-center gap-1.5 font-medium" title="Kayıt Tarihi ve KM">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>{{ $maintenance->created_at ? $maintenance->created_at->format('d.m.Y H:i') : '-' }}</span>
                        </div>
                        @if($maintenance->km)
                        <div class="flex items-center gap-1.5 text-xs bg-slate-100 px-2 py-0.5 rounded-full mt-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ number_format($maintenance->km, 0, ',', '.') }} KM</span>
                        </div>
                        @endif
                    </div>

                    <h3 class="font-bold text-slate-700 text-lg mb-1 truncate w-full"
                        title="{{ $maintenance->customer?->name_surname ?? 'Silinmiş Müşteri' }}">
                        {{ $maintenance->customer?->name_surname ?? 'Silinmiş Müşteri' }}
                    </h3>

                    <div
                        class="text-sm font-medium {{ $status === 'bekliyor' ? 'text-amber-600 bg-amber-50' : 'text-emerald-600 bg-emerald-50' }} px-3 py-1 rounded-full mt-2 inline-flex items-center justify-center">
                        @if($status === 'bekliyor')
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            İşlem Bekliyor
                        @else
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Tamamlandı: {{ $maintenance->completedBy ? $maintenance->completedBy->username : 'Bilinmiyor' }}
                        @endif
                    </div>
                </div>
            </a>
        @empty
            <div
                class="col-span-full bg-white rounded-2xl border border-slate-200 p-12 flex flex-col items-center justify-center text-slate-500">
                <svg class="w-16 h-16 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                    </path>
                </svg>
                <p class="text-lg font-medium">Bu listede henüz araç bulunmuyor.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $maintenances->appends(['status' => $status, 'search' => $search ?? ''])->links() }}
    </div>
@endsection