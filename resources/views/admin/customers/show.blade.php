@extends('layouts.admin')

@section('header', 'Cari Hesap')

@section('content')
    {{-- Header --}}
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('admin.customers.index') }}"
                class="inline-flex items-center justify-center w-10 h-10 bg-white border border-slate-200 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-slate-50 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">{{ $customer->name_surname }} <span class="text-sm font-normal text-slate-400 ml-2">TC: {{ $customer->tc_no ?? 'Belirtilmemiş' }}</span></h1>
                <p class="text-slate-500 text-sm">{{ $customer->phone ?? 'Telefon belirtilmemiş' }} &bull; Cari Hesap Takibi</p>
                @if($customer->address)
                    <p class="text-slate-400 text-xs mt-1 flex items-start gap-1">
                        <svg class="w-3.5 h-3.5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $customer->address }}
                    </p>
                @endif
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.customers.maintenances', $customer) }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-600 font-semibold rounded-xl hover:bg-slate-50 hover:text-purple-600 transition-colors shadow-sm text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.354 4.317a1.724 1.724 0 003.35 0c1.543.94 3.31-.826 2.37-2.37a1.724 1.724 0 001.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 00-1.066-2.573c-.94-1.543-.826-3.31-2.37-2.37a1.724 1.724 0 00-2.572-1.065c-.426-1.756-2.924-1.756-3.35 0a1.724 1.724 0 00-2.573 1.066c-1.543-.94-3.31.826-2.37 2.37a1.724 1.724 0 00-1.065 2.572c-1.756.426-1.756 2.924 0 3.35a1.724 1.724 0 001.066 2.573c.94 1.543.826 3.31 2.37 2.37.996-.608 2.296-.07 2.572 1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Bakım Geçmişi
            </a>
            @if ($customer->balance > 0)
            <button onclick="openPaymentModal()"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-700 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tahsilat Ekle
            </button>
            @endif
        </div>
    </div>


    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 flex items-start gap-2">
            <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <div>
                <p class="font-bold text-sm">İşlem gerçekleştirilemedi:</p>
                <ul class="list-disc list-inside text-sm mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        {{-- Total Debt --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Toplam Borç</p>
                <p class="text-xl font-black text-slate-900 mt-0.5">
                    {{ number_format($customer->transactions()->where('type', 'debt')->sum('amount'), 2, ',', '.') }} ₺
                </p>
            </div>
        </div>

        {{-- Total Paid --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4 4-6 6"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Toplam Ödenen</p>
                <p class="text-xl font-black text-emerald-600 mt-0.5">
                    {{ number_format($customer->transactions()->where('type', 'payment')->sum('amount'), 2, ',', '.') }} ₺
                </p>
            </div>
        </div>

        {{-- Balance --}}
        @php $balancePositive = $customer->balance > 0; @endphp
        <div class="rounded-2xl border-2 shadow-sm p-5 flex items-center gap-4 {{ $balancePositive ? 'bg-red-50 border-red-200' : 'bg-emerald-50 border-emerald-200' }}">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 {{ $balancePositive ? 'bg-red-200' : 'bg-emerald-200' }}">
                <svg class="w-6 h-6 {{ $balancePositive ? 'text-red-600' : 'text-emerald-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider {{ $balancePositive ? 'text-red-600' : 'text-emerald-600' }}">
                    {{ $balancePositive ? 'Kalan Bakiye (Borç)' : 'Kalan Bakiye' }}
                </p>
                <p class="text-xl font-black mt-0.5 {{ $balancePositive ? 'text-red-700' : 'text-emerald-700' }}">
                    {{ number_format($customer->balance, 2, ',', '.') }} ₺
                </p>
            </div>
        </div>
    </div>

    {{-- Transaction Table --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h2 class="text-base font-bold text-slate-800">Hesap Hareketleri</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-semibold tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3">Tarih</th>
                        <th class="px-6 py-3 text-center">Tip</th>
                        <th class="px-6 py-3">Açıklama</th>
                        <th class="px-6 py-3 text-center">Yöntem</th>
                        <th class="px-6 py-3 text-right">Borç (+)</th>
                        <th class="px-6 py-3 text-right">Ödeme (-)</th>
                        <th class="px-6 py-3 text-right"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($customer->transactions as $trans)
                        <tr class="hover:bg-slate-50 transition-colors {{ $trans->type === 'debt' ? 'bg-red-50/30' : '' }}">
                            <td class="px-6 py-3.5 whitespace-nowrap text-slate-500 text-xs">
                                {{ $trans->date->format('d/m/Y') }}<br>
                                <span class="text-slate-400">{{ $trans->date->format('H:i') }}</span>
                            </td>
                            <td class="px-6 py-3.5 whitespace-nowrap text-center">
                                @if ($trans->type === 'debt')
                                    <span class="inline-flex items-center px-2 py-0.5 bg-red-100 text-red-700 rounded-full text-xs font-bold">BORÇ</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 bg-emerald-100 text-emerald-700 rounded-full text-xs font-bold">ÖDEME</span>
                                @endif
                            </td>
                            <td class="px-6 py-3.5 text-slate-700 font-medium max-w-xs truncate">
                                {{ $trans->description }}
                            </td>
                            <td class="px-6 py-3.5 whitespace-nowrap text-center">
                                @if($trans->payment_method === 'nakit')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-slate-100 text-slate-700 rounded-full text-xs font-bold">💵 Nakit</span>
                                @elseif($trans->payment_method === 'kart')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">💳 Kart</span>
                                @elseif($trans->payment_method === 'borc')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-amber-100 text-amber-700 rounded-full text-xs font-bold">📋 Borç</span>
                                @else
                                    <span class="text-slate-400 text-xs">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-3.5 whitespace-nowrap text-right font-bold text-red-600">
                                @if($trans->type === 'debt')
                                    {{ number_format($trans->amount, 2, ',', '.') }} ₺
                                @else
                                    <span class="text-slate-300">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-3.5 whitespace-nowrap text-right font-bold text-emerald-600">
                                @if($trans->type === 'payment')
                                    {{ number_format($trans->amount, 2, ',', '.') }} ₺
                                @else
                                    <span class="text-slate-300">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-3.5 whitespace-nowrap text-right">
                                @if($trans->type === 'payment')
                                    <form action="{{ route('admin.transactions.destroy', $trans) }}" method="POST"
                                        onsubmit="return confirm('Bu ödeme silinecek, bakiye yeniden hesaplanacak. Onaylıyor musunuz?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-slate-300 hover:text-red-500 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center gap-2 text-slate-400">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    <p class="font-medium">Henüz hesap hareketi yok</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Payment Modal --}}
    <div id="paymentModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closePaymentModal()"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md">
                {{-- Modal Header --}}
                <div class="px-6 pt-6 pb-4 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Tahsilat Ekle</h3>
                        <p class="text-sm text-slate-500 mt-0.5">{{ $customer->name_surname }}</p>
                    </div>
                    <button onclick="closePaymentModal()" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('admin.customers.transactions.store', $customer) }}" method="POST">
                    @csrf
                    <div class="px-6 py-5 space-y-5">

                        {{-- Amount --}}
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-sm font-semibold text-slate-700">Tahsilat Tutarı</label>
                                @php $maxAmount = $customer->balance > 0 ? $customer->balance : 0; @endphp
                                @if($maxAmount > 0)
                                    <button type="button" onclick="document.getElementById('paymentAmountInput').value = '{{ number_format($maxAmount, 2, '.', '') }}'" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-2.5 py-1 rounded transition-colors">
                                        Tüm Borcu Tahsil Et
                                    </button>
                                @endif
                            </div>
                            <div class="relative">
                                <input type="number" step="0.01" min="0.01" max="{{ $maxAmount }}" name="amount" id="paymentAmountInput" required
                                    oninput="if(parseFloat(this.value) > {{ $maxAmount }}) this.value = '{{ number_format($maxAmount, 2, '.', '') }}';"
                                    class="w-full pl-4 pr-14 py-3 border border-slate-300 rounded-xl text-lg font-bold focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                                    placeholder="0,00">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">₺</span>
                            </div>
                            <p class="text-xs text-slate-500 mt-1.5">Maksimum tahsil edilebilir: <strong class="text-slate-700">{{ number_format($maxAmount, 2, ',', '.') }} ₺</strong></p>
                        </div>

                        {{-- Payment Method --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Ödeme Yöntemi</label>
                            <div class="grid grid-cols-3 gap-3">
                                {{-- Cash --}}
                                <label class="payment-method-label cursor-pointer">
                                    <input type="radio" name="payment_method" value="nakit" class="sr-only" checked onchange="selectMethod(this)">
                                    <div class="method-card selected-nakit flex flex-col items-center gap-2 p-4 rounded-xl border-2 border-emerald-500 bg-emerald-50 text-center transition-all">
                                        <span class="text-2xl">💵</span>
                                        <span class="text-xs font-bold text-emerald-700 uppercase tracking-wide">Nakit</span>
                                    </div>
                                </label>
                                {{-- Card --}}
                                <label class="payment-method-label cursor-pointer">
                                    <input type="radio" name="payment_method" value="kart" class="sr-only" onchange="selectMethod(this)">
                                    <div class="method-card flex flex-col items-center gap-2 p-4 rounded-xl border-2 border-slate-200 bg-white text-center transition-all">
                                        <span class="text-2xl">💳</span>
                                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wide">Kart</span>
                                    </div>
                                </label>
                                {{-- Debt --}}
                                <label class="payment-method-label cursor-pointer">
                                    <input type="radio" name="payment_method" value="borc" class="sr-only" onchange="selectMethod(this)">
                                    <div class="method-card flex flex-col items-center gap-2 p-4 rounded-xl border-2 border-slate-200 bg-white text-center transition-all">
                                        <span class="text-2xl">📋</span>
                                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wide">Borç</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Date --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Tarih ve Saat</label>
                            <input type="datetime-local" name="date" value="{{ date('Y-m-d\TH:i') }}" required
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                        </div>

                        {{-- Note --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Not <span class="font-normal text-slate-400">(opsiyonel)</span></label>
                            <input type="text" name="description"
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                                placeholder="Örn: 1. taksit ödemesi">
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="px-6 pb-6 flex gap-3">
                        <button type="button" onclick="closePaymentModal()"
                            class="flex-1 py-2.5 rounded-xl border border-slate-300 text-slate-700 font-semibold hover:bg-slate-50 transition-colors">
                            İptal
                        </button>
                        <button type="submit"
                            class="flex-1 py-2.5 rounded-xl bg-emerald-600 text-white font-bold hover:bg-emerald-700 transition-colors shadow-sm">
                            Kaydet
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openPaymentModal() {
            document.getElementById('paymentModal').classList.remove('hidden');
        }
        function closePaymentModal() {
            document.getElementById('paymentModal').classList.add('hidden');
        }

        const colorMap = {
            nakit: { border: 'border-emerald-500', bg: 'bg-emerald-50', text: 'text-emerald-700' },
            kart:  { border: 'border-blue-500',    bg: 'bg-blue-50',    text: 'text-blue-700' },
            borc:  { border: 'border-amber-500',   bg: 'bg-amber-50',   text: 'text-amber-700' },
        };

        function selectMethod(radio) {
            document.querySelectorAll('.payment-method-label').forEach(label => {
                const card = label.querySelector('.method-card');
                const span = card.querySelector('span:last-child');
                card.classList.remove('border-emerald-500','bg-emerald-50','border-blue-500','bg-blue-50','border-amber-500','bg-amber-50');
                card.classList.add('border-slate-200', 'bg-white');
                span.className = 'text-xs font-bold text-slate-500 uppercase tracking-wide';
            });
            const c = colorMap[radio.value];
            const activeCard = radio.closest('label').querySelector('.method-card');
            const activeSpan = activeCard.querySelector('span:last-child');
            activeCard.classList.remove('border-slate-200', 'bg-white');
            activeCard.classList.add(c.border, c.bg);
            activeSpan.className = 'text-xs font-bold uppercase tracking-wide ' + c.text;
        }
    </script>
@endsection