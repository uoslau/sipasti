{{-- @dd($petugasBulan) --}}
<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="container-fluid py-1">

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>{{ $title }}</h6>
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
                                            Honor</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Jumlah Kegiatan</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($petugasBulan as $p)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">
                                                            {{ $p['nama_mitra'] }}
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-md">
                                                <span class="badge badge-sm bg-success">Rp.
                                                    {{ number_format($p['total_honor'], 0, '.', '.') }}</span>
                                            </td>
                                            <td class="align-middle text-center text-md">
                                                <span class="badge badge-sm bg-danger">{{ $p['jumlah_kegiatan'] }}
                                                    Kegiatan</span>
                                            </td>
                                            <td class="align-middle">
                                                <a href="javascript:;" class="text-secondary font-weight-bold text-xs"
                                                    data-toggle="tooltip" data-original-title="Edit user"> Print
                                                </a>
                                            </td>
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
