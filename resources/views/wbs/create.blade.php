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
                    Laporan Anda telah kami terima dan masuk ke dalam sistem antrean verifikasi. Tim Whistleblowing System RSUD
                    Blambangan akan menindaklanjuti laporan ini sesuai dengan prosedur yang berlaku secara rahasia dan
                    profesional.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('wbs.create') }}"
                    class="flex-1 inline-flex items-center justify-center px-5 py-3 rounded-xl bg-blue-600 text-white text-sm font-bold shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all">
                    Buat Laporan Lain
                </a>
                <a href="{{ url('/') }}"
                    class="flex-1 inline-flex items-center justify-center px-5 py-3 rounded-xl border border-slate-200 bg-white text-slate-600 text-sm font-bold hover:bg-slate-50 transition-all">
                    Selesai
                </a>
            </div>
        </div>
    @elseif (!request()->has('confirm') || request('confirm') != '1')
        <div class="p-8">
            <div class="flex items-center gap-4 mb-6">
                <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                    *Laporan akan diverifikasi secara mendalam. Mohon berikan informasi yang akurat dan dapat
                    dipertanggungjawabkan.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('wbs.create', ['confirm' => 1]) }}"
                    class="flex-1 inline-flex items-center justify-center px-5 py-3 rounded-xl bg-blue-600 text-white text-sm font-bold shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all">
                    Ya, Lanjutkan
                </a>
                <a href="{{ url('/') }}"
                    class="flex-1 inline-flex items-center justify-center px-5 py-3 rounded-xl border border-slate-200 bg-white text-slate-600 text-sm font-bold hover:bg-slate-50 transition-all">
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
            <img src="https://rsudblambangan.id/images/navbar/Logo.png" alt="Logo RSUD" class="h-10 w-auto">
        </div>

        <div class="p-8">
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 shrink-0 mt-0.5" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                    <div>
                        <p class="font-bold">Mohon perbaiki kesalahan berikut:</p>
                        <ul class="list-disc list-inside mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form method="post" action="{{ route('wbs.store') }}" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <!-- 1. Data Pelapor -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2 border-b border-slate-100 pb-1">
                        <span
                            class="text-[10px] font-bold text-white bg-slate-900 h-5 w-5 rounded-full flex items-center justify-center">1</span>
                        <h3 class="text-xs font-bold text-slate-900 uppercase tracking-widest">Identitas Pelapor</h3>
                        <span class="text-[10px] text-slate-400 font-medium ml-auto uppercase italic">(Opsional)</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="nama_pelapor"
                                class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Nama
                                Pelapor</label>
                            <input type="text" id="nama_pelapor" name="nama_pelapor" value="{{ old('nama_pelapor') }}"
                                placeholder="Tulis nama atau kosongkan"
                                class="block w-full rounded-xl border-slate-200 bg-white px-4 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all">
                        </div>
                        <div>
                            <label for="kontak_pelapor"
                                class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Kontak
                                (HP/Email)</label>
                            <input type="text" id="kontak_pelapor" name="kontak_pelapor" value="{{ old('kontak_pelapor') }}"
                                placeholder="Untuk info lebih lanjut"
                                class="block w-full rounded-xl border-slate-200 bg-white px-4 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all">
                        </div>
                    </div>

                    <div>
                        <label for="hubungan"
                            class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Hubungan dengan
                            RSUD</label>
                        <select id="hubungan" name="hubungan"
                            class="block w-full rounded-xl border-slate-200 bg-white px-4 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all">
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
                        <span
                            class="text-[10px] font-bold text-white bg-slate-900 h-5 w-5 rounded-full flex items-center justify-center">2</span>
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
                        <span
                            class="text-[10px] font-bold text-white bg-slate-900 h-5 w-5 rounded-full flex items-center justify-center">3</span>
                        <h3 class="text-xs font-bold text-slate-900 uppercase tracking-widest">Kronologi Kejadian</h3>
                        <span class="text-[10px] text-red-500 font-bold ml-auto uppercase italic">Wajib *</span>
                    </div>

                    <textarea id="deskripsi" name="deskripsi" required
                        placeholder="Jelaskan secara detail kejadian yang Anda temukan..."
                        class="block w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all min-h-[150px] @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi') }}</textarea>
                </div>

                <!-- 4. Waktu & Lokasi -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2 border-b border-slate-100 pb-1">
                        <span
                            class="text-[10px] font-bold text-white bg-slate-900 h-5 w-5 rounded-full flex items-center justify-center">4</span>
                        <h3 class="text-xs font-bold text-slate-900 uppercase tracking-widest">Waktu & Lokasi</h3>
                        <span class="text-[10px] text-red-500 font-bold ml-auto uppercase italic">Wajib *</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="tanggal_kejadian"
                                class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Tanggal
                                Kejadian</label>
                            <input type="date" id="tanggal_kejadian" name="tanggal_kejadian"
                                value="{{ old('tanggal_kejadian') }}" max="{{ date('Y-m-d') }}" required
                                class="block w-full rounded-xl border-slate-200 bg-white px-4 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all @error('tanggal_kejadian') border-red-500 @enderror">
                        </div>
                        <div>
                            <label for="waktu_kejadian"
                                class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Jam
                                (Perkiraan)</label>
                            <input type="time" id="waktu_kejadian" name="waktu_kejadian" value="{{ old('waktu_kejadian') }}"
                                class="block w-full rounded-xl border-slate-200 bg-white px-4 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all">
                        </div>
                    </div>
                    <div>
                        <label for="lokasi"
                            class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Lokasi Unit /
                            Ruangan</label>
                        <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi') }}" required
                            placeholder="Contoh: Unit Gawat Darurat, Farmasi, dsb"
                            class="block w-full rounded-xl border-slate-200 bg-white px-4 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all @error('lokasi') border-red-500 @enderror">
                    </div>
                </div>

                <!-- 5. Terlapor & Saksi -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2 border-b border-slate-100 pb-1">
                        <span
                            class="text-[10px] font-bold text-white bg-slate-900 h-5 w-5 rounded-full flex items-center justify-center">5</span>
                        <h3 class="text-xs font-bold text-slate-900 uppercase tracking-widest">Pihak Terkait</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="terlapor"
                                class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Nama/Jabatan
                                Terlapor</label>
                            <input type="text" id="terlapor" name="terlapor" value="{{ old('terlapor') }}"
                                placeholder="Siapa yang dilaporkan?"
                                class="block w-full rounded-xl border-slate-200 bg-white px-4 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all">
                        </div>
                        <div>
                            <label for="saksi"
                                class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Saksi (Jika
                                ada)</label>
                            <input type="text" id="saksi" name="saksi" value="{{ old('saksi') }}"
                                placeholder="Siapa yang melihat?"
                                class="block w-full rounded-xl border-slate-200 bg-white px-4 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all">
                        </div>
                    </div>
                </div>

                <!-- 6. Bukti File -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2 border-b border-slate-100 pb-1">
                        <span
                            class="text-[10px] font-bold text-white bg-slate-900 h-5 w-5 rounded-full flex items-center justify-center">6</span>
                        <h3 class="text-xs font-bold text-slate-900 uppercase tracking-widest">Bukti Pendukung</h3>
                    </div>

                    <div>
                        <label for="bukti"
                            class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Keterangan Bukti
                            (Teks)</label>
                        <textarea id="bukti" name="bukti" placeholder="Jelaskan bukti yang Anda miliki..."
                            class="block w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all min-h-[100px]">{{ old('bukti') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Upload Foto atau
                            Video Bukti (Bisa lebih dari satu)</label>
                        <div id="upload-container" class="flex items-center justify-center w-full">
                            <label
                                class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-200 border-dashed rounded-2xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition-all">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-3 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <p class="mb-1 text-xs text-slate-500 font-bold uppercase tracking-tight">Klik untuk pilih
                                        file</p>
                                    <p class="text-[10px] text-slate-400">Video max 50MB, Gambar max 5MB</p>
                                </div>
                                <input type="file" id="bukti_files" name="bukti_files[]" accept="image/*,video/*" multiple
                                    class="hidden" onchange="handleFiles(this)" />
                            </label>
                        </div>
                        @error('bukti_files')
                            <p class="mt-2 text-xs text-red-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                        @enderror
                        @error('bukti_files.*')
                            <p class="mt-2 text-xs text-red-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                        @enderror

                        <!-- PREVIEW CONTAINER -->
                        <div id="preview-list" class="grid grid-cols-1 gap-3 mt-4">
                            <!-- Preview items will be added here -->
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100">
                    <label class="inline-flex items-start gap-3 cursor-pointer group">
                        <input type="checkbox" name="konfirmasi" value="1" required
                            class="mt-1 h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500 transition-all">
                        <span class="text-xs text-slate-500 font-medium group-hover:text-slate-700 transition-colors">
                            Saya menjamin bahwa informasi yang saya sampaikan adalah benar dan dapat dipertanggungjawabkan
                            sesuai ketentuan yang berlaku.
                        </span>
                    </label>
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full py-4 bg-blue-600 text-white rounded-2xl font-bold text-sm shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all hover:scale-[1.01] active:scale-[0.99]">
                        KIRIM LAPORAN SEKARANG
                    </button>
                </div>
            </form>
        </div>

        <script>
            let dt = new DataTransfer();

            function handleFiles(input) {
                const files = input.files;

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    
                    // Check for duplicates
                    let isDuplicate = false;
                    for (let j = 0; j < dt.items.length; j++) {
                        if (dt.items[j].getAsFile().name === file.name) {
                            isDuplicate = true;
                            break;
                        }
                    }

                    if (isDuplicate) {
                        console.log('Skipping duplicate file:', file.name);
                        continue;
                    }

                    // Add to DataTransfer object
                    dt.items.add(file);

                    // Create preview element
                    createPreview(file, dt.items.length - 1);
                }

                // Update input files
                input.files = dt.files;
            }

            function createPreview(file, index) {
                const previewList = document.getElementById('preview-list');
                const div = document.createElement('div');
                div.className = 'flex items-center gap-4 bg-slate-50 border border-slate-200 rounded-2xl p-3 relative group';
                div.dataset.index = index; // Store index for reference if needed, though we rely on filename usually or simple remove

                let contentHtml = '';

                if (file.type.startsWith('image/')) {
                    const url = URL.createObjectURL(file);
                    contentHtml = `<img src="${url}" class="h-16 w-16 object-cover rounded-xl border border-slate-200">`;
                } else if (file.type.startsWith('video/')) {
                    contentHtml = `
                            <div class="h-16 w-16 rounded-xl overflow-hidden bg-indigo-600 shrink-0 border border-indigo-700 flex items-center justify-center">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </div>
                        `;
                } else {
                    contentHtml = `
                            <div class="h-16 w-16 rounded-xl overflow-hidden bg-slate-200 shrink-0 border border-slate-300 flex items-center justify-center">
                                <svg class="h-6 w-6 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                        `;
                }

                const size = (file.size / (1024 * 1024)).toFixed(2);

                div.innerHTML = `
                        ${contentHtml}
                        <div class="flex-grow overflow-hidden">
                            <p class="text-xs font-bold text-slate-900 truncate mb-0.5">${file.name}</p>
                            <p class="text-[10px] text-slate-500 font-medium">${size} MB</p>
                        </div>
                        <button type="button" onclick="removeFile('${file.name}', this)" class="p-2 text-slate-400 hover:text-red-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    `;

                previewList.appendChild(div);
            }

            function removeFile(fileName, btn) {
                // Create new DataTransfer
                const newDt = new DataTransfer();

                // Loop through existing files
                for (let i = 0; i < dt.files.length; i++) {
                    const file = dt.files[i];
                    if (file.name !== fileName) {
                        newDt.items.add(file);
                    }
                }

                // Update global dt and input
                dt = newDt;
                document.getElementById('bukti_files').files = dt.files;

                // Remove element
                btn.closest('.group').remove();
            }
        </script>
    @endif
@endsection