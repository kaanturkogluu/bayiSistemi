@extends('layouts.admin')

@section('header', 'Yeni Bakım Kaydı')

@section('content')
    <div class="mb-6 flex items-center">
        <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('admin.maintenances.index') }}" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 hover:text-blue-600 mr-4 transition-colors shadow-sm">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Geri Dön
        </a>
        <h1 class="text-2xl font-bold text-slate-800">Sisteme Bakım/Onarım Ekle</h1>
    </div>

    <!-- We use Alpine.js here to handle dynamic part additions and calculations seamlessly on the frontend -->
    <div x-data="maintenanceForm()" class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 m-6 mb-0">
                <div class="flex items-center">
                    <div class="flex-shrink-0"><svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg></div>
                    <div class="ml-3"><h3 class="text-sm font-medium text-red-800">Lütfen formdaki hataları düzeltin.</h3></div>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.maintenances.store') }}" method="POST" class="p-6 sm:p-8" @submit="isSubmitting = true">
            @csrf

            <!-- STEP 1: Customer Selection -->
            <div class="mb-8">
                <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
                    <span class="bg-blue-600 text-white w-7 h-7 rounded-full inline-flex items-center justify-center mr-3 text-sm shadow-sm">1</span> 
                    Müşteri Seçimi
                </h2>
                <div class="bg-slate-50 p-6 rounded-xl border border-slate-200">
                    <label for="customer_id" class="block text-sm font-medium text-slate-700 mb-1">Müşteri <span class="text-red-500">*</span></label>
                    <div class="relative max-w-2xl" x-init="$(function(){ $($refs.customerSelect).select2({placeholder: 'Müşteri Ara veya Seç...', allowClear: true, width: '100%', theme: 'classic'}).on('change', function(e){ selectedCustomer = e.target.value; selectedVehicle = ''; }); if(selectedCustomer) $($refs.customerSelect).val(selectedCustomer).trigger('change.select2'); })">
                        <select x-ref="customerSelect" id="customer_id" x-model="selectedCustomer" name="customer_id" required class="w-full pl-4 pr-10 py-3 rounded-lg border @error('customer_id') border-red-300 focus:ring-red-500 focus:border-red-500 @else border-slate-300 focus:ring-blue-500 focus:border-blue-500 @enderror outline-none transition-all bg-white appearance-none" style="width: 100%">
                            <option value="" disabled selected>Müşteri Seçiniz</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name_surname }} - {{ $customer->phone ?? 'Telefon Yok' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('customer_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    
                    <div class="mt-3">
                        <a href="{{ route('admin.customers.create') }}" class="text-xs font-medium text-blue-600 hover:text-blue-800 transition-colors inline-flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Yeni Müşteri Oluştur
                        </a>
                    </div>
                </div>
            </div>

            <!-- STEP 2: Vehicle Selection -->
            <div class="mb-8" x-show="selectedCustomer && availableVehicles.length > 0" x-transition.opacity.duration.300ms style="display: none;">
                <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
                    <span class="bg-blue-600 text-white w-7 h-7 rounded-full inline-flex items-center justify-center mr-3 text-sm shadow-sm">2</span> 
                    Araç Plakası
                </h2>
                <div class="bg-slate-50 p-6 rounded-xl border border-slate-200">
                    <label for="vehicle_id" class="block text-sm font-medium text-slate-700 mb-1">İşlem Yapılacak Araç <span class="text-red-500">*</span></label>
                    <div class="relative max-w-sm">
                        <select id="vehicle_id" name="vehicle_id" x-model="selectedVehicle" :required="availableVehicles.length > 0" class="w-full pl-4 pr-10 py-3 rounded-lg border @error('vehicle_id') border-red-300 focus:ring-red-500 focus:border-red-500 @else border-slate-300 focus:ring-blue-500 focus:border-blue-500 @enderror outline-none transition-all bg-white appearance-none uppercase font-bold text-lg text-slate-700 shadow-sm">
                            <option value="" disabled selected>Plaka Seçiniz</option>
                            <template x-for="vehicle in availableVehicles" :key="vehicle.id">
                                <option :value="vehicle.id" x-text="vehicle.plate" :selected="vehicle.id == '{{ old('vehicle_id') }}'"></option>
                            </template>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                    @error('vehicle_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror

                    <div class="mt-3" x-show="selectedCustomer">
                        <a :href="'/admin/customers/' + selectedCustomer + '/edit'" class="text-xs font-medium text-emerald-600 hover:text-emerald-800 transition-colors inline-flex items-center" target="_blank">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Seçili Müşteriye Yeni Plaka Ekle
                        </a>
                    </div>
                </div>
            </div>

            <!-- STEP 3: Labor & Parts -->
            <div x-show="(selectedCustomer && availableVehicles.length === 0) || selectedVehicle" x-transition.opacity.duration.400ms style="display: none;">
                <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
                    <span class="bg-blue-600 text-white w-7 h-7 rounded-full inline-flex items-center justify-center mr-3 text-sm shadow-sm" x-text="availableVehicles.length > 0 ? '3' : '2'">3</span> 
                    Ücret ve Yedek Parça Detayları
                </h2>
                
                <div class="bg-slate-50 p-6 rounded-xl border border-slate-200 mb-6">
                    <label for="labor_cost_display" class="block text-sm font-medium text-slate-700 mb-1">İşçilik Ücreti (TL) <span class="text-red-500">*</span></label>
                    <div class="relative max-w-sm">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-slate-400 font-medium text-lg">₺</span>
                        </div>
                        <input type="text" id="labor_cost_display" x-mask:dynamic="$money($input, ',', '.', 2)" x-model="displayLaborCost" @input="updateLaborCost($event.target.value)" required
                            class="pl-10 w-full px-4 py-3 rounded-lg border @error('labor_cost') border-red-300 focus:ring-red-500 focus:border-red-500 @else border-slate-300 focus:ring-blue-500 focus:border-blue-500 @enderror outline-none transition-all text-right font-bold text-lg text-slate-800 shadow-sm"
                            placeholder="0,00">
                        <!-- Hidden input to send actual numeric value to backend -->
                        <input type="hidden" name="labor_cost" :value="laborCost">
                    </div>
                    <p class="mt-1 text-sm text-slate-500">Uygulanan işlem için sabit işçilik ücreti.</p>
                    @error('labor_cost') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Parts Section -->
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-base font-bold text-slate-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Kullanılan Yedek Parçalar
                    </h3>
                </div>
                
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-1 mb-8">
                    <!-- Titles for desktop -->
                    <div class="hidden md:grid md:grid-cols-12 gap-4 px-4 py-3 bg-slate-100/50 rounded-t-lg border-b border-slate-200 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        <div class="md:col-span-4">Parça Adı <span class="text-red-500">*</span></div>
                        <div class="md:col-span-2">Adet <span class="text-red-500">*</span></div>
                        <div class="md:col-span-2 text-right">Birim Fiyat (TL) <span class="text-red-500">*</span></div>
                        <div class="md:col-span-3">Not / Açıklama</div>
                        <div class="md:col-span-1 text-center">Sil</div>
                    </div>

                    <!-- Template for parts -->
                    <template x-for="(part, index) in parts" :key="index">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 p-4 border-b border-slate-200 last:border-0 items-start md:items-center relative bg-white first:rounded-t-none last:rounded-b-lg group">
                            
                            <!-- Mobile Item Header -->
                            <div class="md:hidden flex justify-between items-center mb-2 pb-2 border-b border-slate-100">
                                <span class="font-bold text-slate-700 text-sm">Parça #<span x-text="index + 1"></span></span>
                                <button type="button" @click="removePart(index)" class="text-red-500 hover:text-red-700 p-1 bg-red-50 rounded-md">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>

                            <!-- Name -->
                            <div class="md:col-span-4">
                                <label class="md:hidden block text-xs font-medium text-slate-500 mb-1">Parça Adı</label>
                                <input type="text" x-model="part.name" :name="'parts['+index+'][name]'" required
                                    class="w-full px-3 py-2 text-sm rounded-md border border-slate-300 focus:ring-blue-500 focus:border-blue-500 outline-none" placeholder="Örn: Yağ Filtresi">
                            </div>
                            
                            <!-- Quantity -->
                            <div class="md:col-span-2">
                                <label class="md:hidden block text-xs font-medium text-slate-500 mb-1">Adet</label>
                                <div class="flex items-center">
                                    <input type="number" step="1" min="1" x-model.number="part.quantity" :name="'parts['+index+'][quantity]'" required
                                        class="w-full px-3 py-2 text-sm rounded-md border border-slate-300 focus:ring-blue-500 focus:border-blue-500 outline-none md:text-center text-right font-medium text-slate-700">
                                </div>
                            </div>
                            
                            <!-- Unit Price -->
                            <div class="md:col-span-2">
                                <label class="md:hidden block text-xs font-medium text-slate-500 mb-1">Birim Fiyat (TL)</label>
                                <div class="relative">
                                    <input type="text" x-mask:dynamic="$money($input, ',', '.', 2)" x-model="part.display_unit_price" @input="updatePartUnitPrice(index, $event.target.value)" required
                                        class="w-full px-3 py-2 pl-6 text-sm rounded-md border border-slate-300 focus:ring-blue-500 focus:border-blue-500 outline-none text-right font-medium" placeholder="0,00">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none text-slate-400 font-medium text-sm">₺</div>
                                    <input type="hidden" :name="'parts['+index+'][unit_price]'" :value="part.unit_price">
                                </div>
                            </div>
                            
                            <!-- Note -->
                            <div class="md:col-span-3">
                                <label class="md:hidden block text-xs font-medium text-slate-500 mb-1">Not (Opsiyonel)</label>
                                <input type="text" x-model="part.note" :name="'parts['+index+'][note]'"
                                    class="w-full px-3 py-2 text-sm rounded-md border border-transparent hover:border-slate-300 focus:border-slate-300 bg-slate-50 focus:bg-white focus:ring-blue-500 outline-none transition-all" placeholder="Opsiyonel not (örn: sol arka)">
                            </div>
                            
                            <!-- Delete Action (Desktop) -->
                            <div class="hidden md:flex md:col-span-1 justify-center">
                                <button type="button" @click="removePart(index)" class="text-slate-400 hover:text-red-500 p-2 rounded-full hover:bg-red-50 transition-colors opacity-0 group-hover:opacity-100 focus:opacity-100" title="Parçayı Sil">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </div>
                    </template>

                    <!-- Add Part Button inside the border area -->
                    <div class="bg-white p-4 text-center rounded-b-lg border-t border-slate-100">
                        <button type="button" @click="addPart()" class="inline-flex items-center px-4 py-2 border border-slate-300 shadow-sm text-sm font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Yeni Parça Satırı Ekle
                        </button>
                        <!-- Small instruction text if empty -->
                        <p x-show="parts.length === 0" class="text-xs text-orange-500 mt-2 font-medium">Lütfen en az bir parça ekleyiniz veya işçilik ücreti var ise işçilik yazınız.</p>
                    </div>
                </div>

                <!-- Grand Total Calculation Section -->
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-6 flex flex-col items-end mb-8 shadow-inner">
                    
                    <div class="w-full sm:w-1/2 md:w-1/3 mb-2 flex justify-between text-slate-600 text-sm">
                        <span>Parça Ara Toplam:</span>
                        <span class="font-medium" x-text="formatCurrency(calculatePartsTotal())"></span>
                    </div>
                    
                    <div class="w-full sm:w-1/2 md:w-1/3 mb-4 flex justify-between text-slate-600 text-sm">
                        <span>İşçilik Ücreti:</span>
                        <span class="font-medium" x-text="formatCurrency(laborCost || 0)"></span>
                    </div>

                    <div class="w-full sm:w-1/2 md:w-1/3 pt-4 border-t border-blue-200/50 flex justify-between items-center text-slate-900">
                        <span class="font-bold text-lg">Genel Toplam Tutar:</span>
                        <div class="text-right">
                            <span class="font-black text-2xl text-blue-700" x-text="formatCurrency(calculateGrandTotal())"></span>
                            
                            <!-- Create a hidden input to submit the total cost since we calculate it dynamically -->
                            <input type="hidden" name="total_cost" :value="calculateGrandTotal()">
                        </div>
                    </div>
                </div>

                <!-- Submit Area -->
                <div class="pt-4 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-3 sm:gap-4 border-t border-slate-200">
                    <a href="{{ route('admin.maintenances.index') }}" class="px-6 py-3 border border-slate-300 rounded-xl text-slate-700 hover:bg-slate-50 font-medium transition-colors text-center w-full sm:w-auto">
                        İptal Et
                    </a>
                    <button type="submit" 
                            :disabled="isSubmitting" 
                            class="px-8 py-3 border border-transparent rounded-xl text-white font-bold transition-all shadow-md text-lg flex justify-center items-center hover:shadow-lg transform hover:-translate-y-0.5 w-full sm:w-auto"
                            :class="isSubmitting ? 'bg-slate-400 cursor-not-allowed hidden' : 'bg-blue-600 hover:bg-blue-700'">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Bakımı Kaydet
                    </button>
                    <!-- Loading state indicator -->
                    <button type="button" disabled x-show="isSubmitting" style="display: none;"
                            class="px-8 py-3 w-full sm:w-auto border border-transparent rounded-xl text-white font-bold bg-slate-400 cursor-not-allowed shadow-md text-lg flex justify-center items-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Kaydediliyor...
                    </button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('maintenanceForm', () => ({
                isSubmitting: false,
                laborCost: {{ old('labor_cost', 0) }},
                displayLaborCost: '{{ number_format(old('labor_cost', 0), 2, ',', '.') }}',
                selectedCustomer: '{{ old('customer_id', $selectedCustomerId ?? '') }}',
                selectedVehicle: '{{ old('vehicle_id', '') }}',
                customerVehiclesMap: @json($customerVehicles),

                get availableVehicles() {
                    if (!this.selectedCustomer) return [];
                    return this.customerVehiclesMap[this.selectedCustomer] || [];
                },
                
                parts: [
                    @if(old('parts'))
                        @foreach(old('parts') as $part)
                            { 
                                name: "{{ $part['name'] }}", 
                                quantity: {{ intval($part['quantity'] ?? 1) }}, 
                                unit_price: {{ floatval($part['unit_price'] ?? 0) }},
                                display_unit_price: '{{ number_format($part['unit_price'] ?? 0, 2, ',', '.') }}',
                                note: "{{ $part['note'] ?? '' }}" 
                            },
                        @endforeach
                    @else
                        { name: '', quantity: 1, unit_price: 0, display_unit_price: '', note: '' }
                    @endif
                ],
                
                addPart() {
                    this.parts.push({ name: '', quantity: 1, unit_price: 0, display_unit_price: '', note: '' });
                },
                
                removePart(index) {
                    this.parts.splice(index, 1);
                },

                updateLaborCost(value) {
                    if(!value) {
                        this.laborCost = 0;
                        return;
                    }
                    let plainNumber = value.replace(/\./g, '').replace(',', '.');
                    this.laborCost = parseFloat(plainNumber) || 0;
                },

                updatePartUnitPrice(index, value) {
                    if(!value) {
                        this.parts[index].unit_price = 0;
                        return;
                    }
                    let plainNumber = value.replace(/\./g, '').replace(',', '.');
                    this.parts[index].unit_price = parseFloat(plainNumber) || 0;
                },
                
                calculatePartsTotal() {
                    return this.parts.reduce((total, part) => {
                        const q = parseInt(part.quantity) || 0;
                        const p = parseFloat(part.unit_price) || 0;
                        return total + (q * p);
                    }, 0);
                },
                
                calculateGrandTotal() {
                    const l = parseFloat(this.laborCost) || 0;
                    return this.calculatePartsTotal() + l;
                },

                formatCurrency(value) {
                    return new Intl.NumberFormat('tr-TR', { style: 'currency', currency: 'TRY' }).format(value);
                }
            }));
        });
    </script>
    
    <style>
        /* Modern Select2 Tailwind Override to match our other inputs */
        .select2-container--classic .select2-selection--single {
            height: 48px;
            padding: 8px 16px;
            border-radius: 0.5rem;
            border-color: #cbd5e1;
            font-size: 1rem;
            line-height: 1.5rem;
            display: flex;
            align-items: center;
            background-image: none;
            background-color: white;
            box-shadow: none;
        }
        
        .select2-container--classic .select2-selection--single:focus,
        .select2-container--classic.select2-container--open .select2-selection--single {
            border-color: #3b82f6; 
            outline: none;
            box-shadow: 0 0 0 1px #3b82f6;
            background-image: none;
        }

        .select2-container--classic .select2-selection--single .select2-selection__arrow {
            height: 48px;
            right: 8px;
            background-image: none;
            border-left: none;
        }

        .select2-container--classic .select2-dropdown {
            border-color: #cbd5e1;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }

        .select2-container--classic .select2-search--dropdown .select2-search__field {
            border-color: #cbd5e1;
            border-radius: 0.375rem;
            padding: 8px;
            outline: none;
        }
        
        .select2-container--classic .select2-search--dropdown .select2-search__field:focus {
            border-color: #3b82f6;
        }

        .select2-container--classic .select2-results__option--highlighted.select2-results__option--selectable {
            background-color: #3b82f6;
        }
    </style>
    @endpush
@endsection
