@extends('layouts.home')
@section('isi')
    <style>
        .tombol {
            margin-left: -8px;
        }

        /* Mengubah warna panah carousel */
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: black;
            /* Menjadikan panah berwarna hitam */
        }

        /* Mengubah warna panah carousel dengan ikon kustom, misalnya, putih dengan latar belakang hitam */
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            filter: invert(100%);
            /* Membalikkan warna menjadi gelap */
            background-color: rgba(0, 0, 0, 0.5);
            /* Warna gelap dengan sedikit transparansi */
        }

        /* Untuk mengatur ukuran ikon panah */
        .carousel-control-prev-icon {
            width: 30px;
            /* Ukuran kustom */
            height: 30px;
        }

        .carousel-control-next-icon {
            width: 30px;
            height: 30px;
        }

        .btn-pesan {
            width: 6rem;
            height: 2rem;
            text-align: center;
            border: 2px solid;
            border-radius: 5px;
            background-color: white;
            color: black;
            margin-bottom: -15rem
        }

        .btn-pesan:hover {
            color: orangered;
            border-color: orangered;
        }
    </style>
    <div class="fashion_section" id="fashion_section">
        <div class="container p-5">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card-header" id="daftartoko">
            </div>
            <div class="card-body">
                <div class="row mb-5">
                    <div class="col-5">
                        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="{{ asset('storage/photo/' . $produk->photo) }}"
                                        class="d-block img-fluid mx-auto" style="width: 15rem; height: 15rem"
                                        alt="Photo Sampul">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('storage/photo/' . $produk->photo1) }}"
                                        class="d-block img-fluid mx-auto" style="width: 15rem; height: 15rem"
                                        alt="Photo Detail">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('storage/photo/' . $produk->photo2) }}"
                                        class="d-block img-fluid mx-auto" style="width: 15rem; height: 15rem"
                                        alt="Photo Detail">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-target="#carouselExampleFade"
                                data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-target="#carouselExampleFade"
                                data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </button>
                        </div>

                    </div>
                    <div class="col-7">
                        <div class="mt-5">
                            <h3>{{ ucfirst($produk->name) }}</h3>
                            <h5>Rp.{{ number_format($produk->harga, 0, ',', '.') }}</h5>
                            <h5>Stok saat ini :{{ $produk->stok }}</h5>
                        </div>
                    </div>
                </div>
                <h4>{{ $produk->name }}</h4>
                <h5>{{ $produk->deskripsi }}
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nulla atque explicabo minus laborum, quis modi
                    ipsa nobis vel minima quod, magni placeat aperiam, vero dolore sit libero corrupti excepturi nam!
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nulla atque explicabo minus laborum, quis modi
                    ipsa nobis vel minima quod, magni placeat aperiam, vero dolore sit libero corrupti excepturi nam!
                </h5>
                <a href="{{ route('produk.index') }}" class="btn-pesan p-1 px-2 float-right">Kembali</a>
            </div>
        </div>
    </div>
    </div>
@endsection
