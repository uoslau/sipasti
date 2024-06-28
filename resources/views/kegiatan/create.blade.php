<x-layout>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="container-fluid py-1">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Tabel Kegiatan</h6>
                    </div>
                    <div class="card-body px-4 pt-0 pb-2">
                        <form method="POST" action="/tabel-kegiatan">
                            @csrf
                            <div class="row">
                                {{-- NAMA KEGIATAN --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama_kegiatan" class="form-control-label">Nama
                                            Kegiatan</label>
                                        <input class="form-control @error('nama_kegiatan') is-invalid @enderror"
                                            type="text" placeholder="Nama Kegiatan" id="nama_kegiatan"
                                            name="nama_kegiatan" required autofocus value="{{ old('nama_kegiatan') }}">
                                        @error('nama_kegiatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- SLUG --}}
                                <input type="hidden" id="slug" name="slug">
                            </div>
                            <div class="row">
                                {{-- TANGGAL MULAI --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="tanggal_mulai" class="form-control-label">Tanggal Mulai</label>
                                        <input class="form-control" type="date" id="tanggal_mulai"
                                            name="tanggal_mulai" value="{{ old('tanggal_mulai') }}">
                                    </div>
                                </div>
                                {{-- TANGGAL SELESAI --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="tanggal_selesai" class="form-control-label">Tanggal Selesai</label>
                                        <input class="form-control" type="date" id="tanggal_selesai"
                                            name="tanggal_selesai" value="{{ old('tanggal_selesai') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                {{-- MATA ANGGARAN --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="mata_anggaran_id" class="form-label">Mata Anggaran</label>
                                        <select class="form-select" id="mata_anggaran_id" name="mata_anggaran_id">
                                            <option selected disabled>Pilih Mata Anggaran</option>
                                            @foreach ($mataanggaran as $m)
                                                @if (old('mata_anggaran_id') == $m->id)
                                                    <option value="{{ $m->id }}" selected>{{ $m->mata_anggaran }}
                                                    </option>
                                                @else
                                                    <option value="{{ $m->id }}">{{ $m->mata_anggaran }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- FUNGSI --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="fungsi_id" class="form-label">Fungsi</label>
                                        <select class="form-select" id="fungsi_id" name="fungsi_id">
                                            <option selected disabled>Pilih Fungsi</option>
                                            @foreach ($fungsi as $f)
                                                @if (old('fungsi_id') == $f->id)
                                                    <option value="{{ $f->id }}" selected>
                                                        {{ $f->fungsi }}
                                                    </option>
                                                @else
                                                    <option value="{{ $f->id }}">{{ $f->fungsi }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                {{-- HONOR NIAS --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="honor_nias" class="form-control-label">Honor
                                            Nias</label>
                                        <input class="form-control" type="number" value="{{ old('honor_nias') }}"
                                            id="honor_nias" name="honor_nias">
                                    </div>
                                </div>
                                {{-- HONOR NIAS BARAT --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="honor_nias_barat" class="form-control-label">Honor Nias
                                            Barat</label>
                                        <input class="form-control" type="number"
                                            value="{{ old('honor_nias_barat') }}" id="honor_nias_barat"
                                            name="honor_nias_barat">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Tambah Kegiatan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <x-footer></x-footer> --}}

    </div>

    <script>
        const nama_kegiatan = document.querySelector("#nama_kegiatan");
        const slug = document.querySelector("#slug");

        nama_kegiatan.addEventListener("input", function() {
            let preslug = nama_kegiatan.value;
            preslug = preslug.replace(/ /g, "-");
            slug.value = preslug.toLowerCase();
        });

        function setDefaultDate(input) {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            input.value = `${year}-${month}-${day}`;
        }

        document.addEventListener("DOMContentLoaded", function() {
            setDefaultDate(tanggal_mulai);
            setDefaultDate(tanggal_selesai);
        });
    </script>

</x-layout>
