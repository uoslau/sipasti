<?php

namespace App\Imports;

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
        $indexKe = 1;
        foreach ($collection as $row) {
            if ($indexKe > 1) {
                $data = [
                    'sktnp'            => !empty($row[1]) ? $row[1] : '',
                    'nama_mitra'       => !empty($row[2]) ? $row[2] : '',
                    'kegiatan_id'      => $this->kegiatan_id,
                    'bertugas_sebagai' => !empty($row[4]) ? $row[4] : '',
                    'wilayah_tugas'    => !empty($row[5]) ? $row[5] : '',
                    'beban'            => !empty($row[6]) ? $row[6] : '',

                    'honor'            => !empty($row[7]) ? $row[7] : '',

                    'alamat'           => !empty($row[8]) ? $row[8] : '',
                    'pekerjaan'        => !empty($row[9]) ? $row[9] : '',

                    'nomor_bast'       => !empty($row[10]) ? $row[10] : '',
                    'generate_number'  => !empty($row[11]) ? $row[11] : '',
                ];

                PetugasKegiatan::create($data);
            }
            $indexKe++;
        }
    }
}
