@extends('layouts.admin')

@section('header', 'Yeni Motor Satışı')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.motorcycle-sales.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-indigo-600">
                        Satış Geçmişi
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-slate-800 md:ml-2">Yeni Satış</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <form action="{{ route('admin.motorcycle-sales.store') }}" method="POST" id="sale-form">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 space-y-6">
                <!-- Satış Bilgileri -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04M12 2.944a11.955 11.955 0 01-8.618 3.04m16.732 3.04A11.955 11.955 0 0112 11a11.955 11.955 0 01-6.114-1.976M12 11a11.955 11.955 0 01-6.114-1.976m11.228 1.976A11.955 11.955 0 0112 21.056a11.955 11.955 0 01-9.112-4.056M12 21.056a11.955 11.955 0 01-9.112-4.056"></path>
                        </svg>
                        Satış Detayları
                    </h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="customer_id" class="block text-sm font-bold text-slate-700 mb-1">Müşteri Seçin <span class="text-red-500">*</span></label>
                            <select name="customer_id" id="customer_id" required class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all bg-white text-sm">
                                <option value="">Müşteri Ara veya Seç...</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name_surname }} ({{ $customer->phone }})
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id') <p class="mt-1 text-xs text-red-500 font-semibold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="motorcycle_id" class="block text-sm font-bold text-slate-700 mb-1">Motosiklet Seçin (Stoktaki Motorlar) <span class="text-red-500">*</span></label>
                            <select name="motorcycle_id" id="motorcycle_id" required class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all bg-white text-sm">
                                <option value="">Motor Seçiniz...</option>
                                @foreach($motorcycles as $motor)
                                    <option value="{{ $motor->id }}" data-price="{{ $motor->sale_price }}" {{ old('motorcycle_id') == $motor->id ? 'selected' : '' }}>
                                        {{ $motor->brand->name }} {{ $motor->motorcycleModel->name }} - {{ $motor->color->name }} (Şase: {{ $motor->chassis_number }})
                                    </option>
                                @endforeach
                            </select>
                            @error('motorcycle_id') <p class="mt-1 text-xs text-red-500 font-semibold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-bold text-slate-700 mb-1">Satış Notu</label>
                            <textarea name="notes" id="notes" rows="3" class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm" placeholder="Varsa özel notlar..."></textarea>
                            @error('notes') <p class="mt-1 text-xs text-red-500 font-semibold">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sağ Sütun: Fiyat ve Tarih -->
            <div class="space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Ödeme Bilgileri
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label for="sale_price_display" class="block text-sm font-bold text-slate-700 mb-1">Satış Fiyatı (TL) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-3 top-2.5 text-slate-400 text-sm">₺</span>
                                <input type="text" id="sale_price_display" required class="w-full pl-7 pr-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm price-mask font-bold" placeholder="0,00">
                                <input type="hidden" name="sale_price" id="sale_price" value="{{ old('sale_price') }}">
                            </div>
                            @error('sale_price') <p class="mt-1 text-xs text-red-500 font-semibold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="sale_date" class="block text-sm font-bold text-slate-700 mb-1">Satış Tarihi <span class="text-red-500">*</span></label>
                            <input type="date" name="sale_date" id="sale_date" required value="{{ old('sale_date', date('Y-m-d')) }}" class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm">
                            @error('sale_date') <p class="mt-1 text-xs text-red-500 font-semibold">{{ $message }}</p> @enderror
                        </div>

                        <div class="p-3 bg-amber-50 border border-amber-100 rounded-xl">
                            <p class="text-[10px] text-amber-700 leading-tight">
                                <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Satış tamamlandığında motor stoktan düşülecek ve müşterinin cari hesabına borç kaydedilecektir.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <button type="submit" id="submit-btn" class="w-full px-6 py-4 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-2xl text-base font-bold hover:bg-emerald-600 hover:text-white transition-all shadow-sm flex items-center justify-center min-w-[140px]">
                        <span id="btn-text">Satışı Tamamla</span>
                        <span id="btn-spinner" class="hidden ml-2">
                            <svg class="animate-spin h-4 w-4 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </button>
                    <a href="{{ route('admin.motorcycle-sales.index') }}" class="w-full px-6 py-4 bg-slate-100 text-slate-700 rounded-2xl text-base font-bold hover:bg-slate-200 transition-all text-center">
                        Vazgeç
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#customer_id').select2({
        placeholder: "Müşteri Ara veya Seç..."
    });

    $('#motorcycle_id').select2({
        placeholder: "Motor Seçiniz..."
    }).on('change', function() {
        // Auto-fill sale price from selected motorcycle's default price
        const selectedOption = $(this).find(':selected');
        const defaultPrice = selectedOption.data('price');
        
        if (defaultPrice) {
            const displayInput = document.getElementById('sale_price_display');
            const hiddenInput = document.getElementById('sale_price');
            
            hiddenInput.value = defaultPrice;
            displayInput.value = new Intl.NumberFormat('tr-TR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(defaultPrice);
        }
    });

    // Price Masking Logic
    function formatCurrency(input) {
        let value = input.value.replace(/\D/g, "");
        if (value === "") {
            input.dataset.raw = "";
            return;
        }
        
        let floatValue = parseFloat(value) / 100;
        input.dataset.raw = floatValue.toFixed(2);
        
        input.value = new Intl.NumberFormat('tr-TR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(floatValue);
    }

    const priceInputs = document.querySelectorAll('.price-mask');
    priceInputs.forEach(input => {
        const hiddenInputId = input.id.replace('_display', '');
        const hiddenInput = document.getElementById(hiddenInputId);

        if (hiddenInput && hiddenInput.value) {
            let val = parseFloat(hiddenInput.value);
            input.value = new Intl.NumberFormat('tr-TR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(val);
        }

        input.addEventListener('input', function(e) {
            let cursorPosition = this.selectionStart;
            let oldLength = this.value.length;
            
            formatCurrency(this);
            
            if (hiddenInput) {
                hiddenInput.value = this.dataset.raw;
            }

            let newLength = this.value.length;
            cursorPosition = cursorPosition + (newLength - oldLength);
            this.setSelectionRange(cursorPosition, cursorPosition);
        });

        input.addEventListener('keypress', function(e) {
            if (!/[0-9]/.test(e.key)) {
                e.preventDefault();
            }
        });
    });

    // Anti-spam & Submission
    document.getElementById('sale-form').addEventListener('submit', function() {
        const btn = document.getElementById('submit-btn');
        const text = document.getElementById('btn-text');
        const spinner = document.getElementById('btn-spinner');
        
        btn.disabled = true;
        btn.classList.add('opacity-70', 'cursor-not-allowed');
        text.innerText = 'İşleniyor...';
        spinner.classList.remove('hidden');
    });
});
</script>
@endpush
@endsection
