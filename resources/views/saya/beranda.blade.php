@extends('layouts.home')
@section('isi')
    <div class="fashion_section" id="fashion_section">
        <div class="container p-5">
            <div class="card-header">
                <h3 class="">Info</h3>
            </div>
            <div class="card-body">
                <div class="row no-gutters">
                    <div class="col-12 col-md-6 col-lg-3 mb-2">
                        <div class="card mx-2">
                            <div class="card-body">
                                <h5 class="card-title">Jumlah Pengguna</h5>
                                <h5 class="">{{ $jmluser }} Pengguna</h5>
                                <a href="{{ Route('beranda.index') }}" class="btn btn-dark">Detail</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-6 col-lg-3 mb-2">
                        <div class="card mx-2">
                            <div class="card-body">
                                <h5 class="card-title">Jumlah Toko</h5>
                                <h5 class="">{{ $jmltoko }} Toko aktif saat ini</h5>
                                <a href="{{ Route('beranda.daftartoko') }}" class="btn btn-dark">Detail</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 mb-2">
                        <div class="card mx-2">
                            <div class="card-body">
                                <h5 class="card-title">Jumlah Produk</h5>
                                <h5 class="">{{ $jmlproduk }} Produk terdaftar</h5>
                                <a href="{{ Route('beranda.daftarproduk') }}" class="btn btn-dark">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @yield('daftar')
    </div>
@endsection
