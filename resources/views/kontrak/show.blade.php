<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="container-fluid py-1">

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                                <h6>{{ $title }} {{ $date }}</h6>
                                {{-- Form Filter --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" id="filter-nama" class="form-control"
                                            placeholder="Cari Nama">
                                    </div>
                                </div>
                            </div>

                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 300px;"
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nama</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Wilayah Tugas</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Honor Bulan Ini</th>
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
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">
                                                        @if ($p['wilayah_tugas'] == '1201')
                                                            Nias
                                                        @else
                                                            Nias Barat
                                                        @endif
                                                    </h6>
                                                </div>

                                            </td>
                                            <td class="align-middle text-center text-md">
                                                <span class="badge badge-sm bg-primary fixed-width-badge">Rp
                                                    {{ number_format($p['total_honor'], 0, '.', '.') }}</span>
                                            </td>
                                            <td class="align-middle text-center text-md">
                                                <span class="badge badge-sm bg-danger fixed-width-badge">Rp
                                                    {{ number_format($p['honor_max'] - $p['total_honor'], 0, '.', '.') }}</span>
                                            </td>
                                            <td class="align-middle text-center text-md">
                                                <span class="badge badge-sm bg-success fixed-width-badge">
                                                    @if ($p['total_honor'] > $p['honor_max'])
                                                        Rp {{ number_format($p['honor_max'], 0, '.', ',') }}
                                                    @else
                                                        Rp {{ number_format($p['total_honor'], 0, '.', ',') }}
                                                    @endif
                                                </span>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterNama = document.getElementById('filter-nama');
        const tableBody = document.querySelector('tbody');

        function applyFilter() {
            const namaValue = filterNama.value.toLowerCase();

            const rows = tableBody.querySelectorAll('tr');
            rows.forEach(row => {
                const nama = row.querySelector('td:nth-child(1) h6').innerText.toLowerCase();

                const matchNama = nama.includes(namaValue);

                if (matchNama) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        filterNama.addEventListener('input', applyFilter);
    });
</script>
