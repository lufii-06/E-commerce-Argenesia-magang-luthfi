@extends('layouts.home')
@section('isi')
    <div class="fashion_section" id="fashion_section">
        <div class="container p-5">
            <div class="card-header" id="daftartoko">
                <h3 class="">Update Produk</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('produk.update', $data->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" value="{{ $data->id }}" name="toko_id">
                    <div class="mb-2">
                        <label for="kategori">Kategori</label>
                        <select name="kategori" id="kategori" class="form-control @error('kategori') is-invalid @enderror">
                            <option value="" disabled selected>Pilih</option>
                            <option class="form-control @error('kategori') is-invalid @enderror" value="Smartphone"
                                {{ old('kategori', $data->kategori) == 'Smartphone' ? 'selected' : null }}>Smartphone
                            </option>
                            <option class="form-control @error('kategori') is-invalid @enderror" value="Laptop"
                                {{ old('kategori', $data->kategori) == 'Laptop' ? 'selected' : null }}>Laptop</option>
                            <option class="form-control @error('kategori') is-invalid @enderror" value="Aksesoris"
                                {{ old('kategori', $data->kategori) == 'Aksesoris' ? 'selected' : null }}>Aksesoris
                            </option>
                        </select>
                        @error('kategori')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama"
                            class="form-control @error('nama') is-invalid @enderror "
                            value="{{ old('nama', $data->name) }}">
                        @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" cols="30" rows="10"
                            class="form-control @error('deskripsi') is-invalid @enderror" value="{{ old('deskripsi', $data->deskripsi) }}"
                            required autocomplete="deskripsi" autofocus>{{ old('deskripsi', $data->deskripsi) }}
                        </textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="harga">Harga</label>
                        <input type="text" name="harga" id="harga"
                            class="form-control @error('harga') is-invalid @enderror "
                            value="{{ old('harga', $data->harga) }}">
                        @error('harga')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="photo">Foto Cover</label>
                        <input type="file" name="photo" id="photo"
                            class="form-control @error('photo') is-invalid @enderror" value="{{ old('photo') }}">
                        <img src="{{ asset('storage/photo/' . $data->photo) }}" alt="gambar" id="img-view" width="100px"
                            class="mt-4">
                        @error('photo')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label for="photo1">Foto Detail</label>
                        <input type="file" name="photo1" id="photo1"
                            class="form-control @error('photo1') is-invalid @enderror" value="{{ old('photo1') }}">
                        <img src="{{ asset('storage/photo/' . $data->photo1) }}" alt="gambar1" id="img-view1" width="100px"
                            class="mt-4">
                        @error('photo1')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label for="photo2">Foto Detail</label>
                        <input type="file" name="photo2" id="photo2"
                            class="form-control @error('photo2') is-invalid @enderror" value="{{ old('photo2') }}">
                        <img src="{{ asset('storage/photo/' . $data->photo2) }}" alt="gambar2" id="img-view2" width="100px"
                            class="mt-4">
                        @error('photo2')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <input type="text" value="{{ $data->photo }}" name="oldPhoto">
                    <input type="text" value="{{ $data->photo1 }}" name="oldPhoto1">
                    <input type="text" value="{{ $data->photo2 }}" name="oldPhoto2">
                    <div class="justify-content-end d-flex">
                        <a href="{{ route('produk.index') }}" class="btn btn-primary">Kembali</a>
                        <div class="m-1"></div>
                        <button type="submit" class="btn btn-primary">edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
@endpush
