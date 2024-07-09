<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="container-fluid py-1">

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Detail Penugasan: {{ $penugasan->nama_mitra }} / {{ $penugasan->kegiatan->nama_kegiatan }}
                        </h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nama</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Bertugas Sebagai</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Tanggal Mulai</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $penugasan->nama_mitra }}</h6>
                                                    <p class="text-xs text-secondary mb-0">
                                                        <a
                                                            href="/kegiatan/{{ $penugasan->kegiatan->slug }}">{{ $penugasan->kegiatan->nama_kegiatan }}</a>
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $p->bertugas_sebagai }}
                                                / {{ $p->beban }} {{ $p->satuan }}
                                            </p>
                                            <p class="text-xs text-secondary mb-0">
                                                @if ($p->wilayah_tugas == '1201')
                                                    Nias
                                                @else
                                                    Nias Barat
                                                @endif
                                            </p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-success">Online</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $penugasan->tanggal_mulai }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <a href="javascript:;" class="text-secondary font-weight-bold text-xs"
                                                data-toggle="tooltip" data-original-title="Edit user"> Edit </a>
                                        </td>
                                    </tr>
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
