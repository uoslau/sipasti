<?php

namespace App\Imports;

use App\Models\Mitra;
use App\Models\Kegiatan;
use App\Models\NomorKontrak;
use App\Models\PetugasKegiatan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class PetugasImport implements ToCollection
{
    /**
     * @param Collection $collection
     */

    protected $kegiatan_id;

    public function __construct($kegiatanId)
    {
        $this->kegiatan_id = $kegiatanId;
    }

    public function collection(Collection $collection)
    {
        // UNTUK NOMOR KONTRAK
        $currentYear = date('Y');
        $contractNumber = NomorKontrak::firstOrCreate(
            ['year'          => $currentYear],
            ['last_number'   => 0]
        );

        // UNTUK HONOR
        $kegiatan = Kegiatan::find($this->kegiatan_id);
        $honor_nias = $kegiatan->honor_nias ?? 0;
        $honor_nias_barat = $kegiatan->honor_nias_barat ?? 0;
        $tanggal_mulai = $kegiatan->tanggal_mulai;
        $tanggal_selesai = $kegiatan->tanggal_selesai;

        $indexKe = 1;
        foreach ($collection as $row) {
            if ($indexKe > 1) {

                $contractNumber->last_number += 1;
                $contractNumber->save();

                if ($contractNumber->last_number < 1000) {
                    $nomorKontrak = str_pad($contractNumber->last_number, 3, '0', STR_PAD_LEFT) . "/1201_MITRA/" . $currentYear;
                    $nomorBAST = str_pad($contractNumber->last_number, 3, '0', STR_PAD_LEFT) . "/1201_BAST/" . $currentYear;
                } else {
                    $nomorKontrak = str_pad($contractNumber->last_number, 4, '0', STR_PAD_LEFT) . "/1201_MITRA/" . $currentYear;
                    $nomorBAST = str_pad($contractNumber->last_number, 4, '0', STR_PAD_LEFT) . "/1201_BAST/" . $currentYear;
                }

                $wilayah_tugas = !empty($row[4]) ? $row[4] : '';
                if ($wilayah_tugas == "1201") {
                    $honor = $honor_nias;
                } elseif ($wilayah_tugas == "1225") {
                    $honor = $honor_nias_barat;
                }

                $sktnp = !empty($row[1]) ? $row[1] : '';
                $mitra = Mitra::where('sktnp', $sktnp)->first();

                $alamat = $mitra ? $mitra->alamat : '';
                $pekerjaan = $mitra ? $mitra->pekerjaan : '';

                $data = [
                    'sktnp'             => !empty($row[1]) ? $row[1] : '',
                    'nama_mitra'        => !empty($row[2]) ? $row[2] : '',
                    'kegiatan_id'       => $this->kegiatan_id,
                    'bertugas_sebagai'  => !empty($row[3]) ? $row[3] : '',
                    'wilayah_tugas'     => $wilayah_tugas,
                    'beban'             => !empty($row[5]) ? $row[5] : '',
                    'honor'             => $honor,
                    'tanggal_mulai'     => $tanggal_mulai,
                    'tanggal_selesai'   => $tanggal_selesai,
                    'alamat'            => $alamat,
                    'pekerjaan'         => $pekerjaan,
                    'nomor_kontrak'     => $nomorKontrak,
                    'nomor_bast'        => $nomorBAST,
                ];

                PetugasKegiatan::create($data);
            }
            $indexKe++;
        }
    }
}
