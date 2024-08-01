<?php

namespace App\Http\Controllers;

use ZipArchive;
use Carbon\Carbon;
use App\Models\Kegiatan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\NumberToWords;
use App\Models\LimitKabupaten;
use App\Models\PetugasKegiatan;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\TemplateProcessor;

class KontrakOBController extends Controller
{
    public function generateAllKontrak($slug)
    {
        Carbon::setLocale('id');

        $dateString = str_replace('-', ' ', $slug);

        $months = [
            'januari' => 'January',
            'februari' => 'February',
            'maret' => 'March',
            'april' => 'April',
            'mei' => 'May',
            'juni' => 'June',
            'juli' => 'July',
            'agustus' => 'August',
            'september' => 'September',
            'oktober' => 'October',
            'november' => 'November',
            'desember' => 'December',
        ];

        foreach ($months as $indonesian => $english) {
            if (strpos($dateString, $indonesian) !== false) {
                $dateString = str_replace($indonesian, $english, $dateString);
                break;
            }
        }

        $date = Carbon::createFromFormat('F Y', $dateString);

        $kegiatanList = PetugasKegiatan::whereMonth('tanggal_mulai', $date->month)
            ->whereYear('tanggal_mulai', $date->year)
            ->get();

        if ($kegiatanList->isEmpty()) {
            return response()->json(['error' => 'Belum ada kegiatan pada bulan tersebut.'], 404);
        }

        $petugasKegiatan = [];
        foreach ($kegiatanList as $kegiatan) {
            $petugasId = $kegiatan->sktnp;
            if (!isset($petugasKegiatan[$petugasId])) {
                $petugasKegiatan[$petugasId] = [
                    'petugas' => $kegiatan->nama_mitra,
                    'kegiatan' => []
                ];
            }
            $petugasKegiatan[$petugasId]['kegiatan'][] = $kegiatan;
        }

        $templatePath = storage_path('app/public/template/template_kontrak_ob.docx');

        if (!file_exists($templatePath)) {
            return response()->json(['error' => 'Template file not found.'], 404);
        }

        $zip = new ZipArchive();
        $zipFileName = storage_path('app/public/kontrak/Kontrak_' . str_replace('-', '_', ucwords($slug)) . '.zip');

        if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return response()->json(['error' => 'Could not create zip file.'], 500);
        }

        $wordFiles = [];

        foreach ($petugasKegiatan as $p) {
            $templateProcessor = new TemplateProcessor($templatePath);

            $kontrakDate = Carbon::createFromFormat('Y-m-d', $kegiatanList[0]->tanggal_mulai);

            // if ($kontrakDate->isSaturday() || $kontrakDate->isSunday()) {
            //     $kontrakDate = $kontrakDate->previous(Carbon::FRIDAY);
            // } else {
            //     $kontrakDate = $kontrakDate->copy()->startOfMonth();
            // }

            $kontrakDate = ($kontrakDate->isSaturday() || $kontrakDate->isSunday()) ? $kontrakDate->previous(Carbon::FRIDAY) : $kontrakDate->copy()->startOfMonth();
            $hari = NumberToWords::dayName($kontrakDate->format('l'));
            $tanggal = $kontrakDate->format('d');
            $bulan = NumberToWords::monthName($kontrakDate->format('m'));
            $tahun = $kontrakDate->format('Y');

            $kegiatanDate = Carbon::createFromFormat('Y-m-d', $kegiatanList[0]->tanggal_mulai);
            $tanggal_kegiatan = $kegiatanDate->format('d');
            $bulan_kegiatan = NumberToWords::monthName($kegiatanDate->format('m'));
            $tahun_kegiatan = $kegiatanDate->format('Y');

            $kegiatanEndDate = Carbon::createFromFormat('Y-m-d', $kegiatanList[0]->tanggal_selesai);
            $tambahan_waktu = $kegiatanEndDate->addDays(14)->format('d-m-Y');

            $kegiatanList = $p['kegiatan'];
            $total_honor = array_sum(array_column($kegiatanList, 'honor'));
            $total_honor_terbilang = NumberToWords::toWords($total_honor);

            $data = [
                'nomor_kontrak'             => $kegiatanList[0]->nomor_kontrak,
                'hari'                      => $hari,
                'tanggal_terbilang'         => ucfirst(NumberToWords::toWords($tanggal)),
                'bulan'                     => $bulan,
                'nama_mitra'                => ucwords(strtolower($p['petugas'])),
                'alamat'                    => $kegiatanList[0]->alamat,
                'tanggal_mulai'             => $kegiatanList[0]->tanggal_mulai,
                'tanggal_selesai'           => $kegiatanList[0]->tanggal_selesai,
                'total_honor'               => number_format($total_honor, 0, ',', '.'),
                'total_honor_terbilang'     => ucfirst($total_honor_terbilang),
                'tambahan_waktu'            => $tambahan_waktu,
                'mata_anggaran'             => $kegiatanList[0]->kegiatan->mataAnggaran->mata_anggaran,

                'bulan_kegiatan_kapital'    => strtoupper($bulan_kegiatan),
                'bulan_kegiatan'            => $bulan_kegiatan,
                'tahun_kegiatan'            => $tahun_kegiatan,
            ];

            foreach ($data as $key => $value) {
                $templateProcessor->setValue($key, $value);
            }

            $outputPath = storage_path('app/public/bast/KONTRAK_' . str_replace(' ', '_', $data['nama_mitra']) . '.docx');
            $templateProcessor->saveAs($outputPath);
            $zip->addFile($outputPath, 'KONTRAK_' . str_replace(' ', '_', $data['nama_mitra']) . '.docx');
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
