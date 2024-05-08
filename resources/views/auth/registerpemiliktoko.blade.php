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
                    <form method="POST" action="{{ url('/createtoko') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="namatoko" class="col-md-4 col-form-label text-md-end">{{ __('Name Store') }}</label>
                            <div class="col-md-6">
                                <input id="namatoko" type="text" class="form-control @error('namatoko') is-invalid @enderror" name="namatoko" value="{{ old('namatoko') }}" required autocomplete="namatoko" autofocus>
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
                                <textarea name="deskripsi" id="deskripsi" cols="30" rows="10" class="form-control @error('deskripsi') is-invalid @enderror" value="{{ old('deskripsi') }}" required autocomplete="deskripsi" autofocus>
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
                                <input id="nik" type="text" class="form-control @error('nik') is-invalid @enderror" maxlength="16" minlength="16" name="nik" value="{{ old('nik') }}" required autocomplete="nik" autofocus>
                                @error('nik')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="jenisrekening" class="col-md-4 col-form-label text-md-end">{{ __('Jenis Rekening') }}</label>
                            <div class="col-md-6">
                                <select id="jenisrekening" class="form-control @error('jenisrekening') is-invalid @enderror" name="jenisrekening" required autofocus>
                                    <option value="">PILIH JENIS REKENING</option> <!-- Opsi default dengan huruf besar -->
                                    <option value="BCA" {{ old('jenisrekening') == 'BCA' ? 'selected' : '' }}>BCA</option>
                                    <option value="BRI" {{ old('jenisrekening') == 'BRI' ? 'selected' : '' }}>BRI</option>
                                    <option value="MANDIRI" {{ old('jenisrekening') == 'MANDIRI' ? 'selected' : '' }}>Mandiri</option>
                                    <option value="BNI" {{ old('jenisrekening') == 'BNI' ? 'selected' : '' }}>BNI</option>
                                    <option value="CIMB NIAGA" {{ old('jenisrekening') == 'CIMB NIAGA' ? 'selected' : '' }}>CIMB Niaga</option>
                                    <option value="DANA" {{ old('jenisrekening') == 'DANA' ? 'selected' : '' }}>Dana</option> <!-- Huruf besar -->
                                    <option value="OVO" {{ old('jenisrekening') == 'OVO' ? 'selected' : '' }}>OVO</option> <!-- Huruf besar -->
                                </select>
                                @error('jenisrekening')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="norek" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Rekening') }}</label>
                            <div class="col-md-6">
                                <input id="norek" type="text" class="form-control @error('norek') is-invalid @enderror" maxlength="15" minlength="15" name="norek" value="{{ old('norek') }}" required autocomplete="norek" autofocus>
                                @error('norek')
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

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <a href="{{ url('/') }}" class="btn btn-primary">Kembali</a>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
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
