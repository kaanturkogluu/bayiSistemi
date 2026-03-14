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
                            <div class="flex items-center justify-between mb-1">
                                <label for="customer_id" class="block text-sm font-bold text-slate-700">Müşteri Seçin <span class="text-red-500">*</span></label>
                                <button type="button" onclick="openCustomerModal()" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition-colors flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Hızlı Müşteri Ekle
                                </button>
                            </div>
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

<!-- Quick Customer Modal -->
<style>
    .modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(15, 23, 42, 0.5);
        backdrop-filter: blur(4px);
        z-index: 50;
    }
    .modal-content-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 51;
        padding: 1rem;
        pointer-events: none;
    }
    .modal-card {
        background: white;
        border-radius: 1rem;
        width: 100%;
        max-width: 500px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        position: relative;
        pointer-events: auto;
    }
</style>

<div id="customer-modal" class="hidden">
    <div class="modal-backdrop"></div>
    <div class="modal-content-wrapper">
        <div class="modal-card overflow-hidden">
            <div class="bg-white px-6 pt-6 pb-4 sm:p-6 sm:pb-4">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-slate-900">Hızlı Müşteri Ekle</h3>
                    <button type="button" onclick="closeCustomerModal()" class="text-slate-400 hover:text-slate-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="space-y-4">
                    <div>
                        <label for="modal_name_surname" class="block text-sm font-bold text-slate-700 mb-1">Ad Soyad <span class="text-red-500">*</span></label>
                        <input type="text" id="modal_name_surname" class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm" placeholder="Müşteri Adı Soyadı">
                    </div>
                    <div>
                        <label for="modal_tc_no" class="block text-sm font-bold text-slate-700 mb-1">TC Kimlik No <span class="text-red-500">*</span></label>
                        <input type="text" id="modal_tc_no" maxlength="11" class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm" placeholder="11 Haneli TC No">
                    </div>
                    <div>
                        <label for="modal_phone" class="block text-sm font-bold text-slate-700 mb-1">Telefon</label>
                        <input type="text" id="modal_phone" class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm" placeholder="05XX XXX XX XX">
                    </div>
                    <div>
                        <label for="modal_address" class="block text-sm font-bold text-slate-700 mb-1">Adres <span class="text-red-500">*</span></label>
                        <textarea id="modal_address" rows="3" class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm" placeholder="Müşterinin açık adresi..."></textarea>
                    </div>
                </div>
            </div>
            <div class="bg-slate-50 px-6 py-4 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="submitQuickCustomer()" id="modal-submit-btn" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-bold text-white hover:bg-indigo-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition-all flex items-center">
                    <span>Kaydet</span>
                    <span id="modal-spinner" class="hidden ml-2">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                </button>
                <button type="button" onclick="closeCustomerModal()" class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-all">
                    İptal
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openCustomerModal() {
    document.getElementById('customer-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeCustomerModal() {
    document.getElementById('customer-modal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    // Clear inputs
    document.getElementById('modal_name_surname').value = '';
    document.getElementById('modal_tc_no').value = '';
    document.getElementById('modal_phone').value = '';
    document.getElementById('modal_address').value = '';
}

async function submitQuickCustomer() {
    const name_surname = document.getElementById('modal_name_surname').value;
    const tc_no = document.getElementById('modal_tc_no').value;
    const phone = document.getElementById('modal_phone').value;
    const address = document.getElementById('modal_address').value;
    const btn = document.getElementById('modal-submit-btn');
    const spinner = document.getElementById('modal-spinner');

    if (!name_surname || !tc_no || !address) {
        alert('Lütfen Ad Soyad, TC No ve Adres alanlarını doldurunuz.');
        return;
    }

    if (tc_no.length !== 11) {
        alert('TC No 11 haneli olmalıdır.');
        return;
    }

    btn.disabled = true;
    spinner.classList.remove('hidden');

    try {
        const response = await fetch("{{ route('admin.customers.quick_store') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ name_surname, tc_no, phone, address })
        });

        const data = await response.json();

        if (data.success) {
            // Add to Select2
            const newOption = new Option(data.customer.name_surname + (data.customer.phone ? ' (' + data.customer.phone + ')' : ''), data.customer.id, true, true);
            $('#customer_id').append(newOption).trigger('change');
            closeCustomerModal();
        } else {
            alert('Müşteri eklenirken bir hata oluştu.');
        }
    } catch (error) {
        console.error(error);
        alert('Bir hata oluştu.');
    } finally {
        btn.disabled = false;
        spinner.classList.add('hidden');
    }
}

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
