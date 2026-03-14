@extends('layouts.admin')

@section('header', 'Model Düzenle')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.data_center.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-indigo-600">
                        Veri Merkezi
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('admin.motorcycle-models.index') }}" class="ml-1 text-sm font-medium text-slate-500 hover:text-indigo-600 md:ml-2">Modeller</a>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-8">
            <h3 class="text-xl font-bold text-slate-800 mb-6">Model Düzenleme Formu</h3>
            <form action="{{ route('admin.motorcycle-models.update', $motorcycleModel) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label for="brand_id" class="block text-sm font-bold text-slate-700 mb-1">Marka <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select name="brand_id" id="brand_id" required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all appearance-none bg-white">
                                <option value="">Marka Seçiniz</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ old('brand_id', $motorcycleModel->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                        @error('brand_id')
                            <p class="mt-1 text-xs text-red-500 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-bold text-slate-700 mb-1">Model Adı <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" required value="{{ old('name', $motorcycleModel->name) }}"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder:text-slate-400"
                            placeholder="Örn: PCX 125, NMAX 155">
                        @error('name')
                            <p class="mt-1 text-xs text-red-500 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4 flex items-center justify-end space-x-3">
                        <a href="{{ route('admin.motorcycle-models.index') }}" class="px-6 py-2.5 rounded-xl text-sm font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-all">
                            Vazgeç
                        </a>
                        <button type="submit" id="submit-btn" class="px-6 py-2.5 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-xl text-sm font-bold hover:bg-indigo-100 transition-all shadow-sm flex items-center">
                            <span id="btn-text">Güncelle</span>
                            <span id="btn-spinner" class="hidden ml-2">
                                <svg class="animate-spin h-4 w-4 text-indigo-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const btn = document.getElementById('submit-btn');
    const text = document.getElementById('btn-text');
    const spinner = document.getElementById('btn-spinner');
    
    btn.disabled = true;
    btn.classList.add('opacity-50', 'cursor-not-allowed');
    text.innerText = 'Güncelleniyor...';
    spinner.classList.remove('hidden');
});
</script>
@endsection
