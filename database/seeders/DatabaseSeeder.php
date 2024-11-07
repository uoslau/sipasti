<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Fungsi;
use App\Models\LimitKabupaten;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\MataAnggaran;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name'      => 'Nelson Samosir',
            'username'  => 'nelson1201',
            'password'  => bcrypt('ipds1201'),
            'is_admin'  => 1
        ]);
        User::create([
            'name'      => 'BPS Nias',
            'username'  => 'bps1201',
            'password'  => bcrypt('bps1201'),
            'is_admin'  => 1
        ]);

        MataAnggaran::create(['mata_anggaran' => '2898.BMA.007.005.A.521213']);
        MataAnggaran::create(['mata_anggaran' => '2899.BMA.006.005.A.521213']);
        MataAnggaran::create(['mata_anggaran' => '2902.BMA.004.005.A.521213']);
        MataAnggaran::create(['mata_anggaran' => '2902.QMA.006.005.A.521213']);
        MataAnggaran::create(['mata_anggaran' => '2903.BMA.009.005.A.521213']);
        MataAnggaran::create(['mata_anggaran' => '2904.BMA.006.005.A.521213']);
        MataAnggaran::create(['mata_anggaran' => '2905.BMA.004.005.A.521213']);
        MataAnggaran::create(['mata_anggaran' => '2906.BMA.006.005.A.521213']);
        MataAnggaran::create(['mata_anggaran' => '2907.BMA.008.005.A.521213']);
        MataAnggaran::create(['mata_anggaran' => '2908.BMA.004.005.A.521213']);
        MataAnggaran::create(['mata_anggaran' => '2909.BMA.005.005.A.521213']);
        MataAnggaran::create(['mata_anggaran' => '2910.BMA.008.005.A.521213']);
        MataAnggaran::create(['mata_anggaran' => '2910.QMA.006.005.A.521213']);
        MataAnggaran::create(['mata_anggaran' => '2910.QMA.007.005.A.521213']);
        MataAnggaran::create(['mata_anggaran' => '2910.QMA.010.005.A.521213']);

        Fungsi::create(['fungsi' => 'Distribusi']);
        Fungsi::create(['fungsi' => 'IPDS']);
        Fungsi::create(['fungsi' => 'NWAS']);
        Fungsi::create(['fungsi' => 'Produksi']);
        Fungsi::create(['fungsi' => 'Sosial']);

        LimitKabupaten::create([
            'kode_kabupaten'    => '1201',
            'nama_kabupaten'    => 'Nias',
            'honor_max'         => 3627000
        ]);
        LimitKabupaten::create([
            'kode_kabupaten'    => '1225',
            'nama_kabupaten'    => 'Nias Barat',
            'honor_max'         => 3704000
        ]);
    }
}
