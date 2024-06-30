{{-- @dd($penugasans) --}}
<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="container-fluid py-1">

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Tabel Penugasan</h6>
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
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Bertugas Sebagai</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nomor Kontrak</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nomor BAST</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penugasan as $p)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm"><a
                                                                href="/tabel-penugasan/{{ $p->slug }}">{{ $p->nama_mitra }}</a>
                                                        </h6>
                                                        <p class="text-xs text-secondary mb-0">
                                                            <a
                                                                href="/tabel-kegiatan/{{ $p->kegiatan->slug }}">{{ $p->kegiatan->nama_kegiatan }}</a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $p->bertugas_sebagai }}</p>
                                                <p class="text-xs text-secondary mb-0">
                                                    @if ($p->wilayah_tugas == '1201')
                                                        Nias
                                                    @else
                                                        Nias Barat
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="align-middle text-center text-md">
                                                <span class="badge badge-sm bg-primary">{{ $p->nomor_kontrak }}</span>
                                            </td>
                                            <td class="align-middle text-center text-md">
                                                <span class="badge badge-sm bg-success">{{ $p->nomor_bast }}</span>
                                            </td>
                                            <td class="align-middle">
                                                <a href="javascript:;" class="text-secondary font-weight-bold text-xs"
                                                    data-toggle="tooltip" data-original-title="Edit user"> Edit </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination justify-content-end">
                                {{ $penugasan->onEachSide(0)->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-footer></x-footer>
    </div>
</x-layout>
