@extends('layouts.admin')

@section('header', 'Sistem Kayıtları / Denetim İzleri')

@section('content')
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ url()->previous() !== url()->current() ? url()->previous() : url('/admin') }}"
            class="inline-flex items-center justify-center w-10 h-10 bg-white border border-slate-200 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-slate-50 transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Sistem Logları</h1>
            <p class="text-slate-500 mt-0.5 text-sm">Sistem üzerinde yapılan ekleme, düzenleme ve silme işlemlerinin detaylı
                izleri.</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tarih</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kullanıcı</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">İşlem Model</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">İşlem Türü</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Değişiklikler
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($audits as $audit)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                {{ $audit->created_at->format('d.m.Y H:i:s') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($audit->user)
                                    <div class="flex items-center">
                                        <div
                                            class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs mr-3">
                                            {{ substr($audit->user->name, 0, 2) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-medium text-slate-800">{{ $audit->user->name }}</span>
                                            <span
                                                class="text-[10px] text-slate-400 font-mono mt-0.5">{{ $audit->ip_address ?? 'Bilinmiyor' }}</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex flex-col">
                                        <span class="text-slate-400 italic">Sistem / Misafir</span>
                                        <span
                                            class="text-[10px] text-slate-400 font-mono mt-0.5">{{ $audit->ip_address ?? 'Bilinmiyor' }}</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                @php
                                    $className = class_basename($audit->auditable_type);
                                    $translatedNames = [
                                        'Customer' => 'Müşteri',
                                        'Vehicle' => 'Araç',
                                        'Maintenance' => 'Servis/Bakım',
                                        'CustomerTransaction' => 'Cari İşlem',
                                        'User' => 'Sistem Kullanıcısı'
                                    ];
                                    $displayName = $translatedNames[$className] ?? $className;
                                @endphp
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800">
                                    {{ $displayName }} (ID: {{ $audit->auditable_id }})
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $eventBadgeClasses = [
                                        'created' => 'bg-emerald-100 text-emerald-800',
                                        'updated' => 'bg-blue-100 text-blue-800',
                                        'deleted' => 'bg-red-100 text-red-800',
                                        'restored' => 'bg-amber-100 text-amber-800',
                                    ];
                                    $eventClass = $eventBadgeClasses[$audit->event] ?? 'bg-slate-100 text-slate-800';

                                    $eventTranslated = [
                                        'created' => 'Oluşturuldu',
                                        'updated' => 'Güncellendi',
                                        'deleted' => 'Silindi',
                                        'restored' => 'Geri Alındı'
                                    ];
                                    $eventName = $eventTranslated[$audit->event] ?? ucfirst($audit->event);
                                @endphp
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-bold {{ $eventClass }}">
                                    {{ $eventName }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-2 max-w-sm">
                                    @if($audit->event === 'created')
                                        <div class="text-xs text-slate-500 italic">Yeni kayıt oluşturuldu.</div>
                                    @elseif($audit->event === 'updated')
                                        <div x-data="{ open: false }">
                                            <button @click="open = !open"
                                                class="text-xs text-blue-600 hover:text-blue-800 font-medium flex items-center">
                                                <span x-text="open ? 'Detayları Gizle' : 'Değişiklikleri Gör'"></span>
                                                <svg class="w-4 h-4 ml-1 transition-transform" :class="{'rotate-180': open}"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </button>
                                            <div x-show="open" x-collapse
                                                class="mt-2 bg-slate-50 rounded border border-slate-200 p-2 text-xs">
                                                <div
                                                    class="grid grid-cols-2 gap-2 text-center text-slate-500 font-semibold mb-1 border-b border-slate-200 pb-1">
                                                    <div>Eski Değer</div>
                                                    <div>Yeni Değer</div>
                                                </div>
                                                <div class="space-y-1">
                                                    @foreach($audit->getModified() as $attribute => $values)
                                                        <div
                                                            class="border-t border-slate-100 pt-1 mt-1 first:border-0 first:pt-0 first:mt-0">
                                                            <div class="font-medium text-slate-700 mb-1 flex justify-center"><code
                                                                    class="px-1.5 py-0.5 bg-slate-200 rounded text-[10px]">{{ $attribute }}</code>
                                                            </div>
                                                            <div class="grid grid-cols-2 gap-2">
                                                                <div
                                                                    class="bg-red-50 text-red-700 p-1.5 rounded break-all shadow-inner">
                                                                    {{ is_array($values['old'] ?? null) ? json_encode($values['old']) : ($values['old'] ?? 'Yok') }}
                                                                </div>
                                                                <div
                                                                    class="bg-emerald-50 text-emerald-700 p-1.5 rounded break-all shadow-inner">
                                                                    {{ is_array($values['new'] ?? null) ? json_encode($values['new']) : ($values['new'] ?? 'Yok') }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($audit->event === 'deleted')
                                        <div class="text-xs text-slate-500 italic">Kayıt silindi.</div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-500">
                                    <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <p class="text-base font-medium text-slate-600">Henüz hiç log kaydı bulunmamaktadır.</p>
                                    <p class="text-sm">Sistemde işlem yapıldıkça değişiklikler burada listelenecektir.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($audits->hasPages())
            <div class="p-4 border-t border-slate-200 bg-slate-50">
                {{ $audits->links() }}
            </div>
        @endif
    </div>
@endsection