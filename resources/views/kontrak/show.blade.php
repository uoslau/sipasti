@dd($kegiatan)
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
                                            Kegiatan</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
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


                            </table>
                            {{-- <div class="pagination justify-content-end">
                                {{ $kegiatan->onEachSide(0)->links() }}
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-footer></x-footer>

    </div>

</x-layout>
