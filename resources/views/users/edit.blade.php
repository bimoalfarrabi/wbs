@extends('layouts.app')

@section('title', 'Edit User - WBS RSUD Blambangan')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50/50">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Edit Akun Pengguna</h2>
                <p class="text-xs text-slate-500">Perbarui informasi profil administrator</p>
            </div>
            <a href="{{ route('users.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-700 uppercase tracking-tight">Kembali</a>
        </div>

        <div class="p-8">
            <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="name" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                            class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5 border transition-all">
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                            class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5 border transition-all">
                    </div>

                    <div>
                        <label for="role" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Role Akses</label>
                        <select name="role" id="role"
                            class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5 border transition-all bg-white">
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="superadmin" {{ old('role', $user->role) == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                        </select>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100">
                    <div class="mb-4">
                        <h3 class="text-sm font-bold text-slate-800">Ganti Password</h3>
                        <p class="text-[10px] text-slate-500 uppercase tracking-tight">Kosongkan jika tidak ingin mengganti password</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Password Baru</label>
                            <input type="password" name="password" id="password"
                                class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5 border transition-all">
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5 border transition-all">
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button type="submit"
                        class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-lg shadow-blue-100 transition-all active:scale-[0.98]">
                        Update Data User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
