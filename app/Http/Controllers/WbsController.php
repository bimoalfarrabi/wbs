<?php

namespace App\Http\Controllers;

use App\Models\WbsReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class WbsController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('wbs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelapor' => 'nullable|string|max:255',
            'kontak_pelapor' => 'nullable|string|max:255',
            'hubungan' => 'nullable|string|max:255',
            'jenis_pelanggaran' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_kejadian' => 'required|date|before_or_equal:today',
            'waktu_kejadian' => 'nullable|date_format:H:i',
            'lokasi' => 'required|string|max:255',
            'terlapor' => 'nullable|string|max:255',
            'saksi' => 'nullable|string',
            'bukti' => 'nullable|string',
            'dampak' => 'nullable|string',
            'harapan' => 'nullable|string',
            'konfirmasi' => 'required|accepted',
            'bukti_file' => 'nullable|file|max:51200', // Max 50MB (video limit)
        ]);

        $foto_path = null;
        $video_path = null;

        if ($request->hasFile('bukti_file')) {
            $file = $request->file('bukti_file');
            $ext = strtolower($file->getClientOriginalExtension());
            $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
            $isVideo = in_array($ext, ['mp4', 'mov', 'avi', 'mkv', 'wmv']);

            if (!$isImage && !$isVideo) {
                throw ValidationException::withMessages(['bukti_file' => 'Format file tidak didukung.']);
            }

            if ($isVideo && $file->getSize() > 50 * 1024 * 1024) {
                throw ValidationException::withMessages(['bukti_file' => 'Ukuran video melebihi 50MB.']);
            }

            $prefix = $isImage ? 'foto_' : 'video_';
            $filename = $prefix . date('YmdHis') . '_' . uniqid() . '.' . $ext;

            // Upload to Nextcloud
            $nextcloudUrl = rtrim(env('NEXTCLOUD_URL'), '/') . '/' . rawurlencode($filename);

            try {
                $response = Http::withBasicAuth(env('NEXTCLOUD_USER'), env('NEXTCLOUD_PASSWORD'))
                    ->withBody(file_get_contents($file->getRealPath()), $file->getMimeType())
                    ->put($nextcloudUrl);

                if ($response->successful()) {
                    if ($isImage) {
                        $foto_path = $nextcloudUrl;
                    } else {
                        $video_path = $nextcloudUrl;
                    }
                } else {
                    \Log::error('Nextcloud upload failed', ['status' => $response->status(), 'body' => $response->body()]);
                    throw ValidationException::withMessages(['bukti_file' => 'Gagal mengunggah file ke server penyimpanan.']);
                }
            } catch (\Exception $e) {
                \Log::error('Nextcloud upload exception', ['message' => $e->getMessage()]);
                throw ValidationException::withMessages(['bukti_file' => 'Terjadi kesalahan saat mengunggah file.']);
            }
        }

        WbsReport::create([
            'nama_pelapor' => $validated['nama_pelapor'],
            'kontak_pelapor' => $validated['kontak_pelapor'],
            'hubungan' => $validated['hubungan'],
            'jenis_pelanggaran' => $validated['jenis_pelanggaran'],
            'deskripsi' => $validated['deskripsi'],
            'tanggal_kejadian' => $validated['tanggal_kejadian'],
            'waktu_kejadian' => $validated['waktu_kejadian'],
            'lokasi' => $validated['lokasi'],
            'terlapor' => $validated['terlapor'],
            'saksi' => $validated['saksi'],
            'bukti' => $validated['bukti'],
            'foto_bukti' => $foto_path,
            'video_bukti' => $video_path,
            'dampak' => $validated['dampak'],
            'harapan' => $validated['harapan'],
        ]);

        return redirect()->route('wbs.create')->with('success', true);
    }

    /**
     * Display the dashboard.
     */
    public function index()
    {
        $reports = WbsReport::orderBy('id', 'desc')->get();
        return view('wbs.index', compact('reports'));
    }
}
