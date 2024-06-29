<?php

namespace App\Imports;

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
        $currentYear = date('Y');
        $contractNumber = NomorKontrak::firstOrCreate(
            ['year'          => $currentYear],
            ['last_number'   => 0]
        );

        $indexKe = 1;
        foreach ($collection as $row) {
            if ($indexKe > 1) {

                $contractNumber->last_number += 1;
                $contractNumber->save();

                $nomorKontrak = str_pad($contractNumber->last_number, 3, '0', STR_PAD_LEFT) . "/1201_MITRA/" . $currentYear;
                $nomorBAST = str_pad($contractNumber->last_number, 3, '0', STR_PAD_LEFT) . "/1201_BAST/" . $currentYear;

                $data = [
                    'sktnp'             => !empty($row[1]) ? $row[1] : '',
                    'nama_mitra'        => !empty($row[2]) ? $row[2] : '',
                    'kegiatan_id'       => $this->kegiatan_id,
                    'bertugas_sebagai'  => !empty($row[3]) ? $row[3] : '',
                    'wilayah_tugas'     => !empty($row[4]) ? $row[4] : '',
                    'beban'             => !empty($row[5]) ? $row[5] : '',

                    'honor'             => !empty($row[6]) ? $row[6] : '',

                    'alamat'            => !empty($row[7]) ? $row[7] : '',
                    'pekerjaan'         => !empty($row[8]) ? $row[8] : '',

                    'nomor_kontrak'     => $nomorKontrak,
                    'nomor_bast'        => $nomorBAST,
                    // 'generate_number'   => !empty($row[10]) ? $row[10] : '',
                ];

                PetugasKegiatan::create($data);
            }
            $indexKe++;
        }
    }
}
