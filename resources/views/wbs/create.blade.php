@extends('layouts.guest')

@section('title', 'Kirim Laporan WBS - RSUD Blambangan')

@section('content')
@if (session('success'))
    <div class="p-8">
        <div class="flex items-center gap-4 mb-6">
            <div class="h-12 w-12 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-900">Laporan Berhasil Terkirim</h2>
                <p class="text-sm text-slate-500 font-medium">Terima kasih atas partisipasi Anda.</p>
            </div>
        </div>
        
        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 mb-8">
            <p class="text-slate-700 text-sm leading-relaxed">
                Laporan Anda telah kami terima dan masuk ke dalam sistem antrean verifikasi. Tim Whistleblowing System RSUD Blambangan akan menindaklanjuti laporan ini sesuai dengan prosedur yang berlaku secara rahasia dan profesional.
            </p>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('wbs.create') }}" class="flex-1 inline-flex items-center justify-center px-5 py-3 rounded-xl bg-blue-600 text-white text-sm font-bold shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all">
                Buat Laporan Lain
            </a>
            <a href="{{ url('/') }}" class="flex-1 inline-flex items-center justify-center px-5 py-3 rounded-xl border border-slate-200 bg-white text-slate-600 text-sm font-bold hover:bg-slate-50 transition-all">
                Selesai
            </a>
        </div>
    </div>
@elseif (!request()->has('confirm') || request('confirm') != '1')
    <div class="p-8">
        <div class="flex items-center gap-4 mb-6">
            <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-900">Konfirmasi Pelaporan</h2>
                <p class="text-sm text-slate-500 font-medium">Whistleblowing System (WBS)</p>
            </div>
        </div>

        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 mb-8">
            <p class="text-slate-700 text-sm leading-relaxed mb-4">
                Apakah Anda yakin ingin membuat laporan pada Whistleblowing System (WBS) RSUD Blambangan?
            </p>
            <p class="text-xs text-slate-500 italic">
                *Laporan akan diverifikasi secara mendalam. Mohon berikan informasi yang akurat dan dapat dipertanggungjawabkan.
            </p>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('wbs.create', ['confirm' => 1]) }}" class="flex-1 inline-flex items-center justify-center px-5 py-3 rounded-xl bg-blue-600 text-white text-sm font-bold shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all">
                Ya, Lanjutkan
            </a>
            <a href="{{ url('/') }}" class="flex-1 inline-flex items-center justify-center px-5 py-3 rounded-xl border border-slate-200 bg-white text-slate-600 text-sm font-bold hover:bg-slate-50 transition-all">
                Batal
            </a>
        </div>
    </div>
@else
    <div class="bg-blue-600 p-6 flex items-center justify-between">
        <div>
            <h2 class="text-lg font-bold text-white">Form Pengaduan WBS</h2>
            <p class="text-xs text-blue-100">RSUD Blambangan Banyuwangi</p>
        </div>
        <img src="https://rsudblambangan.id/images/navbar/Logo.png" alt="Logo RSUD" class="h-10 w-auto brightness-200 grayscale contrast-200">
    </div>

    <div class="p-8">
        <form method="post" action="{{ route('wbs.store') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf
            
            <!-- 1. Data Pelapor -->
            <div class="space-y-4">
                <div class="flex items-center gap-2 border-b border-slate-100 pb-1">
                    <span class="text-[10px] font-bold text-white bg-slate-900 h-5 w-5 rounded-full flex items-center justify-center">1</span>
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-widest">Identitas Pelapor</h3>
                    <span class="text-[10px] text-slate-400 font-medium ml-auto uppercase italic">(Opsional)</span>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="nama_pelapor" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Nama Pelapor</label>
                        <input type="text" id="nama_pelapor" name="nama_pelapor" value="{{ old('nama_pelapor') }}" placeholder="Tulis nama atau kosongkan"
                            class="block w-full rounded-xl border-slate-200 bg-white px-4 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all">
                    </div>
                    <div>
                        <label for="kontak_pelapor" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Kontak (HP/Email)</label>
                        <input type="text" id="kontak_pelapor" name="kontak_pelapor" value="{{ old('kontak_pelapor') }}" placeholder="Untuk info lebih lanjut"
                            class="block w-full rounded-xl border-slate-200 bg-white px-4 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all">
                    </div>
                </div>
                
                <div>
                    <label for="hubungan" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Hubungan dengan RSUD</label>
                    <select id="hubungan" name="hubungan" class="block w-full rounded-xl border-slate-200 bg-white px-4 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all">
                        <option value="">-- Pilih Hubungan --</option>
                        @foreach (['Karyawan', 'Pasien / Keluarga Pasien', 'Vendor / Rekanan', 'Tamu / Pengunjung', 'Lainnya'] as $opt)
                            <option value="{{ $opt }}" {{ old('hubungan') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- 2. Jenis Pelanggaran -->
            <div class="space-y-4">
                <div class="flex items-center gap-2 border-b border-slate-100 pb-1">
                    <span class="text-[10px] font-bold text-white bg-slate-900 h-5 w-5 rounded-full flex items-center justify-center">2</span>
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-widest">Jenis Pelanggaran</h3>
                    <span class="text-[10px] text-red-500 font-bold ml-auto uppercase italic">Wajib *</span>
                </div>
                
                <select id="jenis_pelanggaran" name="jenis_pelanggaran" required
                    class="block w-full rounded-xl border-slate-200 bg-white px-4 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all @error('jenis_pelanggaran') border-red-500 @enderror">
                    <option value="">-- Pilih Kategori Pelanggaran --</option>
                    @foreach (['Korupsi / Suap / Gratifikasi', 'Penyalahgunaan Wewenang', 'Kecurangan (Fraud)', 'Manipulasi Dokumen / Data', 'Pelanggaran Etika / Kode Etik', 'Pelecehan / Kekerasan / Perundungan', 'Konflik Kepentingan', 'Pelanggaran SOP / Keselamatan', 'Lainnya'] as $opt)
                        <option value="{{ $opt }}" {{ old('jenis_pelanggaran') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                    @endforeach
                </select>
            </div>

            <!-- 3. Kronologi -->
            <div class="space-y-4">
                <div class="flex items-center gap-2 border-b border-slate-100 pb-1">
                    <span class="text-[10px] font-bold text-white bg-slate-900 h-5 w-5 rounded-full flex items-center justify-center">3</span>
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-widest">Kronologi Kejadian</h3>
                    <span class="text-[10px] text-red-500 font-bold ml-auto uppercase italic">Wajib *</span>
                </div>
                
                <textarea id="deskripsi" name="deskripsi" required placeholder="Jelaskan secara detail kejadian yang Anda temukan..."
                    class="block w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all min-h-[150px] @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi') }}</textarea>
            </div>

            <!-- 4. Waktu & Lokasi -->
            <div class="space-y-4">
                <div class="flex items-center gap-2 border-b border-slate-100 pb-1">
                    <span class="text-[10px] font-bold text-white bg-slate-900 h-5 w-5 rounded-full flex items-center justify-center">4</span>
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-widest">Waktu & Lokasi</h3>
                    <span class="text-[10px] text-red-500 font-bold ml-auto uppercase italic">Wajib *</span>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="tanggal_kejadian" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Tanggal Kejadian</label>
                        <input type="date" id="tanggal_kejadian" name="tanggal_kejadian" value="{{ old('tanggal_kejadian') }}" max="{{ date('Y-m-d') }}" required
                            class="block w-full rounded-xl border-slate-200 bg-white px-4 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all @error('tanggal_kejadian') border-red-500 @enderror">
                    </div>
                    <div>
                        <label for="waktu_kejadian" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Jam (Perkiraan)</label>
                        <input type="time" id="waktu_kejadian" name="waktu_kejadian" value="{{ old('waktu_kejadian') }}"
                            class="block w-full rounded-xl border-slate-200 bg-white px-4 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all">
                    </div>
                </div>
                <div>
                    <label for="lokasi" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Lokasi Unit / Ruangan</label>
                    <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi') }}" required placeholder="Contoh: Unit Gawat Darurat, Farmasi, dsb"
                        class="block w-full rounded-xl border-slate-200 bg-white px-4 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all @error('lokasi') border-red-500 @enderror">
                </div>
            </div>

            <!-- 5. Terlapor & Saksi -->
            <div class="space-y-4">
                <div class="flex items-center gap-2 border-b border-slate-100 pb-1">
                    <span class="text-[10px] font-bold text-white bg-slate-900 h-5 w-5 rounded-full flex items-center justify-center">5</span>
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-widest">Pihak Terkait</h3>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="terlapor" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Nama/Jabatan Terlapor</label>
                        <input type="text" id="terlapor" name="terlapor" value="{{ old('terlapor') }}" placeholder="Siapa yang dilaporkan?"
                            class="block w-full rounded-xl border-slate-200 bg-white px-4 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all">
                    </div>
                    <div>
                        <label for="saksi" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Saksi (Jika ada)</label>
                        <input type="text" id="saksi" name="saksi" value="{{ old('saksi') }}" placeholder="Siapa yang melihat?"
                            class="block w-full rounded-xl border-slate-200 bg-white px-4 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all">
                    </div>
                </div>
            </div>

            <!-- 6. Bukti File -->
            <div class="space-y-4">
                <div class="flex items-center gap-2 border-b border-slate-100 pb-1">
                    <span class="text-[10px] font-bold text-white bg-slate-900 h-5 w-5 rounded-full flex items-center justify-center">6</span>
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-widest">Bukti Pendukung</h3>
                </div>
                
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Upload Foto atau Video Bukti</label>
                    <div class="flex items-center justify-center w-full">
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-200 border-dashed rounded-2xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition-all">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p class="mb-1 text-xs text-slate-500 font-bold uppercase tracking-tight">Klik untuk pilih file</p>
                                <p class="text-[10px] text-slate-400">Video max 50MB, Gambar max 5MB</p>
                            </div>
                            <input type="file" id="bukti_file" name="bukti_file" accept="image/*,video/*" class="hidden" />
                        </label>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100">
                <label class="inline-flex items-start gap-3 cursor-pointer group">
                    <input type="checkbox" name="konfirmasi" value="1" required class="mt-1 h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500 transition-all">
                    <span class="text-xs text-slate-500 font-medium group-hover:text-slate-700 transition-colors">
                        Saya menjamin bahwa informasi yang saya sampaikan adalah benar dan dapat dipertanggungjawabkan sesuai ketentuan yang berlaku.
                    </span>
                </label>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-4 bg-blue-600 text-white rounded-2xl font-bold text-sm shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all hover:scale-[1.01] active:scale-[0.99]">
                    KIRIM LAPORAN SEKARANG
                </button>
            </div>
        </form>
    </div>
@endif
@endsection
