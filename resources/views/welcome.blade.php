@extends('layouts.app')

@section('title', 'Selamat Datang - WBS RSUD Blambangan')

@section('content')
<div class="flex flex-col items-center justify-center py-12">
    <div class="max-w-4xl w-full bg-white rounded-3xl shadow-xl overflow-hidden flex flex-col md:flex-row border border-slate-200">
        <div class="flex-1 p-8 md:p-12">
            <div class="mb-6">
                <span class="inline-block px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-bold uppercase tracking-widest rounded-full border border-blue-100 mb-4">Official Whistleblowing System</span>
                <h1 class="text-4xl font-extrabold text-slate-900 leading-tight mb-4">Bersama Menjaga <span class="text-blue-600 underline decoration-blue-200 underline-offset-8">Integritas</span> Kita.</h1>
                <p class="text-slate-500 leading-relaxed">Sistem pengaduan rahasia bagi karyawan dan masyarakat untuk melaporkan indikasi pelanggaran di lingkungan RSUD Blambangan Banyuwangi.</p>
            </div>

            <div class="space-y-6">
                <div class="flex items-start gap-4">
                    <div class="mt-1 h-10 w-10 shrink-0 flex items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-100 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900">Kerahasiaan Terjamin</h3>
                        <p class="text-sm text-slate-500">Identitas pelapor dilindungi sepenuhnya oleh sistem keamanan kami.</p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="mt-1 h-10 w-10 shrink-0 flex items-center justify-center rounded-2xl bg-blue-50 text-blue-600 border border-blue-100 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900">Proses Transparan</h3>
                        <p class="text-sm text-slate-500">Setiap laporan akan diverifikasi dan ditindaklanjuti secara profesional.</p>
                    </div>
                </div>
            </div>

            <div class="mt-10 flex flex-wrap gap-4">
                @auth
                    <a href="{{ route('wbs.index') }}" class="px-8 py-4 bg-slate-900 text-white rounded-2xl font-bold shadow-lg shadow-slate-200 hover:bg-slate-800 transition-all hover:translate-y-[-2px] active:translate-y-0">
                        Ke Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-8 py-4 bg-blue-600 text-white rounded-2xl font-bold shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all hover:translate-y-[-2px] active:translate-y-0">
                        Login Admin
                    </a>
                    <a href="https://rsudblambangan.id" target="_blank" class="px-8 py-4 bg-white text-slate-600 border border-slate-200 rounded-2xl font-bold hover:bg-slate-50 transition-all">
                        Web RSUD
                    </a>
                @endauth
            </div>
        </div>
        <div class="flex-1 bg-slate-50 border-l border-slate-100 p-8 flex items-center justify-center relative overflow-hidden">
            <div class="absolute inset-0 opacity-[0.03] pointer-events-none">
                <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                            <path d="M 40 0 L 0 0 0 40" fill="none" stroke="currentColor" stroke-width="1"/>
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#grid)" />
                </svg>
            </div>
            <div class="relative z-10 text-center">
                <img src="https://rsudblambangan.id/images/navbar/Logo.png" alt="Logo RSUD Blambangan" class="h-48 w-auto mx-auto drop-shadow-2xl animate-pulse">
                <div class="mt-6">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-[0.2em]">RSUD Blambangan</p>
                    <p class="text-sm font-medium text-slate-500 italic">"Layanan bermutu, Anda senang, Kami bahagia"</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
