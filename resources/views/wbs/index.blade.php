<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard WBS - RSUD Blambangan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-slate-100 text-slate-900">
    <div class="min-h-screen flex flex-col">
        <!-- HEADER -->
        <header class="border-b border-slate-200 bg-white/90 backdrop-blur shadow-sm">
            <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="https://rsudblambangan.id/images/navbar/Logo.png" alt="Logo RSUD Blambangan"
                        class="h-10 w-10 object-contain">
                    <div>
                        <h1 class="text-xl font-semibold text-slate-900">
                            Dashboard Whistle Blowing System
                        </h1>
                        <p class="text-xs text-slate-500">
                            RSUD Blambangan – Monitoring laporan pengaduan
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('wbs.create') }}"
                        class="inline-flex items-center rounded-xl bg-blue-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-blue-700 shadow">
                        + Form WBS
                    </a>
                </div>
            </div>
        </header>

        <!-- CONTENT -->
        <main class="flex-1">
            <div class="max-w-6xl mx-auto px-4 py-6">
                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-4 py-3 border-b border-slate-200 flex items-center justify-between bg-slate-50">
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900">Daftar Laporan</h2>
                            <p class="text-xs text-slate-500 mt-1">
                                Menampilkan seluruh laporan yang masuk dari Whistle Blowing System.
                            </p>
                        </div>
                        <div class="text-xs text-slate-500">
                            Total laporan:
                            <span class="font-semibold text-slate-900">
                                {{ $reports->count() }}
                            </span>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-slate-800">
                            <thead class="bg-slate-100 border-b border-slate-200 text-xs uppercase text-slate-500">
                                <tr>
                                    <th class="px-4 py-3">ID</th>
                                    <th class="px-4 py-3">Pelapor</th>
                                    <th class="px-4 py-3">Jenis Pelanggaran</th>
                                    <th class="px-4 py-3">Tanggal Kejadian</th>
                                    <th class="px-4 py-3">Lokasi</th>
                                    <th class="px-4 py-3">Media</th>
                                    <th class="px-4 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @if ($reports->isEmpty())
                                    <tr>
                                        <td colspan="7" class="px-4 py-6 text-center text-slate-500 text-sm">
                                            Belum ada laporan yang masuk.
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($reports as $report)
                                        @php
                                            $id = $report->id;
                                            $nama_pelapor_raw = $report->nama_pelapor;
                                            $nama_pelapor = empty(trim($nama_pelapor_raw))
                                                ? 'Anonim'
                                                : $nama_pelapor_raw;
                                            $kontak_pelapor = $report->kontak_pelapor ?? '';
                                            $hubungan = $report->hubungan ?? '';
                                            $jenis_pelanggaran = $report->jenis_pelanggaran ?? '-';
                                            $tanggal_kejadian = $report->tanggal_kejadian; // Date string or Carbon if casted
                                            // Ensure conversion to string if Carbon
                                            $tanggal_kejadian_str = \Carbon\Carbon::parse($tanggal_kejadian)->format(
                                                'Y-m-d',
                                            );

                                            $waktu_kejadian = $report->waktu_kejadian ?? '';
                                            $lokasi = $report->lokasi ?? '-';
                                            $terlapor = $report->terlapor ?? '';
                                            $saksi = $report->saksi ?? '';
                                            $bukti = $report->bukti ?? '';
                                            $deskripsi = $report->deskripsi ?? '';
                                            $dampak = $report->dampak ?? '';
                                            $harapan = $report->harapan ?? '';
                                            $foto_bukti = $report->foto_bukti;
                                            $video_bukti = $report->video_bukti;

                                            // format tanggal & hari
                                            $tgl_tampil = '-';
                                            $tgl_hari_tampil = '-';
                                            if (!empty($tanggal_kejadian)) {
                                                $ts = strtotime($tanggal_kejadian);
                                                if ($ts !== false) {
                                                    $hariIndo = [
                                                        'Minggu',
                                                        'Senin',
                                                        'Selasa',
                                                        'Rabu',
                                                        'Kamis',
                                                        'Jumat',
                                                        'Sabtu',
                                                    ];
                                                    $hari = $hariIndo[(int) date('w', $ts)];
                                                    $tgl_only = date('d/m/Y', $ts);
                                                    $tgl_tampil = $tgl_only; // tabel
                                                    $tgl_hari_tampil = $hari . ' ' . $tgl_only; // modal
                                                }
                                            }

                                            // URL media absolut (Assumed stored as full URL)
                                            $foto_full_url = $foto_bukti;
                                            $video_full_url = $video_bukti;

                                            $has_foto = !empty($foto_full_url);
                                            $has_video = !empty($video_full_url);

                                            // pilih salah satu untuk teks WA (utamakan video, lalu foto)
                                            $media_full_url_for_text = '';
                                            if ($video_full_url) {
                                                $media_full_url_for_text = $video_full_url;
                                            } elseif ($foto_full_url) {
                                                $media_full_url_for_text = $foto_full_url;
                                            }

                                            // jam pendek
                                            $waktu_singkat = '';
                                            if (!empty($waktu_kejadian)) {
                                                $waktu_singkat = substr($waktu_kejadian, 0, 5);
                                            }
                                        @endphp
                                        <tr class="hover:bg-slate-50">
                                            <td class="px-4 py-3 align-top text-xs text-slate-500">
                                                #{{ $id }}
                                            </td>
                                            <td class="px-4 py-3 align-top">
                                                <div class="flex flex-col">
                                                    <span
                                                        class="font-semibold {{ empty(trim($nama_pelapor_raw)) ? 'text-emerald-600' : 'text-slate-900' }}">
                                                        {{ $nama_pelapor }}
                                                    </span>
                                                    @if (!empty($hubungan))
                                                        <span class="text-[11px] text-slate-500">
                                                            {{ $hubungan }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 align-top">
                                                <div class="max-w-xs">
                                                    <span class="text-xs font-medium text-sky-700">
                                                        {{ $jenis_pelanggaran }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 align-top text-xs">
                                                <div class="flex flex-col">
                                                    <span class="text-slate-800">{{ $tgl_tampil }}</span>
                                                    @if (!empty($waktu_singkat))
                                                        <span class="text-[11px] text-slate-500">
                                                            {{ $waktu_singkat }} WIB
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 align-top text-xs">
                                                <span class="text-slate-800">{{ $lokasi }}</span>
                                            </td>
                                            <td class="px-4 py-3 align-top text-xs">
                                                @if ($has_foto)
                                                    <button type="button"
                                                        class="inline-flex items-center gap-1 rounded-lg bg-emerald-600 px-3 py-1.5 text-[11px] font-semibold text-white hover:bg-emerald-700"
                                                        onclick="openMedia('img', '{{ $foto_full_url }}')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                            fill="none" stroke="currentColor" class="h-3.5 w-3.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="1.5"
                                                                d="M4.5 5.25A2.25 2.25 0 016.75 3h10.5A2.25 2.25 0 0119.5 5.25v13.5a.75.75 0 01-1.2.6l-4.8-3.6-4.8 3.6a.75.75 0 01-1.2-.6V5.25z" />
                                                        </svg>
                                                        Lihat Foto
                                                    </button>
                                                @elseif ($has_video)
                                                    <button type="button"
                                                        class="inline-flex items-center gap-1 rounded-lg bg-indigo-600 px-3 py-1.5 text-[11px] font-semibold text-white hover:bg-indigo-700"
                                                        onclick="openMedia('video', '{{ $video_full_url }}')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                            fill="none" stroke="currentColor" class="h-3.5 w-3.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="1.5"
                                                                d="M5.25 5.25v13.5l13.5-6.75-13.5-6.75z" />
                                                        </svg>
                                                        Play Video
                                                    </button>
                                                @else
                                                    <span class="text-[11px] text-slate-400">Tidak ada media</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 align-top text-xs">
                                                <button type="button"
                                                    class="inline-flex items-center gap-1 rounded-lg border border-slate-300 px-3 py-1.5 text-[11px] font-semibold text-slate-700 hover:bg-slate-100"
                                                    onclick="openDetail(this)" data-id="{{ $id }}"
                                                    data-nama="{{ $nama_pelapor }}"
                                                    data-nama-raw="{{ $nama_pelapor_raw }}"
                                                    data-kontak="{{ $kontak_pelapor }}"
                                                    data-hubungan="{{ $hubungan }}"
                                                    data-jenis="{{ $jenis_pelanggaran }}"
                                                    data-tanggal="{{ $tgl_hari_tampil }}"
                                                    data-tanggal-raw="{{ $tanggal_kejadian_str }}"
                                                    data-waktu="{{ $waktu_singkat }}"
                                                    data-lokasi="{{ $lokasi }}"
                                                    data-terlapor="{{ $terlapor }}"
                                                    data-saksi="{{ $saksi }}" data-bukti="{{ $bukti }}"
                                                    data-deskripsi="{{ $deskripsi }}"
                                                    data-dampak="{{ $dampak }}"
                                                    data-harapan="{{ $harapan }}"
                                                    data-media="{{ $media_full_url_for_text }}">
                                                    Detail
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- KETERANGAN KECIL -->
                <p class="mt-4 text-[11px] text-slate-500">
                    Catatan: Nama pelapor yang kosong otomatis ditampilkan sebagai
                    <span class="font-semibold text-emerald-600">Anonim</span>.
                    Media hanya menampilkan salah satu: foto atau video (jika tersedia).
                </p>
            </div>
        </main>
    </div>

    <!-- MODAL MEDIA (FOTO / VIDEO) -->
    <div id="mediaModal" class="fixed inset-0 z-40 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="max-w-3xl w-full mx-4 bg-white border border-slate-200 rounded-2xl shadow-xl overflow-hidden">
            <div class="px-4 py-3 border-b border-slate-200 flex items-center justify-between bg-slate-50">
                <h3 class="text-sm font-semibold text-slate-900" id="mediaTitle">
                    Media Bukti
                </h3>
                <button type="button" class="rounded-full p-1.5 hover:bg-slate-100 text-slate-500"
                    onclick="closeMedia()">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-4 bg-white">
                <div id="mediaContainer" class="flex items-center justify-center max-h-[70vh] overflow-hidden">
                    <!-- isi media (img / video) lewat JS -->
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DETAIL LAPORAN -->
    <div id="detailModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="max-w-3xl w-full mx-4 bg-white border border-slate-200 rounded-2xl shadow-xl overflow-hidden">
            <div class="px-5 py-3 border-b border-slate-200 flex items-center justify-between bg-slate-50">
                <div>
                    <p class="text-[11px] uppercase tracking-wide text-slate-500 mb-1">
                        Detail Laporan WBS
                    </p>
                    <h3 class="text-sm font-semibold text-slate-900" id="detailIdTitle">
                        <!-- ID + Jenis pelanggaran -->
                    </h3>
                </div>
                <button type="button" class="rounded-full p-1.5 hover:bg-slate-100 text-slate-500"
                    onclick="closeDetail()">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="px-5 py-4 max-h-[75vh] overflow-y-auto space-y-5 text-sm bg-white">
                <!-- Data Pelapor -->
                <section class="space-y-2">
                    <h4 class="text-xs font-semibold text-slate-700 flex items-center gap-2">
                        <span
                            class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-slate-100 text-[11px] text-slate-600 border border-slate-200">1</span>
                        Data Pelapor
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <p class="text-[11px] uppercase tracking-wide text-slate-500">Nama Pelapor</p>
                            <p id="detailNamaPelapor" class="font-semibold text-slate-900"></p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[11px] uppercase tracking-wide text-slate-500">Kontak Pelapor</p>
                            <p id="detailKontakPelapor" class="text-slate-800"></p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[11px] uppercase tracking-wide text-slate-500">Hubungan dengan Organisasi
                            </p>
                            <p id="detailHubungan" class="text-slate-800"></p>
                        </div>
                    </div>
                </section>

                <!-- Waktu & Lokasi -->
                <section class="space-y-2">
                    <h4 class="text-xs font-semibold text-slate-700 flex items-center gap-2">
                        <span
                            class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-slate-100 text-[11px] text-slate-600 border border-slate-200">2</span>
                        Waktu & Lokasi Kejadian
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="space-y-1">
                            <p class="text-[11px] uppercase tracking-wide text-slate-500">Hari, Tanggal</p>
                            <p id="detailTanggal" class="text-slate-800"></p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[11px] uppercase tracking-wide text-slate-500">Jam</p>
                            <p id="detailWaktu" class="text-slate-800"></p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[11px] uppercase tracking-wide text-slate-500">Lokasi</p>
                            <p id="detailLokasi" class="text-slate-800"></p>
                        </div>
                    </div>
                </section>

                <!-- Pihak Terlibat -->
                <section class="space-y-2">
                    <h4 class="text-xs font-semibold text-slate-700 flex items-center gap-2">
                        <span
                            class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-slate-100 text-[11px] text-slate-600 border border-slate-200">3</span>
                        Pihak Terlibat
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <p class="text-[11px] uppercase tracking-wide text-slate-500">Nama / Jabatan Terlapor</p>
                            <p id="detailTerlapor" class="text-slate-800 whitespace-pre-line"></p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[11px] uppercase tracking-wide text-slate-500">Saksi</p>
                            <p id="detailSaksi" class="text-slate-800 whitespace-pre-line"></p>
                        </div>
                    </div>
                </section>

                <!-- Kronologi -->
                <section class="space-y-2">
                    <h4 class="text-xs font-semibold text-slate-700 flex items-center gap-2">
                        <span
                            class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-slate-100 text-[11px] text-slate-600 border border-slate-200">4</span>
                        Kronologi Kejadian
                    </h4>
                    <p id="detailDeskripsi"
                        class="text-slate-800 whitespace-pre-line bg-slate-50 border border-slate-200 rounded-xl px-4 py-3">
                    </p>
                </section>

                <!-- Bukti -->
                <section class="space-y-2">
                    <h4 class="text-xs font-semibold text-slate-700 flex items-center gap-2">
                        <span
                            class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-slate-100 text-[11px] text-slate-600 border border-slate-200">5</span>
                        Keterangan Bukti
                    </h4>
                    <p id="detailBukti"
                        class="text-slate-800 whitespace-pre-line bg-slate-50 border border-slate-200 rounded-xl px-4 py-3">
                    </p>
                </section>

                <!-- Media Bukti -->
                <section class="space-y-2">
                    <h4 class="text-xs font-semibold text-slate-700 flex items-center gap-2">
                        <span
                            class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-slate-100 text-[11px] text-slate-600 border border-slate-200">6</span>
                        Media Bukti
                    </h4>
                    <p id="detailMediaLink"
                        class="text-slate-800 break-all bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs">
                    </p>
                </section>

                <!-- Dampak & Harapan -->
                <section class="space-y-3">
                    <h4 class="text-xs font-semibold text-slate-700 flex items-center gap-2">
                        <span
                            class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-slate-100 text-[11px] text-slate-600 border border-slate-200">7</span>
                        Dampak & Harapan
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <p class="text-[11px] uppercase tracking-wide text-slate-500">Dampak Kejadian</p>
                            <p id="detailDampak"
                                class="text-slate-800 whitespace-pre-line bg-slate-50 border border-slate-200 rounded-xl px-4 py-3">
                            </p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[11px] uppercase tracking-wide text-slate-500">Harapan Pelapor</p>
                            <p id="detailHarapan"
                                class="text-slate-800 whitespace-pre-line bg-slate-50 border border-slate-200 rounded-xl px-4 py-3">
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Tombol copy ke WA -->
                <div class="pt-2 flex justify-end">
                    <button type="button" onclick="copyToWhatsApp()"
                        class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-xs font-semibold text-white hover:bg-emerald-700">
                        <span>Salin teks untuk WhatsApp</span>
                    </button>
                </div>
            </div>
            <div class="px-5 py-3 border-t border-slate-200 text-[11px] text-slate-500 bg-slate-50">
                Informasi pada modal ini bersifat rahasia dan hanya digunakan untuk kepentingan penanganan pengaduan.
            </div>
        </div>
    </div>

    <script>
        function openMedia(type, src) {
            const modal = document.getElementById('mediaModal');
            const container = document.getElementById('mediaContainer');
            const title = document.getElementById('mediaTitle');

            container.innerHTML = '';

            if (type === 'img') {
                title.textContent = 'Foto Bukti';
                const img = document.createElement('img');
                img.src = src;
                img.alt = 'Foto Bukti';
                img.className = 'max-h-[70vh] max-w-full rounded-xl shadow object-contain';
                container.appendChild(img);
            } else if (type === 'video') {
                title.textContent = 'Video Bukti';
                const video = document.createElement('video');
                video.controls = true;
                video.className = 'max-h-[70vh] max-w-full rounded-xl shadow';
                video.src = src;
                container.appendChild(video);
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeMedia() {
            const modal = document.getElementById('mediaModal');
            const container = document.getElementById('mediaContainer');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            container.innerHTML = '';
        }

        function openDetail(button) {
            const d = button.dataset;
            const modal = document.getElementById('detailModal');

            const titleEl = document.getElementById('detailIdTitle');
            const jenis = d.jenis && d.jenis.trim() !== '' ? d.jenis : 'Jenis pelanggaran belum diisi';
            titleEl.textContent = '#' + d.id + ' · ' + jenis;

            document.getElementById('detailNamaPelapor').textContent = d.nama || 'Anonim';

            const kontakEl = document.getElementById('detailKontakPelapor');
            kontakEl.textContent = d.kontak && d.kontak.trim() !== '' ?
                d.kontak :
                'Tidak dicantumkan';

            const hubunganEl = document.getElementById('detailHubungan');
            hubunganEl.textContent = d.hubungan && d.hubungan.trim() !== '' ?
                d.hubungan :
                'Tidak diisi';

            document.getElementById('detailTanggal').textContent =
                d.tanggal && d.tanggal.trim() !== '' ? d.tanggal : '-';

            const detailJamEl = document.getElementById('detailWaktu');
            if (d.waktu && d.waktu.trim() !== '' && d.waktu !== '00:00') {
                detailJamEl.textContent = d.waktu + ' WIB';
            } else {
                detailJamEl.textContent = '-';
            }

            document.getElementById('detailLokasi').textContent =
                d.lokasi && d.lokasi.trim() !== '' ? d.lokasi : 'Tidak diisi';

            document.getElementById('detailTerlapor').textContent =
                d.terlapor && d.terlapor.trim() !== '' ? d.terlapor : 'Tidak diisi';

            document.getElementById('detailSaksi').textContent =
                d.saksi && d.saksi.trim() !== '' ? d.saksi : 'Tidak disebutkan';

            document.getElementById('detailDeskripsi').textContent =
                d.deskripsi && d.deskripsi.trim() !== '' ? d.deskripsi : 'Belum ada kronologi.';

            document.getElementById('detailBukti').textContent =
                d.bukti && d.bukti.trim() !== '' ? d.bukti : 'Tidak ada keterangan tambahan.';

            document.getElementById('detailDampak').textContent =
                d.dampak && d.dampak.trim() !== '' ? d.dampak : 'Tidak dijelaskan.';

            document.getElementById('detailHarapan').textContent =
                d.harapan && d.harapan.trim() !== '' ? d.harapan : 'Tidak ada harapan khusus yang dituliskan.';

            const mediaEl = document.getElementById('detailMediaLink');
            mediaEl.textContent =
                d.media && d.media.trim() !== '' ? d.media : 'Tidak ada media';

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeDetail() {
            const modal = document.getElementById('detailModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function copyToWhatsApp() {
            const title = document.getElementById('detailIdTitle').textContent.trim();

            const nama = document.getElementById('detailNamaPelapor').textContent.trim();
            const kontak = document.getElementById('detailKontakPelapor').textContent.trim();
            const hubungan = document.getElementById('detailHubungan').textContent.trim();

            const tanggal = document.getElementById('detailTanggal').textContent.trim();
            const jam = document.getElementById('detailWaktu').textContent.trim();
            const lokasi = document.getElementById('detailLokasi').textContent.trim();

            const terlapor = document.getElementById('detailTerlapor').textContent.trim();
            const saksi = document.getElementById('detailSaksi').textContent.trim();

            const kronologi = document.getElementById('detailDeskripsi').textContent.trim();
            const bukti = document.getElementById('detailBukti').textContent.trim();
            const dampak = document.getElementById('detailDampak').textContent.trim();
            const harapan = document.getElementById('detailHarapan').textContent.trim();
            const mediaLink = document.getElementById('detailMediaLink').textContent.trim();

            const lines = [
                '*Laporan WBS RSBL*',
                '*' + title + '*',
                '',
                '*1. Data Pelapor*',
                'Pelapor : ' + nama,
                'Hubungan: ' + hubungan,
                'Kontak  : ' + kontak,
                '',
                '*2. Waktu & Lokasi Kejadian*',
                'Hari/Tgl: ' + tanggal,
                'Jam     : ' + jam,
                'Lokasi  : ' + lokasi,
                '',
                '*3. Pihak Terlibat*',
                'Terlapor: ' + terlapor,
                'Saksi   : ' + saksi,
                '',
                '*4. Kronologi Kejadian*',
                kronologi,
                '',
                '*5. Keterangan Bukti*',
                bukti,
                '',
                '*6. Dampak*',
                dampak,
                '',
                '*7. Harapan Pelapor*',
                harapan
            ];

            if (mediaLink && mediaLink !== 'Tidak ada media') {
                lines.push('', '*8. Media Bukti*', mediaLink);
            }

            lines.push('', '*Harap segera di tindak lanjuti ☝️*');

            const textToCopy = lines.join('\n');

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(textToCopy).then(function() {
                    alert('Teks laporan telah disalin. Silakan tempel di WhatsApp.');
                }).catch(function() {
                    fallbackCopy(textToCopy);
                });
            } else {
                fallbackCopy(textToCopy);
            }
        }

        function fallbackCopy(text) {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.style.position = 'fixed';
            textarea.style.left = '-9999px';
            document.body.appendChild(textarea);
            textarea.select();
            try {
                document.execCommand('copy');
                alert('Teks laporan telah disalin. Silakan tempel di WhatsApp.');
            } catch (err) {
                alert('Browser tidak mendukung fitur salin otomatis. Silakan salin manual.');
            }
            document.body.removeChild(textarea);
        }

        // tutup modal kalau klik di luar box
        document.addEventListener('click', function(e) {
            const mediaModal = document.getElementById('mediaModal');
            if (!mediaModal.classList.contains('hidden')) {
                const box = mediaModal.querySelector('div.max-w-3xl');
                if (box && !box.contains(e.target) && !e.target.closest('button[onclick^="openMedia"]')) {
                    closeMedia();
                }
            }

            const detailModal = document.getElementById('detailModal');
            if (!detailModal.classList.contains('hidden')) {
                const box2 = detailModal.querySelector('div.max-w-3xl');
                if (box2 && !box2.contains(e.target) && !e.target.closest('button[onclick^="openDetail"]')) {
                    closeDetail();
                }
            }
        });

        // ESC untuk tutup modal
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeMedia();
                closeDetail();
            }
        });
    </script>
</body>

</html>
