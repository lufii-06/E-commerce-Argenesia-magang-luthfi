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
            <div class="col-md-12 d-flex justify-content-center align-items-center overflow-auto"
                style="height: 100vh;max-height:100vh;">
                <div class="card" style="width: 50rem;margin-top:50vh">
                    <div class="card-header text-center font-weight-bold">{{ __('Validasi Izin    toko') }}</div>

                    <div class="card-body">
                        @foreach ($dataToko as $item)
                            <div class="row mb-3">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Name User') }}</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" disabled name="name"
                                        value="{{ $item->user->name }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="namatoko"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Name Store') }}</label>
                                <div class="col-md-6">
                                    <input id="namatoko" type="text" class="form-control " name="namatoko" disabled
                                        value="{{ $item->name }}" required autocomplete="namatoko" autofocus>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="deskripsi"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Description Store') }}</label>

                                <div class="col-md-6">
                                    <textarea name="deskripsi" id="deskripsi" cols="30" rows="10" class="form-control " disabled
                                        value="required autocomplete="deskripsi autofocus>{{ $item->deskripsi }}
                                </textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="nik"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Nik Ktp') }}</label>
                                <div class="col-md-6">
                                    <input id="nik" type="text" class="form-control " maxlength="16" minlength="16"
                                        disabled name="nik" value="{{ $item->nik }}" required autocomplete="nik"
                                        autofocus>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="gambarktp"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Foto Ktp') }}</label>
                                <div class="col-md-6">
                                    <img src="{{ asset('storage/photo/' . $item->gambarktp) }}" alt=""
                                        width="50px">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="gambarpendukung"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Dokumen Pendukung') }}</label>
                                <div class="col-md-6">
                                    <img src="{{ asset('storage/photo/' . $item->gambarpendukung) }}" alt=""
                                        width="50px">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control " name="email" disabled
                                        value="{{ $item->user->email }}" required autocomplete="email">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <a href="{{ url('/beranda') }}" class="btn btn-secondary">Kembali</a>
                                    @if ($item->status == '0')
                                        <a href="{{ url('toko/update/' . $item->id) }}" class="btn btn-primary">Izinkan</a>
                                        <a href="" class="btn btn-danger" data-toggle="modal"
                                        data-target="#myModal">Tolak</a>
                                    @else
                                        <a href="{{ url('toko/update/' . $item->id) }}"
                                            class="btn btn-primary">Nonaktifkan</a>
                                    @endif
                                    
                                </div>
                                <form action="{{ route('toko.revisi', $item->id) }}" method="post">
                                    @csrf
                                    <div class="modal" id="myModal" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Pesan Penolakan</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <label for="pesan">Pesan</label>
                                                    <input type="text" id="pesan" name="pesan" class="form-control">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
