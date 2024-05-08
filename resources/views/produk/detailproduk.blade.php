@extends('layouts.home')
@section('isi')

    <head>
        <style>
            .content-overflow {
                position: relative;
                /* Atur posisi relatif */
                width: 150%;
                /* Atur lebar elemen lebih besar dari kolom parent */
                left: -25%;
                /* Pusatkan konten agar melewati batas kolom */
            }

            .btn-pesan {
                width: 6rem;
                height: 2rem;
                text-align: center;
                border: 2px solid;
                border-radius: 5px;
                background-color: white;
                color: orangered;
                margin-bottom: -15rem
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

            .btn-pesan:hover {
                color: black;
                border-color: black;
            }
        </style>
    </head>
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
                    <div class="col-4">
                        <div class="mt-5">
                            <h3>{{ ucfirst($produk->name) }}</h3>
                            <h5>Rp.{{ number_format($produk->harga, 0, ',', '.') }}</h5>
                            <h5>Stok saat ini :{{ $produk->stok }}</h5>
                            @guest
                                <a href="{{ route('login') }}" class="p-1 btn-pesan"
                                    style="border: 2px solid; border-radius: 5px;">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> Keranjang
                                </a>
                               
                            @else
                                @if (Auth::user()->hasRole('pembeli'))
                                    @if ($data['isikeranjang'])
                                        <form action="{{ route('update.keranjang', $data['isikeranjang']->id) }}" id="myForm"
                                            class="mb-3" method="post">
                                            @csrf
                                            <input id="qty" value="1" max="{{ $produk->stok }}" min="1"
                                                type="number" name="qty" class="btn-pesan p-1">
                                            <button type="submit" class="btn-pesan"><i class="fa fa-shopping-cart"
                                                    aria-hidden="true"></i>Tambah</button>
                                        </form>
                                        <a href="{{ route('delete.keranjang', $produk->id) }}" class="p-1 btn-pesan"
                                            style="border: 2px solid; border-radius: 5px;">
                                            <i class="fa fa-shopping-cart" aria-hidden="true"></i> Hapus Dari keranjang
                                        </a>
                                    @else
                                        <a href="{{ route('create.keranjang', $produk->id) }}" class="p-1 btn-pesan"
                                            style="border: 2px solid; border-radius: 5px;">
                                            <i class="fa fa-shopping-cart" aria-hidden="true"></i> keranjang
                                        </a>
                                    @endif
                                    <a href="javascript:history.back()" class="btn-pesan ml-1 p-1 px-2">Kembali</a>
                                @endif
                            @endguest
                        </div>
                    </div>
                    <div class="col-3 pt-5" style="font-size: 12pt;">
                        {{ $produk->toko->name }}
                        <a href="{{ route('toko.detail', $produk->toko->id) }}" class=" p-1 btn-pesan mx-2"
                            style="border: 2px solid; border-radius: 5px;">
                            Kunjungi Toko
                        </a>
                    </div>
                </div>
                <h4>{{ $produk->name }}</h4>
                <h5>{{ $produk->deskripsi }}

                </h5>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                iziToast.error({
                    title: '',
                    position: 'topRight',
                    message: '{{ $error }}',
                });
            </script>
        @endforeach
    @endif
    @if (session()->get('success'))
        <script>
            iziToast.success({
                title: '',
                position: 'bottomRight',
                message: '{{ session()->get('success') }}',
            });
        </script>
    @endif

    @if (session()->get('error'))
        <script>
            iziToast.error({
                title: '',
                position: 'topRight',
                message: '{{ session()->get('error') }}',
            });
        </script>
    @endif

    <script>
        function submitForm() {
            document.getElementById('myForm').submit(); // Mengirim formulir dengan ID 'myForm'
        }
    </script>
@endsection
