@extends('layouts.admin')

@section('header')
    Araç Bakım Detayları
@endsection

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <a href="{{ route('admin.usta.maintenances', ['status' => $maintenance->status]) }}"
            class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 hover:text-blue-600 transition-colors shadow-sm self-start">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Listeye Dön
        </a>

        <div class="flex items-center gap-3">
            @if($maintenance->status === 'bekliyor')
                <form action="{{ route('admin.usta.maintenances.complete', $maintenance) }}" method="POST"
                    onsubmit="return confirm('Tüm parçaların bakımını tamamladığınızdan emin misiniz?');">
                    @csrf
                    <button type="submit"
                        class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl shadow-sm transition-colors flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Bakımı Tamamla
                    </button>
                </form>
            @else
                <span
                    class="px-5 py-2.5 bg-emerald-100 text-emerald-800 text-sm font-bold rounded-xl flex items-center border border-emerald-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Bu Bakım Tamamlandı
                </span>
            @endif
        </div>
    </div>

    @if (session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center">
            <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Vehicle & Customer Info -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex items-center">
                    <svg class="w-5 h-5 text-slate-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="font-bold text-slate-800">Araç Bilgisi</h3>
                </div>
                <div class="p-6 flex flex-col items-center">
                    <!-- TR Plate Design -->
                    <div
                        class="border-4 border-slate-800 rounded-lg overflow-hidden bg-white shadow-sm flex items-stretch h-16 w-full max-w-[240px] mb-6">
                        <div class="bg-blue-600 w-10 flex flex-col items-center justify-center text-white shrink-0">
                            <span class="text-[10px] font-bold leading-none mb-1">TR</span>
                        </div>
                        <div class="flex-1 flex items-center justify-center px-2 bg-white">
                            <span class="text-3xl font-black text-slate-800 tracking-wider">
                                {{ $maintenance->vehicle ? $maintenance->vehicle->plate : 'Plakasız' }}
                            </span>
                        </div>
                    </div>

                    <div class="w-full space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-slate-100">
                            <span class="text-slate-500 text-sm">Müşteri</span>
                            <span class="font-bold text-slate-800">{{ $maintenance->customer->name_surname }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-100">
                            <span class="text-slate-500 text-sm">Tarih</span>
                            <span
                                class="font-medium text-slate-800">{{ $maintenance->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Parts Checklist -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-amber-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                        </svg>
                        <h3 class="font-bold text-slate-800">Değişecek / Bakımı Yapılacak Parçalar</h3>
                    </div>
                    <span
                        class="text-sm rounded-full bg-slate-200 text-slate-700 px-3 py-1 font-medium">{{ $maintenance->parts->count() }}
                        Parça</span>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($maintenance->parts as $part)
                        <!-- Single Part Row -->
                        <div class="p-4 hover:bg-slate-50 transition-colors flex items-start sm:items-center gap-4"
                            x-data="partToggle({{ $part->id }}, {{ $part->is_completed ? 'true' : 'false' }}, '{{ $part->completedBy ? $part->completedBy->username : '' }}')">

                            <!-- Custom Checkbox -->
                            <button type="button" @click.prevent.stop="toggle"
                                :disabled="isToggling || '{{ $maintenance->status }}' === 'tamamlandi'"
                                class="w-8 h-8 rounded border-2 flex items-center justify-center shrink-0 transition-all shadow-sm group relative"
                                :class="completed ? 'bg-emerald-500 border-emerald-500 text-white' : 'bg-white border-slate-300 text-transparent hover:border-emerald-400'">
                                <svg class="w-5 h-5 transition-all duration-300"
                                    :class="completed ? 'scale-100 opacity-100 text-white' : 'scale-0 opacity-0 text-transparent'"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7">
                                    </path>
                                </svg>
                                <!-- Spinner -->
                                <svg x-show="isToggling" style="display: none;"
                                    class="animate-spin absolute inset-0 m-1 w-5 h-5 text-white" fill="none"
                                    viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                                    </circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </button>

                            <!-- Part Description -->
                            <div class="flex-1 min-w-0">
                                <h4 class="text-lg font-bold text-slate-800 transition-colors"
                                    :class="completed ? 'text-slate-400 line-through' : ''">
                                    {{ $part->name }} <span
                                        class="text-sm font-normal text-slate-500 no-underline ml-2">x{{ $part->quantity }}</span>
                                </h4>
                                @if($part->note)
                                    <p class="text-sm text-amber-700 bg-amber-50 mt-1.5 p-2 rounded border border-amber-100 inline-block"
                                        :class="completed ? 'opacity-50' : ''">
                                        <span class="font-bold">Not:</span> {{ $part->note }}
                                    </p>
                                @endif
                            </div>

                            <!-- Usta Information -->
                            <div class="text-right shrink-0 mt-2 sm:mt-0 flex flex-col items-end">
                                <template x-if="completed && ustaName">
                                    <div
                                        class="flex items-center text-emerald-700 bg-emerald-50 border border-emerald-100 px-3 py-1.5 rounded-lg text-sm font-medium animate-fade-in">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span x-text="ustaName"></span>
                                    </div>
                                </template>
                                <template x-if="!completed">
                                    <span class="text-slate-400 text-sm font-medium">Bekliyor</span>
                                </template>
                            </div>

                        </div>
                    @empty
                        <div class="p-8 text-center text-slate-500">
                            Bakım için tanımlanmış parça yok.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div x-data="{ 
                        open: false, 
                        actionText: '', 
                        onConfirm: null 
                     }" @open-confirm-modal.window="
                        open = true; 
                        actionText = $event.detail.actionText; 
                        onConfirm = $event.detail.onConfirm;
                     " x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">

        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div x-show="open" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative z-10 inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 flex flex-col items-center">
                    <div
                        class="mx-auto flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-full bg-amber-100 mb-4">
                        <svg class="h-8 w-8 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="text-xl leading-6 font-bold text-slate-900 text-center mb-2" id="modal-title">
                        İşlem Onayı
                    </h3>
                    <div class="mt-2 text-center">
                        <p class="text-sm text-slate-500">
                            Bu <strong x-text="actionText" class="text-slate-800"></strong> istediğinize emin misiniz?
                        </p>
                    </div>
                </div>
                <div
                    class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-2xl border-t border-slate-100">
                    <button @click="if(onConfirm) onConfirm(); open = false;" type="button"
                        class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-emerald-600 text-base font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                        Evet, Onaylıyorum
                    </button>
                    <button @click="open = false" type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                        İptal
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('partToggle', (partId, initialCompleted, initialUstaName) => ({
                    partId: partId,
                    completed: initialCompleted,
                    ustaName: initialUstaName,
                    isToggling: false,

                    async toggle() {
                        // Prevent toggle if maintenance is completed
                        if ('{{ $maintenance->status }}' === 'tamamlandi') return;

                        // Ask for confirmation via custom modal
                        const actionText = this.completed ? "parça montajını/bakımını iptal etmek" : "parçayı tamamlandı olarak işaretlemek";

                        window.dispatchEvent(new CustomEvent('open-confirm-modal', {
                            detail: {
                                actionText: actionText,
                                onConfirm: async () => {
                                    this.isToggling = true;
                                    try {
                                        let response = await fetch(`/admin/usta/parts/${this.partId}/toggle`, {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Accept': 'application/json'
                                            }
                                        });

                                        let data = await response.json();
                                        if (data.success) {
                                            this.completed = data.is_completed;
                                            this.ustaName = data.completed_by_name;
                                        }
                                    } catch (error) {
                                        console.error("Error toggling part", error);
                                        alert("Parça durumu güncellenirken bir hata oluştu.");
                                    } finally {
                                        this.isToggling = false;
                                    }
                                }
                            }
                        }));
                    }
                }));
            });
        </script>
        <style>
            .animate-fade-in {
                animation: fadeIn 0.3s ease-in-out;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(-4px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
    @endpush
@endsection