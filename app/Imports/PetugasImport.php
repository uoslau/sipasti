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
    public function collection(Collection $collection)
    {
        // dd($collection);
        $indexKe = 1;
        foreach ($collection as $row) {
            if ($indexKe > 1) {
                $data['sktnp']              = !empty($row[1]) ? $row[1] : '';
                $data['nama_mitra']         = !empty($row[2]) ? $row[2] : '';
                $data['slug']               = !empty($row[3]) ? $row[3] : '';
                $data['kegiatan_id']        = !empty($row[4]) ? $row[4] : '';
                $data['bertugas_sebagai']   = !empty($row[5]) ? $row[5] : '';
                $data['wilayah_tugas']      = !empty($row[6]) ? $row[6] : '';
                $data['beban']              = !empty($row[7]) ? $row[7] : '';
                $data['honor']              = !empty($row[8]) ? $row[8] : '';
                $data['alamat']             = !empty($row[9]) ? $row[9] : '';
                $data['pekerjaan']          = !empty($row[10]) ? $row[10] : '';
                $data['nomor_bast']         = !empty($row[11]) ? $row[11] : '';
                $data['generate_number']    = !empty($row[12]) ? $row[12] : '';

                PetugasKegiatan::create($data);
            }
            $indexKe++;
        }
    }
}
