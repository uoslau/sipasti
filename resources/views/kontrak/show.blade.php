{{-- @dd($petugas) --}}
<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="container-fluid py-1">

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>{{ $title }}</h6>
                        {{-- searching --}}
                        <form action="/kontrak">
                            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                                <div class="input-group">
                                    <span class="input-group-text text-body"><i class="fas fa-search"
                                            aria-hidden="true"></i></span>
                                    <input type="text" class="form-control" placeholder="Search.." name="search">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 500px;"
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nama</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Wilayah Tugas</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Honor</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Sisa Bulan Ini</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Bisa Dibayar</th>
                                        {{-- <th class="text-secondary opacity-7"></th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($petugas as $p)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">
                                                            {{ ucwords(strtolower($p['nama_mitra'])) }}
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-md">
                                                <span class="badge badge-sm bg-primary">{{ $p['wilayah_tugas'] }}</span>
                                            </td>
                                            <td class="align-middle text-center text-md">
                                                <span class="badge badge-sm bg-success">Rp
                                                    {{ number_format($p['total_honor'], 0, '.', '.') }}</span>
                                            </td>
                                            <td class="align-middle text-center text-md">
                                                <span class="badge badge-sm bg-danger">Rp
                                                    {{ number_format($p['honor_max'] - $p['total_honor'], 0, '.', '.') }}</span>
                                            </td>
                                            <td class="align-middle text-center text-md">
                                                <span class="badge badge-sm bg-success">
                                                    @if ($p['total_honor'] > $p['honor_max'])
                                                        Rp {{ number_format($p['honor_max'], 0, '.', ',') }}
                                                    @else
                                                        Rp {{ number_format($p['total_honor'], 0, '.', ',') }}
                                                    @endif
                                                </span>
                                            </td>
                                            {{-- <td class="align-middle">
                                                <a href="#" class="text-secondary font-weight-bold text-xs"
                                                    data-toggle="tooltip" data-original-title="Edit user"> Print
                                                </a>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                            {{-- <div class="pagination justify-content-end">
                                {{ $petugasBulan->onEachSide(0)->links() }}
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-footer></x-footer>
    </div>
</x-layout>
