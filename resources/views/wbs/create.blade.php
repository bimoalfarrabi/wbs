<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Whistle Blowing System - RSUD Blambangan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body
    class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 flex items-center justify-center p-4">
    <div class="w-full max-w-3xl">
        @if (session('success'))
            <!-- HALAMAN SUKSES SETELAH SUBMIT -->
            <div class="bg-white/90 backdrop-blur shadow-xl rounded-2xl p-8">
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-10 w-10 rounded-full bg-emerald-100 flex items-center justify-center">
                        <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900">
                            Laporan Berhasil Dikirim
                        </h1>
                        <p class="text-sm text-slate-600">
                            Terima kasih atas kontribusi Anda dalam menjaga integritas dan tata kelola yang baik.
                        </p>
                    </div>
                </div>
                <div class="mt-4 mb-6">
                    <p class="text-slate-700 text-base">
                        <span class="font-semibold">Terima kasih, laporan Anda telah berhasil disimpan di
                            sistem.</span><br>
                        Tim terkait akan menindaklanjuti laporan sesuai prosedur yang berlaku. Apabila Anda mencantumkan
                        kontak,
                        pihak berwenang dapat menghubungi Anda untuk klarifikasi lebih lanjut bila diperlukan.
                    </p>
                </div>
                <div class="flex flex-wrap gap-3 mt-6">
                    <a href="{{ route('wbs.create') }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-semibold shadow hover:bg-blue-700 transition">
                        Buat Laporan Baru
                    </a>
                    <a href="https://www.google.com"
                        class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl border border-slate-300 bg-white text-slate-700 text-sm font-semibold hover:bg-slate-50 transition">
                        Selesai
                    </a>
                </div>
            </div>
        @elseif (!request()->has('confirm') || request('confirm') != '1')
            <!-- HALAMAN KONFIRMASI AWAL -->
            <div class="bg-white/90 backdrop-blur shadow-xl rounded-2xl p-8">
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-10 w-10 rounded-full bg-red-100 flex items-center justify-center">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 9v4m0 4h.01M4.93 4.93l14.14 14.14M12 3a9 9 0 11-9 9 9 0 019-9z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900">
                            Konfirmasi Pelaporan WBS
                        </h1>
                        <p class="text-sm text-slate-600">
                            Whistle Blowing System digunakan untuk melaporkan pelanggaran secara bertanggung jawab.
                        </p>
                    </div>
                </div>
                <div class="mt-4 mb-6">
                    <p class="text-slate-700 text-base">
                        <span class="font-semibold">
                            Apakah Anda yakin akan membuat pelaporan pada Whistle Blowing System (WBS) RSUD Blambangan?
                        </span><br>
                        Laporan Anda akan direkam di sistem untuk ditindaklanjuti oleh pihak yang berwenang.
                    </p>
                </div>
                <div class="flex flex-wrap gap-3 mt-6">
                    <a href="{{ route('wbs.create', ['confirm' => 1]) }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-semibold shadow hover:bg-blue-700 transition">
                        Iya, saya yakin
                    </a>
                    <a href="https://www.google.com"
                        class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl border border-slate-300 bg-white text-slate-700 text-sm font-semibold hover:bg-slate-50 transition">
                        Tidak, batalkan
                    </a>
                </div>
                <p class="mt-6 text-xs text-slate-500">
                    Catatan: Penyalahgunaan WBS (laporan palsu yang disengaja) dapat dikenakan sanksi sesuai kebijakan
                    dan undang-undang yang berlaku.
                </p>
            </div>
        @else
            <!-- HALAMAN FORM WBS -->
            <div class="bg-white/95 backdrop-blur shadow-xl rounded-2xl p-6 sm:p-8">
                <div class="mb-6 flex items-center gap-4">
                    <!-- LOGO RSUD DI KIRI -->
                    <div class="shrink-0">
                        <img src="https://rsudblambangan.id/images/navbar/Logo.png" alt="Logo RSUD Blambangan"
                            class="h-14 w-14 object-contain">
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900">
                            Form Pengaduan Whistle Blowing System
                        </h1>
                        <p class="text-base font-semibold text-slate-800">
                            RSUD Blambangan
                        </p>
                        <p class="text-sm text-slate-600 mt-1">
                            Anda dapat mengisi identitas secara lengkap atau anonim. Data akan diperlakukan secara
                            rahasia.
                        </p>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 flex gap-2 items-start">
                        <span class="mt-0.5">
                            <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 9v3.75M12 15h.007M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                        <div class="text-sm text-red-800">
                            <p class="font-semibold mb-1">Terdapat beberapa kesalahan pengisian:</p>
                            <ul class="list-disc list-inside space-y-0.5">
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
                    <section class="space-y-3">
                        <div class="flex items-center gap-2">
                            <h2 class="text-lg font-semibold text-slate-900">1. Data Pelapor</h2>
                            <span class="text-xs text-slate-500">(boleh dikosongkan)</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="nama_pelapor" class="block text-sm font-medium text-slate-700">
                                    Nama Pelapor
                                    <span class="text-xs font-normal text-slate-400">(boleh dikosongkan)</span>
                                </label>
                                <input type="text" id="nama_pelapor" name="nama_pelapor"
                                    value="{{ old('nama_pelapor') }}" placeholder="Contoh: Budi, Anonim, dll."
                                    class="mt-1 block w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="kontak_pelapor" class="block text-sm font-medium text-slate-700">
                                    Kontak Pelapor
                                    <span class="text-xs font-normal text-slate-400">(email / no. HP, boleh
                                        dikosongkan)</span>
                                </label>
                                <input type="text" id="kontak_pelapor" name="kontak_pelapor"
                                    value="{{ old('kontak_pelapor') }}"
                                    placeholder="Contoh: 0812xxxx / email@contoh.com"
                                    class="mt-1 block w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>
                        <div>
                            <label for="hubungan" class="block text-sm font-medium text-slate-700">
                                Hubungan dengan organisasi
                            </label>
                            <select id="hubungan" name="hubungan"
                                class="mt-1 block w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">-- Pilih salah satu --</option>
                                @php
                                    $hubOptions = [
                                        'Karyawan',
                                        'Pasien / Keluarga Pasien',
                                        'Vendor / Rekanan',
                                        'Tamu / Pengunjung',
                                        'Lainnya',
                                    ];
                                @endphp
                                @foreach ($hubOptions as $opt)
                                    <option value="{{ $opt }}"
                                        {{ old('hubungan') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                @endforeach
                            </select>
                        </div>
                    </section>

                    <!-- 2. Jenis Pelanggaran -->
                    <section class="space-y-3">
                        <h2 class="text-lg font-semibold text-slate-900">2. Jenis Pelanggaran</h2>
                        <div>
                            <label for="jenis_pelanggaran"
                                class="block text-sm font-medium @error('jenis_pelanggaran') text-red-600 @else text-slate-700 @enderror">
                                Kategori Pelanggaran <span class="text-red-500">*</span>
                            </label>
                            <select id="jenis_pelanggaran" name="jenis_pelanggaran"
                                class="mt-1 block w-full rounded-xl border px-3 py-2 text-sm text-slate-900 shadow-sm
                                        @error('jenis_pelanggaran') border-red-500 bg-red-50 focus:border-red-500 focus:ring-red-500 @else border-slate-300 bg-white focus:border-blue-500 focus:ring-blue-500 @enderror">
                                <option value="">-- Pilih jenis pelanggaran --</option>
                                @php
                                    $opsi_pelanggaran = [
                                        'Korupsi / Suap / Gratifikasi',
                                        'Penyalahgunaan Wewenang',
                                        'Kecurangan (Fraud)',
                                        'Manipulasi Dokumen / Data',
                                        'Pelanggaran Etika / Kode Etik',
                                        'Pelecehan / Kekerasan / Perundungan',
                                        'Konflik Kepentingan',
                                        'Pelanggaran SOP / Keselamatan',
                                        'Lainnya',
                                    ];
                                @endphp
                                @foreach ($opsi_pelanggaran as $opt)
                                    <option value="{{ $opt }}"
                                        {{ old('jenis_pelanggaran') == $opt ? 'selected' : '' }}>{{ $opt }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </section>

                    <!-- 3. Deskripsi Kejadian -->
                    <section class="space-y-3">
                        <h2 class="text-lg font-semibold text-slate-900">3. Deskripsi Kejadian</h2>
                        <div>
                            <label for="deskripsi"
                                class="block text-sm font-medium @error('deskripsi') text-red-600 @else text-slate-700 @enderror">
                                Kronologi Kejadian <span class="text-red-500">*</span>
                            </label>
                            <textarea id="deskripsi" name="deskripsi"
                                placeholder="Jelaskan secara rinci: apa yang terjadi, siapa yang terlibat, bagaimana kejadiannya, dan mengapa dianggap pelanggaran."
                                class="mt-1 block w-full rounded-xl border px-3 py-2 text-sm text-slate-900 shadow-sm min-h-[120px]
                                            @error('deskripsi') border-red-500 bg-red-50 focus:border-red-500 focus:ring-red-500 @else border-slate-300 bg-white focus:border-blue-500 focus:ring-blue-500 @enderror">{{ old('deskripsi') }}</textarea>
                        </div>
                    </section>

                    <!-- 4. Waktu & Lokasi -->
                    <section class="space-y-3">
                        <h2 class="text-lg font-semibold text-slate-900">4. Waktu & Lokasi Kejadian</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="tanggal_kejadian"
                                    class="block text-sm font-medium @error('tanggal_kejadian') text-red-600 @else text-slate-700 @enderror">
                                    Tanggal Kejadian <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="tanggal_kejadian" name="tanggal_kejadian"
                                    value="{{ old('tanggal_kejadian') }}" max="{{ date('Y-m-d') }}"
                                    class="mt-1 block w-full rounded-xl border px-3 py-2 text-sm text-slate-900 shadow-sm
                                            @error('tanggal_kejadian') border-red-500 bg-red-50 focus:border-red-500 focus:ring-red-500 @else border-slate-300 bg-white focus:border-blue-500 focus:ring-blue-500 @enderror">
                            </div>
                            <div>
                                <label for="waktu_kejadian" class="block text-sm font-medium text-slate-700">
                                    Waktu Kejadian
                                </label>
                                <input type="time" id="waktu_kejadian" name="waktu_kejadian"
                                    value="{{ old('waktu_kejadian') }}"
                                    class="mt-1 block w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>
                        <div>
                            <label for="lokasi"
                                class="block text-sm font-medium @error('lokasi') text-red-600 @else text-slate-700 @enderror">
                                Lokasi Kejadian <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi') }}"
                                placeholder="Contoh: IGD, Ruang Rawat Inap, Gudang Farmasi"
                                class="mt-1 block w-full rounded-xl border px-3 py-2 text-sm text-slate-900 shadow-sm
                                        @error('lokasi') border-red-500 bg-red-50 focus:border-red-500 focus:ring-red-500 @else border-slate-300 bg-white focus:border-blue-500 focus:ring-blue-500 @enderror">
                        </div>
                    </section>

                    <!-- 5. Pihak Terlibat -->
                    <section class="space-y-3">
                        <h2 class="text-lg font-semibold text-slate-900">5. Pihak Terlibat</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="terlapor" class="block text-sm font-medium text-slate-700">
                                    Nama / Jabatan Terlapor
                                    <span class="text-xs font-normal text-slate-400">(jika diketahui)</span>
                                </label>
                                <input type="text" id="terlapor" name="terlapor" value="{{ old('terlapor') }}"
                                    placeholder="Contoh: A, Kepala Unit X"
                                    class="mt-1 block w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="saksi" class="block text-sm font-medium text-slate-700">
                                    Saksi
                                    <span class="text-xs font-normal text-slate-400">(jika ada)</span>
                                </label>
                                <textarea id="saksi" name="saksi" placeholder="Cantumkan nama/identitas saksi jika ada."
                                    class="mt-1 block w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 min-h-[80px]">{{ old('saksi') }}</textarea>
                            </div>
                        </div>
                    </section>

                    <!-- 6. Bukti Pendukung -->
                    <section class="space-y-3">
                        <h2 class="text-lg font-semibold text-slate-900">6. Bukti Pendukung</h2>
                        <div class="space-y-3">
                            <div>
                                <label for="bukti" class="block text-sm font-medium text-slate-700">
                                    Keterangan Bukti (teks)
                                </label>
                                <textarea id="bukti" name="bukti" placeholder="Jelaskan bukti yang dimiliki (misal: foto, video, dokumen)."
                                    class="mt-1 block w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 min-h-[80px]">{{ old('bukti') }}</textarea>
                            </div>

                            <div>
                                <label for="bukti_file" class="block text-sm font-medium text-slate-700">
                                    Upload Bukti (Foto atau Video)
                                </label>
                                <input type="file" id="bukti_file" name="bukti_file" accept="image/*,video/*"
                                    class="mt-1 block w-full text-sm text-slate-700 file:mr-3 file:rounded-lg file:border-0 file:bg-blue-600 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white hover:file:bg-blue-700">
                                <p class="mt-1 text-xs text-slate-500">
                                    Gambar: jpg, jpeg, png, gif, webp. Video: mp4, mov, avi, mkv, wmv. Maksimal video
                                    50MB.
                                </p>
                            </div>
                        </div>
                    </section>

                    <!-- 7. Dampak & Harapan -->
                    <section class="space-y-3">
                        <h2 class="text-lg font-semibold text-slate-900">7. Dampak & Harapan</h2>
                        <div>
                            <label for="dampak" class="block text-sm font-medium text-slate-700">
                                Dampak Kejadian
                            </label>
                            <textarea id="dampak" name="dampak"
                                placeholder="Contoh: merugikan pasien, kerugian finansial, merusak reputasi, mengganggu operasional, dll."
                                class="mt-1 block w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 min-h-[100px]">{{ old('dampak') }}</textarea>
                        </div>
                        <div>
                            <label for="harapan" class="block text-sm font-medium text-slate-700">
                                Harapan Pelapor
                                <span class="text-xs font-normal text-slate-400">(boleh dikosongkan)</span>
                            </label>
                            <textarea id="harapan" name="harapan"
                                placeholder="Contoh: dilakukan investigasi, perbaikan sistem, sanksi, klarifikasi, dll."
                                class="mt-1 block w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 min-h-[100px]">{{ old('harapan') }}</textarea>
                        </div>
                    </section>

                    <div class="pt-2 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <label for="konfirmasi"
                            class="inline-flex items-start gap-2 text-xs @error('konfirmasi') text-red-600 @else text-slate-600 @enderror">
                            <input type="checkbox" id="konfirmasi" name="konfirmasi" value="1"
                                class="mt-0.5 h-4 w-4 rounded border @error('konfirmasi') border-red-500 text-red-600 focus:ring-red-500 @else border-slate-300 text-blue-600 focus:ring-blue-500 @enderror"
                                {{ old('konfirmasi') ? 'checked' : '' }}>
                            <span>
                                Dengan mengirim laporan ini, Anda menyatakan bahwa informasi yang disampaikan adalah
                                benar sesuai pengetahuan Anda.
                            </span>
                        </label>
                        <button type="submit"
                            class="inline-flex items-center px-5 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-semibold shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
                            Kirim Laporan
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>

    @if ($errors->any() && !session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Basic auto-focus to first error if needed, though HTML5 required might handle some
                // Laravel errors are server side, so we can scroll to first error class
                const firstError = document.querySelector('.border-red-500');
                if (firstError) {
                    firstError.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    try {
                        firstError.focus();
                    } catch (e) {}
                }
            });
        </script>
    @endif
</body>

</html>
