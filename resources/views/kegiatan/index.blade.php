{{-- @dd($kegiatan) --}}
<x-layout>

    <x-slot:title>{{ $title }}</x-slot:title>

    @if (session()->has('success'))
        <div class="alert alert-danger" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="container-fluid py-1">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Tabel Kegiatan</h6>
                        @if ($kegiatan->isEmpty())
                        @else
                            <a class="btn btn-icon btn-3 btn-primary" type="button" href="/tabel-kegiatan/create">
                                <span class="btn-inner--text">Tambah Kegiatan</span>
                            </a>
                        @endif
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center justify-content-center mb-0">
                                @if ($kegiatan->isEmpty())
                                    <thead>
                                        <tr>
                                            <th>
                                                <a class="btn btn-icon btn-3 btn-primary" type="button"
                                                    href="/tabel-kegiatan/create">
                                                    <span class="btn-inner--text">Tambah Kegiatan</span>
                                                </a>
                                            </th>
                                        </tr>
                                    </thead>
                                @else
                                    <thead>
                                        <tr>
                                            <th style="width: 500px;"
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Kegiatan</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Budget</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Tanggal Mulai</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Tanggal Selesai</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Fungsi</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kegiatan as $k)
                                            <tr>
                                                {{-- NAMA KEGIATAN --}}
                                                <td
                                                    style="max-width: 500px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                    <div
                                                        class="d-flex
                                                    px-2">
                                                        <div class="my-auto">
                                                            <a href="/tabel-kegiatan/{{ $k->slug }}">
                                                                <h6 class="mb-0 text-sm">{{ $k->nama_kegiatan }}</h6>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                                {{-- TOTAL HONOR --}}
                                                <td>
                                                    <div class="d-flex px-2">
                                                        <div class="my-auto">
                                                            <h6 class="mb-0 text-sm">Rp.
                                                                {{ number_format($k->petugas_kegiatan_sum_honor, 0, '.', '.') }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                {{-- TANGGAL MULAI --}}
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        {{ $k->tanggal_mulai }}
                                                    </span>
                                                </td>
                                                {{-- TANGGAL SELESAI --}}
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        {{ $k->tanggal_selesai }}
                                                    </span>
                                                </td>
                                                {{-- MATA ANGGARAN --}}
                                                {{-- <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    {{ $k->mataAnggaran->mata_anggaran ?? 'NA' }}
                                                </span>
                                            </td> --}}
                                                {{-- FUNGSI --}}
                                                <td class="align-middle text-center">
                                                    <span class="text-xs font-weight-bold">
                                                        {{ $k->fungsi->fungsi ?? 'NA' }}
                                                    </span>
                                                </td>
                                                {{-- TITIK 3 --}}
                                                <td class="align-middle">
                                                    <button class="btn btn-link text-secondary mb-0"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa fa-ellipsis-v text-xs"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @endif
                            </table>
                            <div class="pagination justify-content-end">
                                {{ $kegiatan->onEachSide(0)->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-footer></x-footer>

    </div>

</x-layout>
