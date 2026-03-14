@extends('layouts.admin')

@section('header', 'Bakım Kayıtları')

@section('content')
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ url()->previous() !== url()->current() ? url()->previous() : url('/admin') }}"
                class="inline-flex items-center justify-center w-10 h-10 bg-white border border-slate-200 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-slate-50 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-slate-800">Bakım Kayıtları</h1>
        </div>
    </div>

    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <!-- Search Form -->
        <form action="{{ route('admin.maintenances.index') }}" method="GET" class="w-full md:w-1/2 flex gap-2">
            <div class="relative flex-1">
                <input type="text" name="search" value="{{ $searchQuery ?? '' }}"
                    placeholder="Müşteri Adı, Telefon veya Plaka Ara..."
                    class="w-full pl-10 pr-4 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                @if(request()->filled('search'))
                    <a href="{{ route('admin.maintenances.index', ['status' => request('status')]) }}"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-red-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </a>
                @endif
            </div>
            <select name="status" onchange="this.form.submit()"
                class="rounded-lg border border-slate-300 py-2 pl-3 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-500 text-slate-700 bg-white">
                <option value="">Tümü</option>
                <option value="bekliyor" {{ request('status') === 'bekliyor' ? 'selected' : '' }}>Bekleyenler</option>
                <option value="tamamlandi" {{ request('status') === 'tamamlandi' ? 'selected' : '' }}>Tamamlananlar</option>
            </select>
        </form>

        <a href="{{ route('admin.maintenances.create') }}"
            class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors shrink-0">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Yeni Bakım Kaydı
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg mb-6 flex items-center">
            <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" <th scope="col"
                            class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            Müşteri & Araç</th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tutar
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tarih
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            İşlemler</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse ($maintenances as $maintenance)
                        <tr
                            class="transition-colors {{ $maintenance->status === 'tamamlandi' ? 'bg-green-100 hover:bg-green-200' : 'bg-white hover:bg-slate-50' }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="w-9 h-9 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm shrink-0">
                                        {{ $maintenance->customer ? mb_substr($maintenance->customer->name_surname, 0, 1) : '?' }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-bold text-slate-800">
                                            {{ $maintenance->customer?->name_surname ?? 'Silinmiş Müşteri' }}</div>
                                        <div class="text-xs text-slate-500">{{ $maintenance->customer?->phone ?? '—' }}</div>
                                        <div class="text-xs text-slate-500 mt-1 flex items-center">
                                            @if($maintenance->vehicle)
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-800 uppercase border border-slate-200">
                                                    {{ $maintenance->vehicle->plate }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 font-bold">
                                {{ number_format($maintenance->total_cost, 2, ',', '.') }} ₺
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                <div class="font-medium text-slate-700">{{ $maintenance->created_at->format('d.m.Y H:i') }}</div>
                                @if($maintenance->km)
                                    <div class="text-xs text-slate-500 mt-1 flex items-center">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ number_format($maintenance->km, 0, ',', '.') }} KM
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.maintenances.show', $maintenance) }}"
                                    class="text-indigo-600 hover:text-indigo-900 mr-3">Görüntüle</a>
                                <a href="{{ route('admin.maintenances.edit', $maintenance) }}"
                                    class="text-blue-600 hover:text-blue-900 mr-3">Düzenle</a>
                                <form action="{{ route('admin.maintenances.destroy', $maintenance) }}" method="POST"
                                    class="inline-block"
                                    onsubmit="return confirm('Bu bakım kaydını silmek istediğinize emin misiniz?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Sil</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                        </path>
                                    </svg>
                                    Henüz bakım kaydı bulunmuyor.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-slate-200">
            {{ $maintenances->links() }}
        </div>
    </div>
@endsection