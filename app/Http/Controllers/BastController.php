<?php

namespace App\Http\Controllers;

use ZipArchive;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helpers\NumberToWords;
use App\Models\PetugasKegiatan;
use PhpOffice\PhpWord\TemplateProcessor;

class BastController extends Controller
{
    public function generateAllBAST($kegiatanId)
    {
        $petugasList = PetugasKegiatan::where('kegiatan_id', $kegiatanId)->get();

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

            // $currentDate = Carbon::now();
            // $hari = NumberToWords::dayName($currentDate->format('l'));
            // $tanggal = $currentDate->format('d');
            // $tanggalTerbilang = NumberToWords::toWords($tanggal);
            // $bulan = NumberToWords::monthName($currentDate->format('m'));
            // $tahun = $currentDate->format('Y');
            // $tahunTerbilang = NumberToWords::toWords($tahun);

            $kegiatanDate = Carbon::createFromFormat('Y-m-d', $petugas->kegiatan->tanggal_mulai);
            $tanggal_kegiatan = $kegiatanDate->format('d');
            $bulan_kegiatan = NumberToWords::monthName($kegiatanDate->format('m'));
            $tahun_kegiatan = $kegiatanDate->format('Y');

            $bastDate = Carbon::createFromFormat('Y-m-d', $petugas->kegiatan->tanggal_selesai);
            $hari_bast = NumberToWords::dayName($bastDate->format('l'));
            $tanggal_bast = $bastDate->format('d');
            $tanggal_bast_terbilang = NumberToWords::toWords($tanggal_bast);
            $bulan_bast = NumberToWords::monthName($bastDate->format('m'));
            $tahun_bast = $bastDate->format('Y');
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
