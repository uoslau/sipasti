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
    protected $kegiatan_id;

    public function __construct($kegiatanId)
    {
        $this->kegiatan_id = $kegiatanId;
    }

    public function collection(Collection $collection)
    {
        $kegiatan = Kegiatan::find($this->kegiatan_id);
        $tanggal_mulai_mitra = $kegiatan->tanggal_mulai;
        $tanggal_selesai_mitra = $kegiatan->tanggal_selesai;

        $honor_nias = $kegiatan->honor_nias ?? 0;
        $honor_nias_barat = $kegiatan->honor_nias_barat ?? 0;

        $currentYear = date('Y', strtotime($tanggal_mulai_mitra));
        $currentMonth = date('m', strtotime($tanggal_mulai_mitra));

        // Fetch the global last contract number
        $globalContractNumber = NomorKontrak::orderBy('last_global_contract_number', 'desc')->first();
        $lastGlobalContractNumber = $globalContractNumber ? $globalContractNumber->last_global_contract_number : 0;

        // Fetch the global last BAST number
        $globalBastNumber = NomorKontrak::orderBy('last_bast_number', 'desc')->first();
        $lastGlobalBastNumber = $globalBastNumber ? $globalBastNumber->last_bast_number : 0;

        $indexKe = 1;
        foreach ($collection as $row) {
            if ($indexKe > 1) {
                $sktnp = !empty($row[1]) ? $row[1] : '';
                $mitra = Mitra::where('sktnp', $sktnp)->first();

                $alamat = $mitra ? $mitra->alamat : '';
                $pekerjaan = $mitra ? $mitra->pekerjaan : '';

                // Check if contract number already exists for this mitra and month
                $existingContract = NomorKontrak::where('sktnp', $sktnp)
                    ->where('year', $currentYear)
                    ->where('month', $currentMonth)
                    ->first();

                if (!$existingContract) {
                    // Increment the global contract number
                    $lastGlobalContractNumber++;
                    $contractNumberStr = str_pad($lastGlobalContractNumber, 3, '0', STR_PAD_LEFT) . "/1201_MITRA/" . $currentYear;

                    // Create a new contract record for the mitra
                    $mitraContractNumber = NomorKontrak::create([
                        'sktnp' => $sktnp,
                        'year' => $currentYear,
                        'month' => $currentMonth,
                        'last_contract_number' => $lastGlobalContractNumber,
                        'last_global_contract_number' => $lastGlobalContractNumber,
                        'last_bast_number' => $lastGlobalBastNumber,
                    ]);
                } else {
                    $contractNumberStr = str_pad($existingContract->last_contract_number, 3, '0', STR_PAD_LEFT) . "/1201_MITRA/" . $currentYear;
                    $mitraContractNumber = $existingContract;
                }

                // Update global last_bast_number untuk BAST
                $lastGlobalBastNumber++;
                $nomorBAST = str_pad($lastGlobalBastNumber, 3, '0', STR_PAD_LEFT) . "/1201_BAST/" . $currentYear;

                // Update mitraContractNumber dengan last_bast_number yang baru
                $mitraContractNumber->last_bast_number = $lastGlobalBastNumber;
                $mitraContractNumber->save();

                $beban = !empty($row[5]) ? $row[5] : '';
                $wilayah_tugas = !empty($row[4]) ? $row[4] : '';
                $honor = ($wilayah_tugas == "1201") ? $honor_nias : ($wilayah_tugas == "1225" ? $honor_nias_barat : 0);

                $data = [
                    'sktnp'             => $sktnp,
                    'nama_mitra'        => !empty($row[2]) ? $row[2] : '',
                    'kegiatan_id'       => $this->kegiatan_id,
                    'bertugas_sebagai'  => !empty($row[3]) ? $row[3] : '',
                    'wilayah_tugas'     => $wilayah_tugas,
                    'beban'             => $beban,
                    'satuan'            => !empty($row[6]) ? $row[6] : '',
                    'honor'             => $beban * $honor,
                    'tanggal_mulai'     => $tanggal_mulai_mitra,
                    'tanggal_selesai'   => $tanggal_selesai_mitra,
                    'alamat'            => $alamat,
                    'pekerjaan'         => $pekerjaan,
                    'nomor_kontrak'     => $contractNumberStr,
                    'nomor_bast'        => $nomorBAST,
                ];

                PetugasKegiatan::create($data);
            }
            $indexKe++;
        }
    }
}
