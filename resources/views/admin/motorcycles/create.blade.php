@extends('layouts.admin')

@section('header', 'Yeni Motor Kaydı')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.motorcycles.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-indigo-600">
                        Motorlar (Stok)
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-slate-800 md:ml-2">Yeni Kayıt</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <form action="{{ route('admin.motorcycles.store') }}" method="POST" id="motorcycle-form">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 space-y-6">
                <!-- Temel Bilgiler (Ortak) -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Genel Bilgiler
                    </h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label for="brand_id" class="block text-sm font-bold text-slate-700 mb-1">Marka <span class="text-red-500">*</span></label>
                            <select name="brand_id" id="brand_id" required class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all bg-white text-sm">
                                <option value="">Marka Seçiniz</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="motorcycle_model_id" class="block text-sm font-bold text-slate-700 mb-1">Model <span class="text-red-500">*</span></label>
                            <select name="motorcycle_model_id" id="motorcycle_model_id" required disabled class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all bg-slate-50 disabled:cursor-not-allowed text-sm">
                                <option value="">Önce Marka Seçiniz</option>
                            </select>
                        </div>

                        <div>
                            <label for="year" class="block text-sm font-bold text-slate-700 mb-1">Model Yılı <span class="text-red-500">*</span></label>
                            <input type="number" name="year" id="year" required value="{{ old('year', date('Y')) }}" class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm" placeholder="Örn: 2024">
                        </div>
                    </div>
                </div>

                <!-- Teknik Detaylar (Tekil/Toplu) -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04M12 2.944a11.955 11.955 0 01-8.618 3.04m16.732 3.04A11.955 11.955 0 0112 11a11.955 11.955 0 01-6.114-1.976M12 11a11.955 11.955 0 01-6.114-1.976m11.228 1.976A11.955 11.955 0 0112 21.056a11.955 11.955 0 01-9.112-4.056M12 21.056a11.955 11.955 0 01-9.112-4.056"></path>
                            </svg>
                            Teknik Detaylar (Renk & Numaralar)
                        </h3>
                        <button type="button" id="add-detail-row" class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-lg text-xs font-bold hover:bg-indigo-600 hover:text-white transition-all">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Yeni Satır Ekle
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse" id="details-table">
                            <thead>
                                <tr class="text-xs font-bold text-slate-500 uppercase tracking-wider bg-slate-50">
                                    <th class="px-4 py-3 border-b border-slate-200">Renk <span class="text-red-500">*</span></th>
                                    <th class="px-4 py-3 border-b border-slate-200">Şase Numarası <span class="text-red-500">*</span></th>
                                    <th class="px-4 py-3 border-b border-slate-200">Motor Numarası <span class="text-red-500">*</span></th>
                                    <th class="px-4 py-3 border-b border-slate-200 w-10"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100" id="details-body">
                                <tr class="detail-row">
                                    <td class="px-2 py-3">
                                        <select name="items[0][color_id]" required class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all bg-white text-sm">
                                            <option value="">Renk Seçiniz</option>
                                            @foreach($colors as $color)
                                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-2 py-3">
                                        <input type="text" name="items[0][chassis_number]" required class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-mono text-sm uppercase" placeholder="Şase">
                                    </td>
                                    <td class="px-2 py-3">
                                        <input type="text" name="items[0][engine_number]" required class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-mono text-sm uppercase" placeholder="Motor No">
                                    </td>
                                    <td class="px-2 py-3 text-center"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sağ Sütun: Durum, Fiyat ve İşlemler -->
            <div class="space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Fiyat ve Durum
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label for="status" class="block text-sm font-bold text-slate-700 mb-1">Stok Durumu <span class="text-red-500">*</span></label>
                            <select name="status" id="status" required class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all bg-white text-sm">
                                <option value="stokta" {{ old('status') == 'stokta' ? 'selected' : '' }}>Stokta</option>
                                <option value="satildi" {{ old('status') == 'satildi' ? 'selected' : '' }}>Satıldı</option>
                                <option value="revize_edildi" {{ old('status') == 'revize_edildi' ? 'selected' : '' }}>Revize Edildi</option>
                            </select>
                        </div>

                        <div>
                            <label for="purchase_price_display" class="block text-sm font-bold text-slate-700 mb-1">Bayi Alış Fiyatı (TL)</label>
                            <div class="relative">
                                <span class="absolute left-3 top-2.5 text-slate-400 text-sm">₺</span>
                                <input type="text" id="purchase_price_display" class="w-full pl-7 pr-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm price-mask" placeholder="0,00">
                                <input type="hidden" name="purchase_price" id="purchase_price" value="{{ old('purchase_price') }}">
                            </div>
                        </div>

                        <div>
                            <label for="sale_price_display" class="block text-sm font-bold text-slate-700 mb-1">Satış Fiyatı (TL)</label>
                            <div class="relative">
                                <span class="absolute left-3 top-2.5 text-slate-400 text-sm">₺</span>
                                <input type="text" id="sale_price_display" class="w-full pl-7 pr-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm price-mask" placeholder="0,00">
                                <input type="hidden" name="sale_price" id="sale_price" value="{{ old('sale_price') }}">
                            </div>
                        </div>

                        <div>
                            <label for="arrival_date" class="block text-sm font-bold text-slate-700 mb-1">Bayi Giriş Tarihi <span class="text-red-500">*</span></label>
                            <input type="date" name="arrival_date" id="arrival_date" required value="{{ old('arrival_date', date('Y-m-d')) }}" class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm">
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <button type="submit" id="submit-btn" class="w-full px-6 py-4 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-2xl text-base font-bold hover:bg-indigo-600 hover:text-white transition-all shadow-sm flex items-center justify-center min-w-[140px]">
                        <span id="btn-text">Kayıtları Tamamla</span>
                        <span id="btn-spinner" class="hidden ml-2">
                            <svg class="animate-spin h-4 w-4 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </button>
                    <a href="{{ route('admin.motorcycles.index') }}" class="w-full px-6 py-4 bg-slate-100 text-slate-700 rounded-2xl text-base font-bold hover:bg-slate-200 transition-all text-center">
                        Vazgeç
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const brandSelect = document.getElementById('brand_id');
    const modelSelect = document.getElementById('motorcycle_model_id');
    const detailsBody = document.getElementById('details-body');
    const addDetailBtn = document.getElementById('add-detail-row');
    let rowIndex = 1;

    // Model Fetching Logic
    async function fetchModels(brandId) {
        if (!brandId) {
            modelSelect.innerHTML = '<option value="">Önce Marka Seçiniz</option>';
            modelSelect.disabled = true;
            modelSelect.classList.add('bg-slate-50');
            return;
        }

        modelSelect.disabled = true;
        modelSelect.innerHTML = '<option value="">Yükleniyor...</option>';

        try {
            const response = await fetch(`/admin/api/brands/${brandId}/models`);
            const models = await response.json();

            modelSelect.innerHTML = '<option value="">Model Seçiniz</option>';
            models.forEach(model => {
                modelSelect.innerHTML += `<option value="${model.id}">${model.name}</option>`;
            });

            modelSelect.disabled = false;
            modelSelect.classList.remove('bg-slate-50');
            
            const oldValue = "{{ old('motorcycle_model_id') }}";
            if (oldValue) modelSelect.value = oldValue;
        } catch (error) {
            console.error('Model yüklenirken hata oluştu:', error);
            modelSelect.innerHTML = '<option value="">Hata Oluştu</option>';
        }
    }

    brandSelect.addEventListener('change', (e) => fetchModels(e.target.value));
    if (brandSelect.value) fetchModels(brandSelect.value);

    // Dynamic Row Addition
    addDetailBtn.addEventListener('click', function() {
        const newRow = document.createElement('tr');
        newRow.className = 'detail-row group';
        newRow.innerHTML = `
            <td class="px-2 py-3 border-t border-slate-100">
                <select name="items[${rowIndex}][color_id]" required class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all bg-white text-sm">
                    <option value="">Renk Seçiniz</option>
                    @foreach($colors as $color)
                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                    @endforeach
                </select>
            </td>
            <td class="px-2 py-3 border-t border-slate-100">
                <input type="text" name="items[${rowIndex}][chassis_number]" required class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-mono text-sm" placeholder="Şase giriniz">
            </td>
            <td class="px-2 py-3 border-t border-slate-100">
                <input type="text" name="items[${rowIndex}][engine_number]" required class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-mono text-sm" placeholder="Motor no giriniz">
            </td>
            <td class="px-2 py-3 border-t border-slate-100 text-center">
                <button type="button" class="remove-row text-red-400 hover:text-red-600 p-2 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </td>
        `;
        detailsBody.appendChild(newRow);
        rowIndex++;
    });

    // Remove Row
    detailsBody.addEventListener('click', function(e) {
        if (e.target.closest('.remove-row')) {
            e.target.closest('.detail-row').remove();
        }
    });

    // Price Masking Logic
    function formatCurrency(input) {
        let value = input.value.replace(/\D/g, "");
        if (value === "") {
            input.dataset.raw = "";
            return;
        }
        
        // Convert to float
        let floatValue = parseFloat(value) / 100;
        input.dataset.raw = floatValue.toFixed(2);
        
        // Format with TR-locale
        input.value = new Intl.NumberFormat('tr-TR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(floatValue);
    }

    const priceInputs = document.querySelectorAll('.price-mask');
    priceInputs.forEach(input => {
        const hiddenInputId = input.id.replace('_display', '');
        const hiddenInput = document.getElementById(hiddenInputId);

        // Initial value if exists
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
            
            // Link to hidden input
            if (hiddenInput) {
                hiddenInput.value = this.dataset.raw;
            }

            // Adjust cursor position
            let newLength = this.value.length;
            cursorPosition = cursorPosition + (newLength - oldLength);
            this.setSelectionRange(cursorPosition, cursorPosition);
        });

        // Prevention of non-numeric chars
        input.addEventListener('keypress', function(e) {
            if (!/[0-9]/.test(e.key)) {
                e.preventDefault();
            }
        });
    });

    // Anti-spam & Submission
    document.getElementById('motorcycle-form').addEventListener('submit', function() {
        const btn = document.getElementById('submit-btn');
        const text = document.getElementById('btn-text');
        const spinner = document.getElementById('btn-spinner');
        
        btn.disabled = true;
        btn.classList.remove('bg-indigo-50', 'text-indigo-700');
        btn.classList.add('bg-indigo-600', 'text-white', 'opacity-70', 'cursor-not-allowed');
        text.innerText = 'Kayıt Yapılıyor...';
        spinner.classList.remove('hidden');
    });
});
</script>
@endsection
