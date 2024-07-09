<?php

namespace App\Http\Controllers;

use App\Models\Fungsi;
use App\Models\Kegiatan;
use Illuminate\Support\Str;
use App\Models\MataAnggaran;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kegiatan = Kegiatan::with(['petugasKegiatan', 'mataAnggaran', 'fungsi'])
            ->select('id', 'nama_kegiatan', 'slug', 'tanggal_mulai', 'tanggal_selesai', 'mata_anggaran_id', 'fungsi_id')
            ->withSum('petugasKegiatan', 'honor')
            ->orderBy('id', 'desc')
            ->paginate(6);

        return view('kegiatan.index', [
            'title'     => 'Kegiatan',
            'kegiatan'  => $kegiatan
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kegiatan.create', [
            'title'         => 'Tambah Kegiatan',
            'mataanggaran'  => MataAnggaran::all(),
            'fungsi'        => Fungsi::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_kegiatan'     => 'required|string|max:255',
            'tanggal_mulai'     => 'nullable|date',
            'tanggal_selesai'   => 'nullable|date',
            'mata_anggaran_id'  => 'required',
            'fungsi_id'         => 'required',
            'honor_nias'        => 'nullable|integer',
            'honor_nias_barat'  => 'nullable|integer',
        ]);

        $slug = Str::slug($request->nama_kegiatan);
        $count = Kegiatan::where('slug', 'LIKE', "{$slug}%")->count();
        if ($count > 0) {
            $slug = "{$slug}-{$count}";
        }

        Kegiatan::create([
            'nama_kegiatan'     => $validatedData['nama_kegiatan'],
            'slug'              => $slug,
            'tanggal_mulai'     => $validatedData['tanggal_mulai'],
            'tanggal_selesai'   => $validatedData['tanggal_selesai'],
            'mata_anggaran_id'  => $validatedData['mata_anggaran_id'],
            'fungsi_id'         => $validatedData['fungsi_id'],
            'honor_nias'        => $validatedData['honor_nias'] ?? 0,
            'honor_nias_barat'  => $validatedData['honor_nias_barat'] ?? 0,
        ]);

        return redirect('/kegiatan')->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kegiatan $kegiatan)
    {
        $petugasKegiatan = $kegiatan->petugasKegiatan()->orderBy('nama_mitra', 'asc')->paginate(8);

        return view('kegiatan.show', [
            'title'         => 'Kegiatan',
            'kegiatan'      => $kegiatan->nama_kegiatan,
            'kegiatan_id'   => $kegiatan->id,
            'petugas'       => $petugasKegiatan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kegiatan $kegiatan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kegiatan $kegiatan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kegiatan $kegiatan)
    {
        //
    }
}
