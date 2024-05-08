@extends('layouts.app')

@section('content')
<style>
    .bg {
        height: 100vh;
        background-position: center;
        background-size: cover;
        background-image: url({{ asset('assets/images/banner-bg.png') }});
    }
</style>
<div class="container-fluid bg">
    <div class="row" style=" height: 100vh;">
        <div class="col-md-12 d-flex justify-content-center align-items-center overflow-auto" style="height: 100vh;max-height:100vh;" >
            <div class="card" style="width: 50rem;margin-top:50vh">
                <div class="card-header text-center">{{ __('Register pemilik toko') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('toko.updateperbaikan', $toko->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label for="namatoko" class="col-md-4 col-form-label text-md-end">{{ __('Name Store') }}</label>
                            <div class="col-md-6">
                                <input id="namatoko" type="text" class="form-control @error('namatoko') is-invalid @enderror" name="namatoko" value="{{ old('namatoko') ?? $toko->name }}" required autocomplete="namatoko" autofocus>
                                @error('namatoko')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="deskripsi" class="col-md-4 col-form-label text-md-end">{{ __('Description Store') }}</label>

                            <div class="col-md-6">
                                <textarea name="deskripsi" id="deskripsi" cols="30" rows="10" class="form-control @error('deskripsi') is-invalid @enderror" value="{{ old('deskripsi') ?? $toko->deskripsi }}" required autocomplete="deskripsi" autofocus>
                                </textarea>
                                @error('deskripsi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nik" class="col-md-4 col-form-label text-md-end">{{ __('Nik Ktp') }}</label>
                            <div class="col-md-6">
                                <input id="nik" type="text" class="form-control @error('nik') is-invalid @enderror" maxlength="16" minlength="16" name="nik" value="{{ old('nik') ?? $toko->nik }}" required autocomplete="nik" autofocus>
                                @error('nik')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="gambarktp" class="col-md-4 col-form-label text-md-end">{{ __('Foto Ktp') }}</label>
                            <div class="col-md-6">
                                <input id="gambarktp" type="file" class="form-control @error('gambarktp') is-invalid @enderror" name="gambarktp" value="{{ old('gambarktp') }}" required autocomplete="gambarktp" autofocus>
                                @error('gambarktp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="gambarpendukung" class="col-md-4 col-form-label text-md-end">{{ __('Dokumen Pendukung') }}</label>
                            <div class="col-md-6">
                                <input id="gambarpendukung" type="file" class="form-control @error('gambarpendukung') is-invalid @enderror" name="gambarpendukung" value="{{ old('gambarpendukung') }}" required autocomplete="gambarpendukung" autofocus>
                                @error('gambarpendukung')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <a href="{{ url('/') }}" class="btn btn-warning">Kembali</a>
                                <button type="submit" class="btn btn-primary">
                                    Perbaiki
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
