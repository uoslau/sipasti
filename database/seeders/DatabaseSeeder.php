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

        MataAnggaran::create(['mata_anggaran' => '2909.BMA.005.005.A.521213']);
        MataAnggaran::create(['mata_anggaran' => '2903.BMA.009.005.A.521213']);
        MataAnggaran::create(['mata_anggaran' => '2904.BMA.006.005.A.521213']);

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
