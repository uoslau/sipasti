<?php

namespace App\Http\Controllers;

use ZipArchive;
use Carbon\Carbon;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use App\Helpers\NumberToWords;
use App\Models\PetugasKegiatan;
use PhpOffice\PhpWord\TemplateProcessor;

class BastController extends Controller
{
    public function generateAllBAST($slug)
    {
        $kegiatan = Kegiatan::where('slug', $slug)->with('petugasKegiatan')->first();

        if (!$kegiatan) {
            return response()->json(['error' => 'Kegiatan tidak ditemukan.'], 404);
        }

        $petugasList = $kegiatan->petugasKegiatan;

        if ($petugasList->isEmpty()) {
            return response()->json(['error' => 'Belum ada petugas pada kegiatan.'], 404);
        }

        $templatePath = storage_path('app/public/template/template_bast.docx');

        if (!file_exists($templatePath)) {
            return response()->json(['error' => 'Template file not found.'], 404);
        }

        $zip = new ZipArchive();
        $namaKegiatan = $petugasList->first()->kegiatan->slug;
        $zipFileName = storage_path('app/public/bast/BAST_' . str_replace(' ', '_', $namaKegiatan) . '.zip');

        if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return response()->json(['error' => 'Could not create zip file.'], 500);
        }

        $wordFiles = [];
        foreach ($petugasList as $petugas) {
            $templateProcessor = new TemplateProcessor($templatePath);

            $kontrakDate = Carbon::createFromFormat('Y-m-d', $petugas->kegiatan->tanggal_mulai);
            $kontrakDate = $kontrakDate->copy()->startOfMonth();
            $kontrakDate = ($kontrakDate->isSaturday() || $kontrakDate->isSunday()) ? $kontrakDate->previousWeekday() : $kontrakDate->copy()->startOfMonth();
            $tanggal_kontrak = $kontrakDate->format('d');
            $bulan_kontrak = NumberToWords::monthName($kontrakDate->format('m'));
            $tahun_kontrak = $kontrakDate->format('Y');

            $kegiatanDate = Carbon::createFromFormat('Y-m-d', $petugas->kegiatan->tanggal_mulai);
            $tanggal_kegiatan = $kegiatanDate->format('d');
            $bulan_kegiatan = NumberToWords::monthName($kegiatanDate->format('m'));
            $tahun_kegiatan = $kegiatanDate->format('Y');

            $kegiatanEndDate = Carbon::createFromFormat('Y-m-d', $petugas->kegiatan->tanggal_selesai);
            if ($kegiatanEndDate->isSaturday() || $kegiatanEndDate->isSunday()) {
                $kegiatanEndDate = $kegiatanEndDate->nextWeekday();
            }
            $hari_bast = NumberToWords::dayName($kegiatanEndDate->format('l'));
            $tanggal_bast = $kegiatanEndDate->format('d');
            $tanggal_bast_terbilang = NumberToWords::toWords($tanggal_bast);
            $bulan_bast = NumberToWords::monthName($kegiatanEndDate->format('m'));
            $tahun_bast = $kegiatanEndDate->format('Y');
            $tahun_bast_terbilang = NumberToWords::toWords($tahun_bast);

            $data = [
                'bulan_kegiatan_kapital'    => strtoupper($bulan_kegiatan),
                'tahun_kegiatan'            => $tahun_kegiatan,
                'nomor_bast'                => $petugas->nomor_bast,
                'hari'                      => $hari_bast,
                'tanggal_terbilang'         => ucfirst($tanggal_bast_terbilang),
                'bulan'                     => $bulan_bast,
                'tahun_terbilang'           => ucfirst($tahun_bast_terbilang),
                'nama_mitra'                => ucwords(strtolower($petugas->nama_mitra)),
                'alamat'                    => $petugas->alamat,
                'bulan_kegiatan'            => $bulan_kegiatan,
                'tanggal_kegiatan'          => $tanggal_kegiatan,
                'nomor_kontrak'             => $petugas->nomor_kontrak,
                'tanggal_kontrak'           => $tanggal_kontrak,
                'bulan_kontrak'             => $bulan_kontrak,
                'tahun_kontrak'             => $tahun_kontrak,
                'nama_kegiatan'             => $petugas->kegiatan->nama_kegiatan,
                'beban'                     => $petugas->beban,
                'satuan'                    => $petugas->satuan,
                'fungsi'                    => $petugas->kegiatan->fungsi->fungsi,
            ];

            foreach ($data as $key => $value) {
                $templateProcessor->setValue($key, $value);
            }

            $outputPath = storage_path('app/public/bast/BAST_' . str_replace(' ', '_', $data['nama_mitra']) . '.docx');
            $templateProcessor->saveAs($outputPath);
            $zip->addFile($outputPath, 'BAST_' . str_replace(' ', '_', $data['nama_mitra']) . '.docx');
            $wordFiles[] = $outputPath;
        }

        $zip->close();

        foreach ($wordFiles as $filePath) {
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        return response()->download($zipFileName)->deleteFileAfterSend(true);
    }
}
