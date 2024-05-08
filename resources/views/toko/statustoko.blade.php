@extends('layouts.app')
@section('content')
    <style>
        .bg {
            background-position: center;
            background-size: cover;
            background-image: url({{ asset('assets/images/banner-bg.png') }});
        }
    </style>
    <div class="container-fluid bg" style="height: 100vh">
        <div class="row " style="height: 100vh">
            <div class="col-md-12 d-flex justify-content-center align-items-center" style="height: 100vh">
                <div class="card" style="width: 26rem;">
                    <div class="card-header text-center font-weight-bold">Pemberitahuan !!</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 text-center">
                                <img src="{{ asset('assets/images/icons8-padlock-750.png') }}" alt=""
                                    style="height: 8rem;" class="img-fluid">
                            </div>
                            <div class="col-6 text-left"> Akun anda masi belum diverifikasi oleh Fi Store jika ingin info
                                lebih lanjut hubungi WA: <br> +62-123-4567-1234</div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-8 offset-md-4 text-right">
                                <a class="btn btn-primary" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">Log
                                    out
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
