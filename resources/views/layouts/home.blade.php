@extends('layouts.app')

@section('content')
    <!-- banner bg main start -->
    <div class="banner_bg_main">
        <!-- header top section start -->
        <div class="container">
            <div class="header_section_top">
                <div class="custom_menu">
                    <div class="row">
                        <div class=" col-9 text-left ml-5">
                            <ul class="">
                                <li><a href="{{ url('/') }}">Beranda</a></li>
                                <li><a href="{{ route('toko.daftar') }}">Toko</a></li>
                                <li><a href="{{ route('produk.show', '0') }}">Produk</a></li>
                                @guest
                                    <li><a href="#footer_section" class="nav-link">Customer Service</a></li>
                                @endguest
                                @auth
                                    @role('admin')
                                        <li class="nav-item">
                                            <a class="" href="{{ url('/beranda') }}">Info</a>
                                        </li>
                                    @elseif(Auth::user()->hasRole('penjual'))
                                        @if ($toko->status == '1')
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ url('daftarproduk') }}">Produk Saya</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('penjualan.show') }}">Pesanan</a>
                                            </li>
                                            {{-- <li class="nav-item">
                                                <a class="nav-link" href="{{ route('penjualan.show') }}">Penjualan</a>
                                            </li> --}}
                                            <li><a href="#footer_section" class="nav-link">Customer Service</a></li>
                                        @else
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">Produk Saya</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">Pesanan</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">Penjualan</a>
                                            </li>
                                            <li><a href="#footer_section" class="nav-link">Customer Service</a></li>
                                        @endif
                                    @else
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ url('pesanansaya') }}">Pesanan</a>
                                        </li>
                                        <li><a href="#footer_section" class="nav-link">Customer Service</a></li>
                                    @endrole
                                @endauth

                            </ul>
                        </div>
                        <div class="col-2">
                            @guest
                                <ul>
                                    <li>
                                        <a href="{{ route('login') }}"
                                            class="text-sm text-gray-700 dark:text-gray-500 underline ">Log in</a>
                                    </li>
                                    @if (Route::has('register'))
                                        <li>
                                            <a href="#registermodal" data-target="#registermodal" data-toggle="modal"
                                                class="text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                                        </li>
                                    @endif
                                </ul>
                            @else
                                <li class="nav-item ">
                                    <a class="" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                                         document.getElementById('logout-form').submit();">Log
                                        out
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- header section start -->

        {{-- modal register --}}

        <div class="modal fade" id="registermodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title " id="exampleModalLabel">Pilih tipe akun</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body ">
                        <h3>Pilih Tipe Akun Yang anda inginkan </h3>
                        <a href="{{ route('register') }}" class="btn btn-dark mr-2">Pelanggan</a>
                        <a href="{{ url('/registerpemiliktoko') }}" class="btn btn-dark">Penjual</a>
                    </div>
                </div>
            </div>
        </div>
        {{-- end modal --}}

        <div class="header_section">
            <div class="container mt-5">
                <div class="containt_main">
                    <div class="dropdown">
                        <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Category
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ route('produk.show', '1') }}">SmartPhone</a>
                            <a class="dropdown-item" href="{{ route('produk.show', '2') }}">Laptop</a>
                            <a class="dropdown-item" href="{{ route('produk.show', '3') }}">Aksesoris</a>
                        </div>
                    </div>
                    <div class="main">
                        <!-- Another variation with a button -->
                        <form action="{{ route('produk.show1') }}" method="get" id="searchForm">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" id="search"
                                    value="{{ request('search') }}" placeholder="Search produk, store or something">
                                <div class="input-group-append">
                                    <span id="clearSearch"
                                        class="input-group-text cursor-pointer {{ request('search') ? '' : 'd-none' }} hover:bg-gray-300">x</span>
                                </div>
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" type="submit"
                                        style="background-color: #f26522; border-color:#f26522 ">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @role('pembeli')
                        <div class="header_box">
                            <div class="lang_box">
                            </div>
                            <div class="login_menu">
                                <ul>
                                    <li>
                                        <a href="{{ route('show.keranjang') }}">
                                            <i class="fa fa-shopping-cart fa-2x" aria-hidden="true"></i>

                                            <span class="badge"
                                                style="background-color: #f26522">{{ $data['jmlkeranjang'] ? $data['jmlkeranjang'] : '' }}</span>
                                            {{-- <span class="badge" style="background-color: #f26522">{{ $data['jmlkeranjang'] }}</span> --}}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endrole
                </div>
            </div>
        </div>
        <!-- header section end -->
        <!-- banner section start -->
        <div class="banner_section layout_padding">
            <div class="container">
                <div id="my_slider" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h5 class="banner_taital text-dark"><small> belanja di fi.Store</small> <br>sekarang
                                    </h5>
                                    <div class="buynow_bt"><a href="#fashion_section">Lihat</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h5 class="banner_taital text-dark">fi.Store <br><small>Daftar Sekarang</small></h5>

                                    <div class="buynow_bt"><a href="#registermodal" data-target="#registermodal"
                                            data-toggle="modal"
                                            class="text-sm text-gray-700 dark:text-gray-500 underline">Daftar</a> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#my_slider" role="button" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a class="carousel-control-next" href="#my_slider" role="button" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- banner section end -->
    </div>
    <!-- banner bg main end -->

    @yield('isi')

    <!-- footer section start -->
    <div class="footer_section layout_padding" id="footer_section">
        <div class="container">
            <div class="input_bt">
                <input type="text" class="mail_bt" placeholder="Your Email" name="Your Email">
                <span class="subscribe_bt" id="basic-addon2"><a href="#">Subscribe</a></span>
            </div>
            <div class="footer_menu">
                <ul>
                    <li><a href="{{ route('produk.popular') }}">Best Sellers</a></li>
                    <li><a href="#">Gift Ideas</a></li>
                    <li><a href="{{ route('produk.new') }}">New Releases</a></li>
                    <li><a href="#">Today's Deals</a></li>
                    <li><a href="#">Customer Service</a></li>
                </ul>
            </div>
            <div class="location_main">Help Line Number : <a href="#">+62 123-1234-1234</a></div>
        </div>
    </div>
    <!-- footer section end -->
    <!-- copyright section start -->
    <div class="copyright_section">
        <div class="container">
            <p class="copyright_text">© 2024 All Rights Reserved.
        </div>
    </div>
    <!-- copyright section end -->
    <script>
        //search
        $(document).ready(function() {
            const searchInput = $('#search');
            const clearSearch = $('#clearSearch');
            let formSubmitted = {{ request()->has('search') ? 'true' : 'false' }};
            if (searchInput.val().trim().length > 0) {
                clearSearch.show();
            }
            searchInput.on('input', function() {
                if ($(this).val().trim().length > 0) {
                    clearSearch.show();
                } else {
                    clearSearch.hide();
                }
            })
            searchInput.keypress(function(e) {
                if (e.which == 13) {
                    e.preventDefault();
                    $('#searchForm').submit();
                }
            });
            clearSearch.click(function() {
                searchInput.val('');
                clearSearch.hide();
                if (formSubmitted) {
                    window.location.href = "{{ route('produk.show1') }}";
                }
            });
        });
    </script>
@endsection
