<x-layout>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="container-fluid py-1">
        <div class="row">
            {{-- JUMLAH KEGIATAN --}}
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Jumlah Kegiatan</p>
                                    <h6 class="font-weight-bolder">
                                        {{ $totalKegiatan }} Kegiatan
                                    </h6>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div
                                    class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- TOTAL HONOR --}}
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Honor</p>
                                    <h5 class="font-weight-bolder">Rp.
                                        {{ number_format($totalHonor, 0, '.', '.') }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div
                                    class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- KEGIATAN TERAKHIR --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Kegiatan Terakhir</p>
                                    @if ($latestKegiatan)
                                        <h6 class="font-weight-bolder">
                                            {{ $latestKegiatan->nama_kegiatan }}
                                        </h6>
                                    @else
                                        <h6 class="font-weight-bolder">Belum Ada Kegiatan</h6>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div
                                    class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            {{-- TABEL --}}
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header pb-0 p-3">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-2">Penugasan Terakhir</h6>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center">
                            <tbody>
                                @foreach ($penugasan as $p)
                                    <tr>
                                        <td class="w-30">
                                            <div class="d-flex px-2 py-1 align-items-center">
                                                <div class="ms-4">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $p->kegiatan->nama_kegiatan }}</p>
                                                    <h6 class="text-sm mb-0">{{ ucwords(strtolower($p->nama_mitra)) }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $p->bertugas_sebagai }}</p>
                                                <h6 class="text-xs mb-0">
                                                    @if ($p->wilayah_tugas == '1201')
                                                        Nias
                                                    @else
                                                        Nias Barat
                                                    @endif
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $p->beban }}</p>
                                                <h6 class="text-xs mb-0">{{ $p->satuan }}</h6>
                                            </div>
                                        </td>
                                        <td class="align-middle text-sm">
                                            <div class="col text-center">
                                                <p class="text-xs font-weight-bold mb-0">Honor</p>
                                                <h6 class="text-xs mb-0">Rp. {{ number_format($p->honor, 0, '.', '.') }}
                                                </h6>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- KONTRAK --}}
            {{-- <div class="col-lg-3 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0 text-center">KONTRAK BULANAN</h6>
                    </div>
                    <div class="card-body p-3">
                        <ul class="list-group">
                            @foreach ($kontrak as $bulan => $k)
                                <li
                                    class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                    <div class="d-flex align-items-center">
                                        <div class="icon icon-shape icon-sm me-3 bg-primary shadow text-center">
                                            <i class="ni ni-calendar-grid-58 text-light opacity-10"></i>
                                        </div>
                                        <a href="/kontrak/{{ $k['slug'] }}">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-sm">{{ $bulan }}</h6>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="d-flex">
                                        <a href="/kontrak/download-all/{{ $k['slug'] }}"
                                            class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i
                                                class="ni ni-bold-right" aria-hidden="true"></i></a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div> --}}
            <div class="col-lg-3 mb-lg-0 mb-4">
                <div class="card">
                    <div class="card-header pb-0 p-3">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-2">KONTRAK BULANAN</h6>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center">
                            <tbody>
                                @foreach ($kontrak as $bulan => $k)
                                    <tr>
                                        <td class="w-30">

                                            <div class="d-flex px-2 py-1 align-items-center">
                                                <div class="icon icon-shape icon-sm me-3 bg-primary shadow text-center">
                                                    <i class="ni ni-bold-right text-light opacity-10"></i>
                                                </div>
                                                <div>
                                                    <a href="/kontrak/{{ $k['slug'] }}">
                                                        <div class="d-flex flex-column">
                                                            <h6 class="mb-1 text-dark text-sm">{{ $bulan }}</h6>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="w-30 text-right">
                                            <div class="ms-4">
                                                <a href="/kontrak/download-all/{{ $k['slug'] }}"
                                                    class="text-secondary font-weight-bold text-xs"
                                                    data-toggle="tooltip" data-original-title="print">Print
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <x-footer></x-footer>
    </div>
</x-layout>
