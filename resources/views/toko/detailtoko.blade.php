@extends('layouts.home')
@section('isi')
    <div class="fashion_section" id="fashion_section">
        <div class="container p-5">
            <div class="card-header mt-5" id="daftartoko">
                <h3 class="">{{ $detailtoko->name }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <h5>Deskripsi Toko : {{ $detailtoko->deskripsi }}</h5>
                        @if ($produk->total() > 0)
                            <h5>Total Produk : {{ $produk->total() }}</h5>
                        @endif
                    </div>
                </div>
                <div class="row">
                    @if ($produk->isEmpty())
                        <h5>Belum ada produk</h5>
                    @else
                        @foreach ($produk as $index => $item)
                            <div class="col-lg-4 col-sm-4">
                                <div class="box_main">
                                    <h4 class="shirt_text">{{ ucfirst($item->name) }}</h4>
                                    <p class="price_text">Harga <span style="color: #262626;">Rp.
                                            {{ number_format($item->harga, 0, ',', '.') }}</span></p>
                                    <div class="text-center my-2" style="height: 16rem"><img
                                            src="{{ asset('storage/photo/' . $item->photo) }}" class="img-fluid"
                                            style="max-height: 18rem; width: 100%;
                            height: 100%; object-fit: cover;">
                                    </div>
                                    <h5 class="text-left">sisa stok: {{ $item->stok }}</h5>
                                    @role('pembeli')
                                        <div class="btn_main">
                                            <div class="buy_bt"><a href="{{ route('pemesananlangsung.create', $item->id) }}"
                                                    class="p-1" style="border:2px solid;border-radius:5px;">Beli
                                                    Sekarang</a>
                                            </div>
                                            <div class="seemore_bt"><a href="{{ route('produk.detail', $item->id) }}"
                                                    class="text-decoration-underline">Lihat Detail</a></div>
                                        </div>
                                    @endrole
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                {{ $produk->links() }}
            </div>
        </div>
    </div>
@endsection
