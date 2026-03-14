@extends('layouts.admin')

@section('header', 'Yeni Müşteri Oluştur')

@section('content')
    <div class="mb-6 flex items-center">
        <a href="{{ route('admin.customers.index') }}" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 hover:text-blue-600 mr-4 transition-colors shadow-sm">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Geri Dön
        </a>
        <h1 class="text-2xl font-bold text-slate-800">Sisteme Müşteri Ekle</h1>
    </div>

    <div x-data="customerForm()" class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden max-w-2xl">
        <form action="{{ route('admin.customers.store') }}" method="POST" class="p-6 sm:p-8 space-y-6" @submit="isSubmitting = true">
            @csrf

            <!-- Name Surname -->
            <div>
                <label for="name_surname" class="block text-sm font-medium text-slate-700 mb-1">Ad Soyad</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <input type="text" name="name_surname" id="name_surname" value="{{ old('name_surname') }}" required
                        class="pl-10 w-full px-4 py-3 rounded-lg border @error('name_surname') border-red-300 focus:ring-red-500 focus:border-red-500 @else border-slate-300 focus:ring-blue-500 focus:border-blue-500 @enderror outline-none transition-all"
                        placeholder="Örn: Ali Yılmaz">
                </div>
                @error('name_surname')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- TC No -->
            <div>
                <label for="tc_no" class="block text-sm font-medium text-slate-700 mb-1">TC Kimlik No</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </div>
                    <input type="text" name="tc_no" id="tc_no" value="{{ old('tc_no') }}" maxlength="11" x-mask="99999999999"
                        class="pl-10 w-full px-4 py-3 rounded-lg border @error('tc_no') border-red-300 focus:ring-red-500 focus:border-red-500 @else border-slate-300 focus:ring-blue-500 focus:border-blue-500 @enderror outline-none transition-all"
                        placeholder="11 Haneli TC No">
                </div>
                @error('tc_no')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone -->
            <div x-data="{ phoneStr: '{{ str_replace('+90 ', '', str_replace('+90', '', old('phone', ''))) }}' }">
                <label for="phone" class="block text-sm font-medium text-slate-700 mb-1">Telefon</label>
                <div class="relative flex">
                    <span class="inline-flex items-center px-4 py-3 rounded-l-lg border border-r-0 border-slate-300 bg-slate-50 text-slate-500 font-bold shrink-0 select-none">
                        +90
                    </span>
                    <input type="text" x-model="phoneStr" x-mask="(999) 999 99 99"
                        class="w-full px-4 py-3 rounded-r-lg border @error('phone') border-red-300 focus:ring-red-500 focus:border-red-500 @else border-slate-300 focus:ring-blue-500 focus:border-blue-500 @enderror outline-none transition-all"
                        placeholder="(555) 555 55 55">
                    <input type="hidden" name="phone" id="phone" :value="phoneStr ? '+90 ' + phoneStr : ''">
                </div>
                @error('phone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Address -->
            <div>
                <label for="address" class="block text-sm font-medium text-slate-700 mb-1">Adres</label>
                <textarea name="address" id="address" rows="3"
                    class="w-full px-4 py-3 rounded-lg border @error('address') border-red-300 focus:ring-red-500 focus:border-red-500 @else border-slate-300 focus:ring-blue-500 focus:border-blue-500 @enderror outline-none transition-all"
                    placeholder="Müşterinin açık adresi...">{{ old('address') }}</textarea>
                @error('address')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="border-t border-slate-200 my-6 pt-6">
                <h3 class="text-sm font-bold text-slate-800 flex items-center mb-4">
                    <svg class="w-5 h-5 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    Araç Plakaları
                </h3>

                <div class="space-y-3">
                    <template x-for="(plate, index) in plates" :key="index">
                        <div class="flex items-center space-x-3" x-transition>
                            <div class="relative flex-1">
                                <input type="text" x-model="plate.value" :name="'plates[]'" 
                                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 outline-none uppercase" 
                                    placeholder="Örn: 34ABC123">
                            </div>
                            <button type="button" @click="removePlate(index)" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Plakayı Sil">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </template>
                </div>

                <div class="mt-4">
                    <button type="button" @click="addPlate()" class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Yeni Plaka Ekle
                    </button>
                </div>
                @error('plates.*')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 flex items-center justify-end space-x-3 border-t border-slate-100">
                <a href="{{ route('admin.customers.index') }}" class="px-5 py-2.5 border border-slate-300 rounded-lg text-slate-700 bg-white hover:bg-slate-50 font-medium transition-colors">
                    İptal
                </a>
                <button type="submit" 
                        :disabled="isSubmitting"
                        :class="isSubmitting ? 'bg-slate-400 cursor-not-allowed hidden' : 'bg-blue-600 hover:bg-blue-700'"
                        class="px-5 py-2.5 border border-transparent rounded-lg text-white font-medium transition-colors shadow-sm inline-flex items-center">
                    Müşteriyi Kaydet
                </button>
                <!-- Loading state indicator -->
                <button type="button" disabled x-show="isSubmitting" style="display: none;"
                        class="px-5 py-2.5 border border-transparent rounded-lg text-white font-medium bg-slate-400 cursor-not-allowed shadow-sm inline-flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Kaydediliyor...
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('customerForm', () => ({
                isSubmitting: false,
                plates: [
                    @if(old('plates'))
                        @foreach(old('plates') as $plate)
                            { value: "{{ $plate }}" },
                        @endforeach
                    @else
                        { value: '' }
                    @endif
                ],
                addPlate() {
                    this.plates.push({ value: '' });
                },
                removePlate(index) {
                    this.plates.splice(index, 1);
                }
            }));
        });
    </script>
    @endpush
@endsection
