@extends('layouts.admin')

@section('header', 'Müşteri Yönetimi')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center">
            <a href="/admin"
                class="mr-4 inline-flex items-center justify-center w-10 h-10 bg-white border border-slate-200 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-slate-50 transition-colors shadow-sm"
                title="Dashboard'a Dön">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Müşteriler</h1>
                <p class="text-slate-500 mt-1 text-sm">Servis müşterilerini buradan yönetebilirsiniz.</p>
            </div>
        </div>
    </div>

    <!-- Top Actions & Search -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <!-- Search Form -->
        <form action="{{ route('admin.customers.index') }}" method="GET" class="w-full md:w-1/3 relative">
            <input type="text" name="search" value="{{ $searchQuery ?? '' }}" placeholder="Müşteri Adı veya Telefon Ara..."
                class="w-full pl-10 pr-4 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            @if(request()->filled('search'))
                <a href="{{ route('admin.customers.index') }}"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-red-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
            @endif
        </form>

        <a href="{{ route('admin.customers.create') }}"
            class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors shrink-0">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Yeni Müşteri Ekle
        </a>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg mb-6 flex items-center">
            <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto min-h-[350px] pb-32">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            Müşteri</th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            İletişim</th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider text-center">
                            Araç Sayısı</th>

                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Kayıt
                            Tarihi</th>
                        <th scope="col"
                            class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            İşlemler</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse ($customers as $customer)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="h-10 w-10 flex-shrink-0 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-lg">
                                        {{ substr($customer->name_surname, 0, 1) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-slate-900">{{ $customer->name_surname }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($customer->phone)
                                    <div class="text-sm text-slate-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                            </path>
                                        </svg>
                                        {{ $customer->phone }}
                                    </div>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                                        Belirtilmedi
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $customer->vehicles_count > 0 ? 'bg-blue-100 text-blue-800' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $customer->vehicles_count }} Araç
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                {{ $customer->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.maintenances.create', ['customer_id' => $customer->id]) }}"
                                        class="text-emerald-600 hover:text-emerald-900 font-bold">Servis Oluştur</a>
                                    <span class="text-slate-300">|</span>
                                    <a href="{{ route('admin.customers.show', $customer) }}"
                                        class="text-indigo-600 hover:text-indigo-900">Cari</a>
                                    <span class="text-slate-300">|</span>
                                    <a href="{{ route('admin.customers.maintenances', $customer) }}"
                                        class="text-purple-600 hover:text-purple-900">Bakım Geçmişi</a>
                                    <span class="text-slate-300">|</span>

                                    {{-- Kebab dropdown --}}
                                    <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                                        <button @click="open = !open"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 6a2 2 0 110-4 2 2 0 010 4zm0 8a2 2 0 110-4 2 2 0 010 4zm0 8a2 2 0 110-4 2 2 0 010 4z" />
                                            </svg>
                                        </button>
                                        <div x-show="open" x-transition
                                            class="absolute right-0 mt-1 w-36 bg-white rounded-xl shadow-lg border border-slate-200 py-1 z-30">
                                            <a href="{{ route('admin.customers.edit', $customer) }}"
                                                class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                                Düzenle
                                            </a>
                                            <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST"
                                                onsubmit="return confirm('Bu müşteriyi silmek istediğinize emin misiniz? Tüm bakımları da silinecektir!');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                    Sil
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                        </path>
                                    </svg>
                                    Henüz müşteri bulunmuyor.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($customers->hasPages())
            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                {{ $customers->links() }}
            </div>
        @endif
    </div>
@endsection