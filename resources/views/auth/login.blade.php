@extends('layouts.guest')

@section('title', 'Login - WBS RSUD Blambangan')

@section('content')
<div class="bg-blue-600 p-6 text-center">
    <h2 class="text-xl font-bold text-white">Login Admin</h2>
    <p class="text-blue-100 text-sm mt-1">Silakan masuk untuk mengelola laporan</p>
</div>

<div class="p-8">
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700">Email Address</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2 border transition-all">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
            <input type="password" id="password" name="password" required
                class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2 border transition-all">
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded">
                <label for="remember_me" class="ml-2 block text-sm text-slate-600">Ingat saya</label>
            </div>
        </div>

        <div>
            <button type="submit"
                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all active:scale-[0.98]">
                Masuk ke Sistem
            </button>
        </div>
    </form>
</div>
@endsection
