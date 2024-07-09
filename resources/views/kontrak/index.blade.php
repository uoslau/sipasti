{{-- @dd($groupedKegiatan) --}}

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
                            <table class="table align-items-center justify-content-center mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 500px;"
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Bulan-Tahun</th>
                                        {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Jumlah Kegiatan</th> --}}
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($groupedKegiatan as $bulan => $b)
                                        <tr>
                                            <td
                                                style="max-width: 500px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                <div
                                                    class="d-flex
                                                    px-2">
                                                    <div class="my-auto">
                                                        <a href="/kontrak/{{ $b['slug'] }}">
                                                            <h6 class="mb-0 text-sm">{{ $bulan }}</h6>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            {{-- <td>
                                                <div class="d-flex px-2">
                                                    <div class="my-auto">
                                                        <h6 class="mb-0 text-sm">Jumlah Kegiatan
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td> --}}
                                            <td class="align-middle">
                                                <a href="/kontrak/download-all/{{ $b['slug'] }}"
                                                    class="text-secondary font-weight-bold text-xs"
                                                    data-toggle="tooltip" data-original-title="Edit user"> Print
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-footer></x-footer>

    </div>

</x-layout>
