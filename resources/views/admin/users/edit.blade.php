@extends('layouts.admin')

@section('header', 'Kullanıcı Düzenle')

@section('content')
    <div class="mb-6 flex items-center">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 hover:text-blue-600 mr-4 transition-colors shadow-sm">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Geri Dön
        </a>
        <h1 class="text-2xl font-bold text-slate-800">Kullanıcıyı Düzenle: {{ $user->username }}</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden max-w-2xl">
        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            <!-- Username -->
            <div>
                <label for="username" class="block text-sm font-medium text-slate-700 mb-1">Kullanıcı Adı</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" required
                        class="pl-10 w-full px-4 py-3 rounded-lg border @error('username') border-red-300 focus:ring-red-500 focus:border-red-500 @else border-slate-300 focus:ring-blue-500 focus:border-blue-500 @enderror outline-none transition-all">
                </div>
                @error('username')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Şifre <span class="text-slate-400 font-normal">(Değiştirmek istemiyorsanız boş bırakın)</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <input type="password" name="password" id="password"
                        class="pl-10 w-full px-4 py-3 rounded-lg border @error('password') border-red-300 focus:ring-red-500 focus:border-red-500 @else border-slate-300 focus:ring-blue-500 focus:border-blue-500 @enderror outline-none transition-all"
                        placeholder="••••••••">
                </div>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role -->
            <div>
                <label for="role" class="block text-sm font-medium text-slate-700 mb-1">Kullanıcı Rolü</label>
                <select id="role" name="role" required class="w-full px-4 py-3 rounded-lg border @error('role') border-red-300 focus:ring-red-500 focus:border-red-500 @else border-slate-300 focus:ring-blue-500 focus:border-blue-500 @enderror outline-none transition-all bg-white appearance-none">
                    <option value="bayi" {{ old('role', $user->role) === 'bayi' ? 'selected' : '' }}>Bayi</option>
                    <option value="usta" {{ old('role', $user->role) === 'usta' ? 'selected' : '' }}>Usta</option>
                </select>
                @error('role')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 flex items-center justify-end space-x-3 border-t border-slate-100">
                <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 border border-slate-300 rounded-lg text-slate-700 bg-white hover:bg-slate-50 font-medium transition-colors">
                    İptal
                </a>
                <button type="submit" class="px-5 py-2.5 border border-transparent rounded-lg text-white bg-blue-600 hover:bg-blue-700 font-medium transition-colors shadow-sm">
                    Değişiklikleri Kaydet
                </button>
            </div>
        </form>
    </div>
@endsection
