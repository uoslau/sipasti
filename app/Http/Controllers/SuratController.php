<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helpers\NumberToWords;
use App\Models\PetugasKegiatan;
use PhpOffice\PhpWord\TemplateProcessor;

class SuratController extends Controller
{
    public function generateBAST($id)
    {
        $petugas = PetugasKegiatan::findOrFail($id);

        $templatePath = storage_path('app/public/template/template_bast.docx');

        if (!file_exists($templatePath)) {
            return response()->json(['error' => 'Template file not found.'], 404);
        }

        $templateProcessor = new TemplateProcessor($templatePath);

        $currentDate = Carbon::now();
        $tanggal = $currentDate->format('d');
        $bulan = NumberToWords::monthName($currentDate->format('m'));
        $tahun = $currentDate->format('Y');
        $hari = NumberToWords::dayName($currentDate->format('l'));

        $tanggalTerbilang = NumberToWords::toWords($tanggal);
        $tahunTerbilang = NumberToWords::toWords($tahun);

        $data = [
            'sktnp' => $petugas->sktnp,
            'nama_mitra' => ucwords(strtolower($petugas->nama_mitra)),
            'nama_kegiatan' => $petugas->kegiatan->nama_kegiatan,
            'bertugas_sebagai' => $petugas->bertugas_sebagai,
            'wilayah_tugas' => $petugas->wilayah_tugas,
            'beban' => $petugas->beban,
            'satuan' => $petugas->satuan,
            'honor' => $petugas->honor,
            'tanggal_mulai' => $petugas->tanggal_mulai,
            'tanggal_selesai' => $petugas->tanggal_selesai,
            'alamat' => $petugas->alamat,
            'pekerjaan' => $petugas->pekerjaan,
            'nomor_kontrak' => $petugas->nomor_kontrak,
            'nomor_bast' => $petugas->nomor_bast,
            'hari' => $hari,
            'tanggal_terbilang' => $tanggalTerbilang,
            'bulan' => $bulan,
            'bulan_kapital' => strtoupper($bulan),
            'tahun' => date('Y'),
            'tahun_terbilang' => $tahunTerbilang
        ];

        foreach ($data as $key => $value) {
            $templateProcessor->setValue($key, $value);
        }

        $outputPath = storage_path('app/public/bast/BAST_' . $petugas->nama_mitra . '.docx');
        $templateProcessor->saveAs($outputPath);

        return response()->download($outputPath)->deleteFileAfterSend(true);
    }
}
