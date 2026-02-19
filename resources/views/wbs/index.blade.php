@extends('layouts.app')

@section('title', 'Dashboard WBS - RSUD Blambangan')

@section('content')
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50/50">
            <div>
                <h2 class="text-lg font-bold text-slate-900">Daftar Laporan Masuk</h2>
                <p class="text-xs text-slate-500 mt-1">
                    Monitoring laporan pengaduan Whistle Blowing System RSUD Blambangan
                </p>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right">
                    <p class="text-[10px] uppercase tracking-wider font-bold text-slate-400 leading-none">Total Laporan</p>
                    <p class="text-xl font-bold text-slate-900">{{ $reports->count() }}</p>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-slate-800">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase text-slate-500 font-bold">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Pelapor</th>
                        <th class="px-6 py-4">Jenis Pelanggaran</th>
                        <th class="px-6 py-4">Waktu & Lokasi</th>
                        <th class="px-6 py-4 text-center">Media</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($reports as $report)
                        @php
                            $nama_pelapor = empty(trim($report->nama_pelapor)) ? 'Anonim' : $report->nama_pelapor;
                            $tanggal = \Carbon\Carbon::parse($report->tanggal_kejadian);
                            $waktu_singkat = !empty($report->waktu_kejadian) ? substr($report->waktu_kejadian, 0, 5) : '';

                            $files = $report->files;
                            $count = $files->count();
                            $has_media = $count > 0;

                            // Fallback for old data
                            if (!$has_media && ($report->foto_bukti || $report->video_bukti)) {
                                $old_media = [];
                                if ($report->foto_bukti)
                                    $old_media[] = ['type' => 'image', 'path' => $report->foto_bukti];
                                if ($report->video_bukti)
                                    $old_media[] = ['type' => 'video', 'path' => $report->video_bukti];
                                $files = collect($old_media)->map(function ($item) {
                                    return (object) ['file_type' => $item['type'], 'file_path' => $item['path']];
                                });
                                $count = $files->count();
                                $has_media = $count > 0;
                            }
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4 align-top text-xs font-bold text-slate-400">
                                #{{ $report->id }}
                            </td>
                            <td class="px-6 py-4 align-top">
                                <div class="flex flex-col">
                                    <span
                                        class="font-bold {{ empty(trim($report->nama_pelapor)) ? 'text-emerald-600' : 'text-slate-900' }}">
                                        {{ $nama_pelapor }}
                                    </span>
                                    @if ($report->hubungan)
                                        <span class="text-[10px] text-slate-500 font-medium italic">
                                            {{ $report->hubungan }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 align-top">
                                <span
                                    class="text-xs font-bold text-blue-700 bg-blue-50 px-2 py-1 rounded-lg border border-blue-100 block w-fit">
                                    {{ $report->jenis_pelanggaran ?: '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 align-top text-xs">
                                <div class="font-bold text-slate-800">{{ $tanggal->translatedFormat('d M Y') }}</div>
                                <div class="text-[10px] text-slate-500 flex items-center gap-1 mt-0.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $waktu_singkat ?: '-' }} WIB
                                    <span class="mx-1">•</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $report->lokasi ?: '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 align-top text-center">
                                @if ($has_media)
                                    <button type="button"
                                        class="inline-flex items-center gap-1 rounded-lg bg-indigo-100 text-indigo-700 px-2 py-1 text-[10px] font-bold border border-indigo-200 hover:bg-indigo-200 transition-colors"
                                        onclick='openMedia(@json($files))'>
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $count }} FILE
                                    </button>
                                @else
                                    <span class="text-[10px] text-slate-300 font-bold">TIDAK ADA</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 align-top text-right">
                                <button type="button"
                                    class="inline-flex items-center gap-1 rounded-xl bg-slate-900 px-4 py-1.5 text-xs font-bold text-white hover:bg-slate-800 shadow-sm transition-all active:scale-95"
                                    onclick="openDetail(this)" data-id="{{ $report->id }}" data-nama="{{ $nama_pelapor }}"
                                    data-nama-raw="{{ $report->nama_pelapor }}" data-kontak="{{ $report->kontak_pelapor }}"
                                    data-hubungan="{{ $report->hubungan }}" data-jenis="{{ $report->jenis_pelanggaran }}"
                                    data-tanggal="{{ $tanggal->translatedFormat('l, d M Y') }}"
                                    data-tanggal-raw="{{ $report->tanggal_kejadian }}" data-waktu="{{ $waktu_singkat }}"
                                    data-lokasi="{{ $report->lokasi }}" data-terlapor="{{ $report->terlapor }}"
                                    data-saksi="{{ $report->saksi }}" data-bukti="{{ $report->bukti }}"
                                    data-deskripsi="{{ $report->deskripsi }}" data-dampak="{{ $report->dampak }}"
                                    data-harapan="{{ $report->harapan }}" data-media-count="{{ $count }}">
                                    DETAIL
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-3 opacity-20" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="font-bold">Belum ada laporan</p>
                                <p class="text-xs">Laporan pengaduan yang masuk akan muncul di sini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <p class="mt-4 text-[10px] text-slate-400 font-medium text-center italic">
        *Nama pelapor yang kosong otomatis ditampilkan sebagai <span class="text-emerald-500">Anonim</span> demi
        kerahasiaan.
    </p>

    <!-- MODAL MEDIA -->
    <div id="mediaModal"
        class="fixed inset-0 z-[60] hidden items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
        <div class="max-w-4xl w-full bg-slate-900 rounded-2xl shadow-2xl overflow-hidden border border-slate-700">
            <div class="px-6 py-4 border-b border-slate-700 flex items-center justify-between bg-slate-800">
                <h3 class="text-sm font-bold text-white uppercase tracking-widest" id="mediaTitle">Media Bukti <span
                        id="mediaCounter" class="text-slate-400 text-xs normal-case ml-2"></span></h3>
                <button type="button"
                    class="p-2 hover:bg-slate-700 rounded-xl transition-colors text-slate-400 hover:text-white"
                    onclick="closeMedia()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            <div class="p-6 relative">
                <div id="mediaContainer"
                    class="flex items-center justify-center h-[60vh] bg-black rounded-xl border border-slate-700 relative">
                    <!-- content via JS -->
                </div>

                <!-- Navigation -->
                <button id="prevMedia"
                    class="absolute left-8 top-1/2 -translate-y-1/2 p-3 bg-white/10 hover:bg-white/20 backdrop-blur-md rounded-full text-white transition-all disabled:opacity-30 disabled:cursor-not-allowed">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button id="nextMedia"
                    class="absolute right-8 top-1/2 -translate-y-1/2 p-3 bg-white/10 hover:bg-white/20 backdrop-blur-md rounded-full text-white transition-all disabled:opacity-30 disabled:cursor-not-allowed">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

            <!-- Thumbnails -->
            <div class="px-6 pb-6 overflow-x-auto">
                <div class="flex gap-2" id="mediaThumbnails">
                    <!-- thumbnails via JS -->
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DETAIL -->
    <div id="detailModal"
        class="fixed inset-0 z-[60] hidden items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
        <div class="max-w-3xl w-full bg-white rounded-2xl shadow-2xl overflow-hidden border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div>
                    <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest leading-none mb-1">Detail
                        Laporan</p>
                    <h3 class="text-base font-bold text-slate-900" id="detailIdTitle"></h3>
                </div>
                <button type="button" class="p-2 hover:bg-slate-200 rounded-xl transition-colors text-slate-500"
                    onclick="closeDetail()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            <div class="p-6 max-h-[70vh] overflow-y-auto space-y-6">
                <!-- Data Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <h4
                            class="text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 pb-1">
                            Data Pelapor</h4>
                        <div class="space-y-2">
                            <div>
                                <p class="text-[10px] font-bold text-slate-500 leading-none">Nama</p>
                                <p class="font-bold text-slate-900" id="detailNamaPelapor"></p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-500 leading-none">Kontak</p>
                                <p class="text-sm font-medium text-slate-700" id="detailKontakPelapor"></p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-500 leading-none">Hubungan</p>
                                <p class="text-sm font-medium text-slate-700" id="detailHubungan"></p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <h4
                            class="text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 pb-1">
                            Waktu & Lokasi</h4>
                        <div class="space-y-2">
                            <div>
                                <p class="text-[10px] font-bold text-slate-500 leading-none">Hari, Tanggal</p>
                                <p class="text-sm font-bold text-slate-900" id="detailTanggal"></p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-500 leading-none">Jam / Lokasi</p>
                                <p class="text-sm font-medium text-slate-700"><span id="detailWaktu"></span> • <span
                                        id="detailLokasi"></span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 pt-2">
                    <h4
                        class="text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 pb-1">
                        Kronologi & Bukti</h4>
                    <div class="space-y-3">
                        <div>
                            <p class="text-[10px] font-bold text-slate-500 mb-1">Deskripsi Kejadian</p>
                            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 text-sm text-slate-700 whitespace-pre-line"
                                id="detailDeskripsi"></div>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-500 mb-1">Terlapor & Saksi</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs font-medium">
                                <div class="bg-slate-50 rounded-lg p-3 border border-slate-100">
                                    <p class="text-[9px] font-bold text-slate-400 uppercase mb-1">Terlapor</p>
                                    <span id="detailTerlapor"></span>
                                </div>
                                <div class="bg-slate-50 rounded-lg p-3 border border-slate-100">
                                    <p class="text-[9px] font-bold text-slate-400 uppercase mb-1">Saksi</p>
                                    <span id="detailSaksi"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                    <div class="space-y-2">
                        <p class="text-[10px] font-bold text-slate-500">Dampak</p>
                        <div class="bg-slate-50 rounded-lg p-3 border border-slate-100 text-xs text-slate-600 italic"
                            id="detailDampak"></div>
                    </div>
                    <div class="space-y-2">
                        <p class="text-[10px] font-bold text-slate-500">Harapan Pelapor</p>
                        <div class="bg-slate-50 rounded-lg p-3 border border-slate-100 text-xs text-slate-600 italic"
                            id="detailHarapan"></div>
                    </div>
                </div>

                <div class="mt-4 p-4 bg-slate-50 border border-slate-100 rounded-xl">
                    <p class="text-[10px] font-bold text-slate-500 mb-1 uppercase tracking-widest">Media Bukti</p>
                    <p class="text-sm font-bold text-slate-900" id="detailMediaCount"></p>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between bg-slate-50/50">
                <p class="text-[10px] font-medium text-slate-400 italic leading-tight max-w-[60%]">*Data bersifat rahasia.
                    Dilarang menyebarkan informasi pelapor.</p>
                <button type="button" onclick="copyToWhatsApp()"
                    class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2 text-xs font-bold text-white hover:bg-emerald-700 transition-all active:scale-95 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.246 2.248 3.484 5.232 3.483 8.413-.003 6.557-5.338 11.892-11.893 11.892-1.997-.001-3.951-.5-5.688-1.448l-6.308 1.654zm6.236-3.323l.346.205c1.284.762 2.738 1.164 4.226 1.165 4.827 0 8.756-3.928 8.759-8.755.002-2.338-.91-4.536-2.565-6.194-1.655-1.658-3.853-2.571-6.191-2.572-4.827 0-8.755 3.928-8.758 8.756-.001 1.554.411 3.068 1.193 4.398l.225.385-.999 3.646 3.764-.988z" />
                    </svg>
                    SALIN KE WHATSAPP
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let currentFiles = [];
            let currentIndex = 0;

            function openMedia(files) {
                if (!files || files.length === 0) return;

                currentFiles = files;
                currentIndex = 0;

                const modal = document.getElementById('mediaModal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');

                renderMedia();
                renderThumbnails();
                updateNavigation();
            }

            function renderMedia() {
                const container = document.getElementById('mediaContainer');
                const file = currentFiles[currentIndex];
                const counter = document.getElementById('mediaCounter');

                counter.textContent = `(${currentIndex + 1}/${currentFiles.length})`;
                container.innerHTML = '';

                if (file.file_type === 'image') {
                    const img = document.createElement('img');
                    img.src = file.file_path;
                    img.className = 'max-h-full max-w-full object-contain';
                    container.appendChild(img);
                } else {
                    const video = document.createElement('video');
                    video.controls = true;
                    video.className = 'max-h-full max-w-full';
                    video.src = file.file_path;
                    container.appendChild(video);
                }
            }

            function renderThumbnails() {
                const container = document.getElementById('mediaThumbnails');
                container.innerHTML = '';

                currentFiles.forEach((file, index) => {
                    const btn = document.createElement('button');
                    btn.className = `h-16 w-16 shrink-0 rounded-lg overflow-hidden border-2 transition-all ${index === currentIndex ? 'border-blue-500 opacity-100' : 'border-transparent opacity-50 hover:opacity-100'}`;
                    btn.onclick = () => {
                        currentIndex = index;
                        renderMedia();
                        renderThumbnails();
                        updateNavigation();
                    }

                    if (file.file_type === 'image') {
                        const img = document.createElement('img');
                        img.src = file.file_path;
                        img.className = 'h-full w-full object-cover';
                        btn.appendChild(img);
                    } else {
                        btn.classList.add('bg-slate-800', 'flex', 'items-center', 'justify-center');
                        btn.innerHTML = `
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        `;
                    }

                    container.appendChild(btn);
                });
            }

            function updateNavigation() {
                document.getElementById('prevMedia').disabled = currentIndex === 0;
                document.getElementById('nextMedia').disabled = currentIndex === currentFiles.length - 1;
            }

            document.getElementById('prevMedia').onclick = () => {
                if (currentIndex > 0) {
                    currentIndex--;
                    renderMedia();
                    renderThumbnails();
                    updateNavigation();
                }
            }

            document.getElementById('nextMedia').onclick = () => {
                if (currentIndex < currentFiles.length - 1) {
                    currentIndex++;
                    renderMedia();
                    renderThumbnails();
                    updateNavigation();
                }
            }

            function closeMedia() {
                const modal = document.getElementById('mediaModal');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }

            function openDetail(button) {
                const d = button.dataset;
                const modal = document.getElementById('detailModal');

                document.getElementById('detailIdTitle').textContent = '#' + d.id + ' · ' + (d.jenis || 'Tanpa Jenis');
                document.getElementById('detailNamaPelapor').textContent = d.nama || 'Anonim';
                document.getElementById('detailKontakPelapor').textContent = d.kontak || '-';
                document.getElementById('detailHubungan').textContent = d.hubungan || '-';
                document.getElementById('detailTanggal').textContent = d.tanggal || '-';
                document.getElementById('detailWaktu').textContent = d.waktu ? d.waktu + ' WIB' : '-';
                document.getElementById('detailLokasi').textContent = d.lokasi || '-';
                document.getElementById('detailTerlapor').textContent = d.terlapor || '-';
                document.getElementById('detailSaksi').textContent = d.saksi || '-';
                document.getElementById('detailDeskripsi').textContent = d.deskripsi || '-';
                document.getElementById('detailDampak').textContent = d.dampak || '-';
                document.getElementById('detailHarapan').textContent = d.harapan || '-';
                document.getElementById('detailMediaCount').textContent = d.mediaCount > 0 ? d.mediaCount + ' File Lampiran' : 'Tidak ada lampiran';

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
                const dampak = document.getElementById('detailDampak').textContent.trim();
                const harapan = document.getElementById('detailHarapan').textContent.trim();
                const mediaCount = document.getElementById('detailMediaCount').textContent.trim();

                const text = `*LAPORAN WBS RSUD BLAMBANGAN*\n*${title}*\n\n*PELAPOR*\nNama: ${nama}\nKontak: ${kontak}\nHubungan: ${hubungan}\n\n*WAKTU & LOKASI*\nHari/Tgl: ${tanggal}\nJam: ${jam}\nLokasi: ${lokasi}\n\n*PIHAK TERLIBAT*\nTerlapor: ${terlapor}\nSaksi: ${saksi}\n\n*KRONOLOGI*\n${kronologi}\n\n*DAMPAK*\n${dampak}\n\n*HARAPAN*\n${harapan}\n\n*MEDIA BUKTI*\n${mediaCount}\n\n_Mohon segera ditindaklanjuti._`;

                const el = document.createElement('textarea');
                el.value = text;
                document.body.appendChild(el);
                el.select();
                document.execCommand('copy');
                document.body.removeChild(el);

                alert('Teks berhasil disalin ke clipboard!');
            }

            // Close on backdrop click
            window.onclick = function (event) {
                const mediaModal = document.getElementById('mediaModal');
                const detailModal = document.getElementById('detailModal');
                if (event.target == mediaModal) closeMedia();
                if (event.target == detailModal) closeDetail();
            }
        </script>
    @endpush
@endsection