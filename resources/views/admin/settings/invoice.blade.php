@extends('layouts.admin')

@section('header', 'Fatura ve Şirket Ayarları')

@section('content')
    <div class="max-w-4xl mx-auto">
        {{-- Header --}}
        <div class="mb-6 flex items-center gap-4">
            <a href="{{ url()->previous() !== url()->current() ? url()->previous() : url('/admin') }}"
                class="inline-flex items-center justify-center w-10 h-10 bg-white border border-slate-200 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-slate-50 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-slate-800">Fatura ve Şirket Ayarları</h1>
        </div>

        <div class="bg-white border text-slate-800 border-slate-200 shadow-sm rounded-xl p-6 sm:p-10">

            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.settings.invoice.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <h3 class="text-lg font-bold text-slate-800 mb-6 border-b border-slate-100 pb-2 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                    Firma Bilgileri
                </h3>

                <!-- Company Name -->
                <div class="mb-4">
                    <label for="company_name" class="block text-sm font-medium text-slate-700 mb-1">Firma Adı / Şirket
                        Ünvanı</label>
                    <input type="text" name="company_name" id="company_name"
                        value="{{ old('company_name', $setting->company_name ?? '') }}"
                        class="mt-1 block w-full border-slate-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition" />
                    @error('company_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-slate-700 mb-1">Telefon Numarası</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $setting->phone ?? '') }}"
                            class="mt-1 block w-full border-slate-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition" />
                        @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-1">E-Posta Adresi</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $setting->email ?? '') }}"
                            class="mt-1 block w-full border-slate-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition" />
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- City -->
                <div class="mb-4">
                    <label for="city" class="block text-sm font-medium text-slate-700 mb-1">Şehir / İlçe</label>
                    <input type="text" name="city" id="city" value="{{ old('city', $setting->city ?? '') }}"
                        placeholder="Örn: GAZİANTEP / ŞAHİNBEY"
                        class="mt-1 block w-full border-slate-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition" />
                    @error('city')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Address -->
                <div class="mb-8">
                    <label for="address" class="block text-sm font-medium text-slate-700 mb-1">Detaylı Adres Bilgisi</label>
                    <textarea name="address" id="address" rows="3"
                        class="mt-1 block w-full border-slate-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition">{{ old('address', $setting->address ?? '') }}</textarea>
                    @error('address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <h3 class="text-lg font-bold text-slate-800 mb-6 border-b border-slate-100 pb-2 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    Firma Logosu
                </h3>

                <!-- Logo Field -->
                <div class="mb-8 flex items-start space-x-6">
                    <!-- Current Logo Preview -->
                    <div class="flex-shrink-0">
                        @if(isset($setting) && $setting->logo_path)
                            <div
                                class="w-32 h-32 rounded-lg border border-slate-200 bg-slate-50 flex items-center justify-center overflow-hidden">
                                <img src="{{ Storage::url($setting->logo_path) }}" alt="Mevcut Logo"
                                    class="max-w-full max-h-full object-contain" />
                            </div>
                        @else
                            <div
                                class="w-32 h-32 rounded-lg border-2 border-dashed border-slate-300 bg-slate-50 flex flex-col items-center justify-center text-slate-400">
                                <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span class="text-xs">Logo Yok</span>
                            </div>
                        @endif
                    </div>

                    <div class="flex-1">
                        <label for="logo" class="block text-sm font-medium text-slate-700 mb-2">Yeni Logo Yükle</label>
                        <input type="file" name="logo" id="logo" accept="image/*" class="block w-full text-sm text-slate-500
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-full file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-blue-50 file:text-blue-700
                                          hover:file:bg-blue-100 transition" />
                        <p class="text-xs text-slate-500 mt-2">Maksimum dosya boyutu: 2MB. İzin verilen formatlar: JPEG,
                            PNG, JPG, GIF.</p>
                        @error('logo')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-4 border-t border-slate-200">
                    <button type="submit"
                        class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-lg font-bold text-white hover:bg-blue-700 active:bg-blue-800 transition shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Ayarları Kaydet ve Güncelle
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection