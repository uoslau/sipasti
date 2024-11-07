<x-layout>

    <x-slot:title>{{ $title }}</x-slot:title>

    {{-- @if (session()->has('success'))
        <div class="alert alert-info role="alert">
            {{ session('success') }}
        </div>
    @endif --}}

    <div class="container-fluid py-1">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Tabel {{ $title }}</h6>
                        @if ($kegiatan->isEmpty())
                        @else
                            <a class="btn btn-icon btn-3 btn-primary" type="button" href="/kegiatan/create">
                                <span class="btn-inner--text">Tambah Kegiatan</span>
                            </a>
                        @endif
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center justify-content-center mb-0">
                                @if ($kegiatan->isEmpty())
                                    <div class="col-md-6">
                                        {{-- <thead>
                                        <tr>
                                            <th> --}}
                                        <a class="btn btn-icon btn-3 btn-primary ms-3" type="button"
                                            href="/kegiatan/create">
                                            <span class="btn-inner--text">Tambah Kegiatan</span>
                                        </a>
                                        {{-- </th>
                                        </tr>
                                    </thead> --}}
                                    </div>
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
                                                Fungsi</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Tanggal Mulai</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Tanggal Selesai</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kegiatan as $k)
                                            <tr>
                                                <td
                                                    style="max-width: 500px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                    <div
                                                        class="d-flex
                                                    px-2">
                                                        <div class="my-auto">
                                                            <a href="/kegiatan/{{ $k->slug }}">
                                                                <h6 class="mb-0 text-sm">{{ $k->nama_kegiatan }}</h6>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex px-2">
                                                        <div class="my-auto">
                                                            <h6 class="mb-0 text-sm">Rp.
                                                                {{ number_format($k->petugas_kegiatan_sum_honor, 0, '.', '.') }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-xs font-weight-bold">
                                                        {{ $k->fungsi->fungsi ?? 'NA' }}
                                                    </span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="badge badge-sm bg-success">
                                                        {{ $k->tanggal_mulai }}
                                                    </span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="badge badge-sm bg-success">
                                                        {{ $k->tanggal_selesai }}
                                                    </span>
                                                </td>
                                                <td class="align-middle">
                                                    <a href="/kegiatan/download-all/{{ $k->slug }}"
                                                        class="text-secondary font-weight-bold text-xs"
                                                        data-toggle="tooltip" data-original-title="Edit user"> Print
                                                    </a>
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
