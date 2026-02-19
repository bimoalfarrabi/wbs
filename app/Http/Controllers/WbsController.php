<?php

namespace App\Http\Controllers;

use App\Models\WbsReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            'bukti_files.*' => 'nullable|file|max:51200', // Max 50MB per file
        ]);

        $report = WbsReport::create([
            'nama_pelapor' => $validated['nama_pelapor'] ?? null,
            'kontak_pelapor' => $validated['kontak_pelapor'] ?? null,
            'hubungan' => $validated['hubungan'] ?? null,
            'jenis_pelanggaran' => $validated['jenis_pelanggaran'],
            'deskripsi' => $validated['deskripsi'],
            'tanggal_kejadian' => $validated['tanggal_kejadian'],
            'waktu_kejadian' => $validated['waktu_kejadian'] ?? null,
            'lokasi' => $validated['lokasi'],
            'terlapor' => $validated['terlapor'] ?? null,
            'saksi' => $validated['saksi'] ?? null,
            'bukti' => $validated['bukti'] ?? null,
            'dampak' => $validated['dampak'] ?? null,
            'harapan' => $validated['harapan'] ?? null,
        ]);

        \Log::info('WBS Submission Start', $validated);

        if ($request->hasFile('bukti_files')) {
            $files = $request->file('bukti_files');
            \Log::info('Files detected: ' . count($files));

            foreach ($files as $index => $file) {
                try {
                    $originalName = $file->getClientOriginalName();
                    $size = $file->getSize();
                    $mime = $file->getMimeType();
                    \Log::info("Processing file [$index]: $originalName ($size bytes, $mime)");

                    $ext = strtolower($file->getClientOriginalExtension());
                    $validImages = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                    $validVideos = ['mp4', 'mov', 'avi', 'mkv', 'wmv'];

                    $isImage = in_array($ext, $validImages);
                    $isVideo = in_array($ext, $validVideos);

                    if (!$isImage && !$isVideo) {
                        \Log::warning("Skipping invalid file type: $ext");
                        continue;
                    }

                    $prefix = $isImage ? 'foto_' : 'video_';
                    $filename = $prefix . date('YmdHis') . '_' . uniqid() . '.' . $ext;

                    // Ensure directory exists
                    if (!Storage::disk('public')->exists('wbs')) {
                        Storage::disk('public')->makeDirectory('wbs');
                    }

                    $path = $file->storeAs('wbs', $filename, 'public');
                    \Log::info("File stored at: $path");

                    $fullUrl = asset('storage/' . $path);

                    $report->files()->create([
                        'file_path' => $fullUrl,
                        'file_type' => $isImage ? 'image' : 'video',
                    ]);

                    \Log::info("Database record created for file: $filename");

                } catch (\Exception $e) {
                    \Log::error('File upload failed', [
                        'file' => $originalName ?? 'unknown',
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            }
        } else {
            \Log::info('No files found in request.');
        }

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
