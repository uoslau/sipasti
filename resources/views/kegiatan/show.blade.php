<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="container-fluid py-1">

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Kegiatan: {{ $kegiatan }}</h6>
                        {{-- @if ($petugas->isEmpty())
                            <a class="btn btn-icon btn-3 btn-primary" type="button"
                                href="app/public/template/template_import.xlsx" download="template_import.xlsx">
                                <span class="btn-inner--text">Template</span>
                            </a>
                        @endif --}}
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                @if ($petugas->isEmpty())
                                    <form action="/petugas-import" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="col-md-6">
                                            <input type="hidden" name="kegiatan_id" value="{{ $kegiatan_id }}">
                                            <div
                                                class="input-group mb-3 card-header justify-content-between align-items-center">
                                                <input type="file" class="form-control" id="file"
                                                    name="excel_file">
                                                <button class="btn btn-primary mb-0" type="submit">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                @else
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
                                                Honor</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Tanggal Selesai</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Nomor BAST</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($petugas as $p)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">
                                                                {{ ucwords(strtolower($p->nama_mitra)) }}
                                                            </h6>
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
                                                <td class="align-middle text-center text-md">
                                                    <span class="badge badge-sm bg-primary">Rp.
                                                        {{ number_format($p->honor, 0, '.', '.') }}</span>
                                                </td>
                                                <td class="align-middle text-center text-md">
                                                    <span
                                                        class="badge badge-sm bg-success">{{ $p->tanggal_selesai }}</span>
                                                </td>
                                                <td class="align-middle text-center text-md">
                                                    <span class="badge badge-sm bg-danger">{{ $p->nomor_bast }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @endif
                            </table>
                            <div class="pagination justify-content-end">
                                {{ $petugas->onEachSide(0)->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-footer></x-footer>
    </div>
</x-layout>
