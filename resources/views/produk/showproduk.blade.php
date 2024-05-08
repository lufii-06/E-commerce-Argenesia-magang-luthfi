@extends('layouts.home')
@section('isi')

    <!-- fashion section start -->
    <div class="fashion_section mt-4" id="fashion_section">
        <div id="main_slider" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="container">
                        <h1 class="fashion_taital" id="fashion_taital">SmartPhone Termahal</h1>
                        <div class="fashion_section_2">
                            <div class="row">
                                @if ($data['smartphonetermahal']->isEmpty())
                                    <h5>Belum ada produk</h5>
                                @else
                                    @foreach ($data['smartphonetermahal'] as $index => $item)
                                        <div class="col-lg-4 col-sm-4">
                                            <div class="box_main">
                                                <h4 class="shirt_text">{{ ucfirst($item->name) }}</h4>
                                                <p class="price_text">Harga <span style="color: #262626;">Rp.
                                                        {{ number_format($item->harga, 0, ',', '.') }}</span></p>
                                                <div class="text-center my-2" style="height: 18rem"><img
                                                        src="{{ asset('storage/photo/' . $item->photo) }}" class="img-fluid"
                                                        style="max-height: 18rem; width: 100%;
                                    height: 100%; object-fit: cover;">
                                                </div>
                                                <h5 class="text-left">{{ $item->toko->name }}</h5>
                                                <h5 class="text-left">sisa stok: {{ $item->stok }}</h5>
                                                @role('pembeli')
                                                    <div class="btn_main">
                                                        <div class="buy_bt"><a
                                                                href="{{ route('pemesananlangsung.create', $item->id) }}"
                                                                class="p-1" style="border:2px solid;border-radius:5px;">Beli
                                                                Sekarang</a>
                                                        </div>
                                                        <div class="seemore_bt"><a
                                                                href="{{ route('produk.detail', $item->id) }}"
                                                                class="text-decoration-underline">Lihat Detail</a></div>
                                                    </div>
                                                @endrole

                                                @guest
                                                    <div class="btn_main">
                                                        <div class="buy_bt"><a
                                                                href="{{ route('pemesananlangsung.create', $item->id) }}"
                                                                class="p-1" style="border:2px solid;border-radius:5px;">Beli
                                                                Sekarang</a>
                                                        </div>
                                                        <div class="seemore_bt"><a
                                                                href="{{ route('produk.detail', $item->id) }}"
                                                                class="text-decoration-underline">Lihat Detail</a></div>
                                                    </div>
                                                @endguest
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="container">
                        <h1 class="fashion_taital">SmartPhone Termurah</h1>
                        <div class="fashion_section_2">
                            <div class="row">
                                @if ($data['smartphonetermurah']->isEmpty())
                                    <h5>Belum ada produk</h5>
                                @else
                                    @foreach ($data['smartphonetermurah'] as $index => $item)
                                        <div class="col-lg-4 col-sm-4">
                                            <div class="box_main">
                                                <h4 class="shirt_text">{{ ucfirst($item->name) }}</h4>
                                                <p class="price_text">Harga <span style="color: #262626;">Rp.
                                                        {{ number_format($item->harga, 0, ',', '.') }}</span></p>
                                                <div class="text-center my-2" style="height: 18rem"><img
                                                        src="{{ asset('storage/photo/' . $item->photo) }}"
                                                        class="img-fluid"
                                                        style="max-height: 18rem; width: 100%;
                                    height: 100%; object-fit: cover;">
                                                </div>
                                                <h5 class="text-left">{{ $item->toko->name }}</h5>
                                                <h5 class="text-left">sisa stok: {{ $item->stok }}</h5>
                                                @role('pembeli')
                                                    <div class="btn_main">
                                                        <div class="buy_bt"><a
                                                                href="{{ route('pemesananlangsung.create', $item->id) }}"
                                                                class="p-1" style="border:2px solid;border-radius:5px;">Beli
                                                                Sekarang</a>
                                                        </div>
                                                        <div class="seemore_bt"><a
                                                                href="{{ route('produk.detail', $item->id) }}"
                                                                class="text-decoration-underline">Lihat Detail</a></div>
                                                    </div>
                                                @endrole
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#main_slider" role="button" data-slide="prev">
                <i class="fa fa-angle-left"></i>
            </a>
            <a class="carousel-control-next" href="#main_slider" role="button" data-slide="next">
                <i class="fa fa-angle-right"></i>
            </a>
        </div>
    </div>
    <!-- fashion section end -->
    <!-- electronic section start -->
    <div class="fashion_section">
        <div id="electronic_main_slider" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="container">
                        <h1 class="fashion_taital">Laptop Termahal</h1>
                        <div class="fashion_section_2">
                            <div class="row">
                                @if ($data['laptoptermahal']->isEmpty())
                                    <h5>Belum ada produk</h5>
                                @else
                                    @foreach ($data['laptoptermahal'] as $index => $item)
                                        <div class="col-lg-4 col-sm-4">
                                            <div class="box_main">
                                                <h4 class="shirt_text">{{ ucfirst($item->name) }}</h4>
                                                <p class="price_text">Harga <span style="color: #262626;">Rp.
                                                        {{ number_format($item->harga, 0, ',', '.') }}</span></p>
                                                <div class="text-center my-2" style="height: 18rem"><img
                                                        src="{{ asset('storage/photo/' . $item->photo) }}"
                                                        class="img-fluid"
                                                        style="max-height: 18rem; width: 100%;
                                    height: 100%; object-fit: cover;">
                                                </div>
                                                <h5 class="text-left">{{ $item->toko->name }}</h5>
                                                <h5 class="text-left">sisa stok: {{ $item->stok }}</h5>
                                                @role('pembeli')
                                                    <div class="btn_main">
                                                        <div class="buy_bt"><a
                                                                href="{{ route('pemesananlangsung.create', $item->id) }}"
                                                                class="p-1"
                                                                style="border:2px solid;border-radius:5px;">Beli
                                                                Sekarang</a>
                                                        </div>
                                                        <div class="seemore_bt"><a
                                                                href="{{ route('produk.detail', $item->id) }}"
                                                                class="text-decoration-underline">Lihat Detail</a></div>
                                                    </div>
                                                @endrole
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="container">
                        <h1 class="fashion_taital">Laptop Termurah</h1>
                        <div class="fashion_section_2">
                            <div class="row">
                                @if ($data['laptoptermurah']->isEmpty())
                                    <h5>Belum ada produk</h5>
                                @else
                                    @foreach ($data['laptoptermurah'] as $index => $item)
                                        <div class="col-lg-4 col-sm-4">
                                            <div class="box_main">
                                                <h4 class="shirt_text">{{ ucfirst($item->name) }}</h4>
                                                <p class="price_text">Harga <span style="color: #262626;">Rp.
                                                        {{ number_format($item->harga, 0, ',', '.') }}</span></p>
                                                <div class="text-center my-2" style="height: 18rem"><img
                                                        src="{{ asset('storage/photo/' . $item->photo) }}"
                                                        class="img-fluid"
                                                        style="max-height: 18rem; width: 100%;
                                                            height: 100%; object-fit: cover;">
                                                </div>
                                                <h5 class="text-left">{{ $item->toko->name }}</h5>
                                                <h5 class="text-left">sisa stok: {{ $item->stok }}</h5>
                                                @role('pembeli')
                                                    <div class="btn_main">
                                                        <div class="buy_bt"><a
                                                                href="{{ route('pemesananlangsung.create', $item->id) }}"
                                                                class="p-1"
                                                                style="border:2px solid;border-radius:5px;">Beli
                                                                Sekarang</a>
                                                        </div>
                                                        <div class="seemore_bt"><a
                                                                href="{{ route('produk.detail', $item->id) }}"
                                                                class="text-decoration-underline">Lihat Detail</a></div>
                                                    </div>
                                                @endrole
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#electronic_main_slider" role="button" data-slide="prev">
                <i class="fa fa-angle-left"></i>
            </a>
            <a class="carousel-control-next" href="#electronic_main_slider" role="button" data-slide="next">
                <i class="fa fa-angle-right"></i>
            </a>
        </div>
    </div>
    <!-- electronic section end -->
    <!-- jewellery  section start -->
    <div class="jewellery_section">
        <div id="jewellery_main_slider" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="container">
                        <h1 class="fashion_taital">Aksesoris Termahal</h1>
                        <div class="fashion_section_2">
                            <div class="row">
                                @if ($data['aksesoristermahal']->isEmpty())
                                    <h5>Belum ada produk</h5>
                                @else
                                    @foreach ($data['aksesoristermahal'] as $index => $item)
                                        <div class="col-lg-4 col-sm-4">
                                            <div class="box_main">
                                                <h4 class="shirt_text">{{ ucfirst($item->name) }}</h4>
                                                <p class="price_text">Harga <span style="color: #262626;">Rp.
                                                        {{ number_format($item->harga, 0, ',', '.') }}</span></p>
                                                <div class="text-center my-2" style="height: 18rem"><img
                                                        src="{{ asset('storage/photo/' . $item->photo) }}"
                                                        class="img-fluid"
                                                        style="max-height: 18rem; width: 100%;
                                height: 100%; object-fit: cover;">
                                                </div>
                                                <h5 class="text-left">{{ $item->toko->name }}</h5>
                                                <h5 class="text-left">sisa stok: {{ $item->stok }}</h5>
                                                @role('pembeli')
                                                    <div class="btn_main">
                                                        <div class="buy_bt"><a
                                                                href="{{ route('pemesananlangsung.create', $item->id) }}"
                                                                class="p-1"
                                                                style="border:2px solid;border-radius:5px;">Beli
                                                                Sekarang</a>
                                                        </div>
                                                        <div class="seemore_bt"><a
                                                                href="{{ route('produk.detail', $item->id) }}"
                                                                class="text-decoration-underline">Lihat Detail</a></div>
                                                    </div>
                                                @endrole
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="container">
                        <h1 class="fashion_taital">Aksesoris Termurah</h1>
                        <div class="fashion_section_2">
                            <div class="row">
                                @if ($data['aksesoristermurah']->isEmpty())
                                    <h5>Belum ada produk</h5>
                                @else
                                    @foreach ($data['aksesoristermurah'] as $index => $item)
                                        <div class="col-lg-4 col-sm-4">
                                            <div class="box_main">
                                                <h4 class="shirt_text">{{ ucfirst($item->name) }}</h4>
                                                <p class="price_text">Harga <span style="color: #262626;">Rp.
                                                        {{ number_format($item->harga, 0, ',', '.') }}</span></p>
                                                <div class="text-center my-2" style="height: 18rem"><img
                                                        src="{{ asset('storage/photo/' . $item->photo) }}"
                                                        class="img-fluid"
                                                        style="max-height: 18rem; width: 100%;
                                height: 100%; object-fit: cover;">
                                                </div>
                                                <h5 class="text-left">{{ $item->toko->name }}</h5>
                                                <h5 class="text-left">sisa stok: {{ $item->stok }}</h5>
                                                @role('pembeli')
                                                    <div class="btn_main">
                                                        <div class="buy_bt"><a
                                                                href="{{ route('pemesananlangsung.create', $item->id) }}"
                                                                class="p-1"
                                                                style="border:2px solid;border-radius:5px;">Beli
                                                                Sekarang</a>
                                                        </div>
                                                        <div class="seemore_bt"><a
                                                                href="{{ route('produk.detail', $item->id) }}"
                                                                class="text-decoration-underline">Lihat Detail</a></div>
                                                    </div>
                                                @endrole
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#jewellery_main_slider" role="button" data-slide="prev">
                <i class="fa fa-angle-left"></i>
            </a>
            <a class="carousel-control-next" href="#jewellery_main_slider" role="button" data-slide="next">
                <i class="fa fa-angle-right"></i>
            </a>
            <div class="loader_main">
                <div class="loader"></div>
            </div>
        </div>
    </div>
    <!-- jewellery  section end -->
@endsection
