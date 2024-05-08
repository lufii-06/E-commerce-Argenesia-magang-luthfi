@extends('layouts.home')
@section('isi')
    <div class="fashion_section" id="fashion_section">
        <div class="container p-5">
            <h3>
                @if (!empty($kategori))
                {{ $kategori }}Produk
                @endif 
            </h3>
            <div class="row">
                @if (Empty($produk))
                    <h5>Belum ada produk</h5>
                @else
                    @foreach ($produk as $index => $item)
                        <div class="col-lg-4 col-sm-4">
                            <div class="box_main">
                                @if (isset($terbaru))
                                <h5 class="text-left">Tanggal Rilis : <br> {{ $item->created_at->format('d F Y, H:i') }}</h5>
                                @elseif(isset($terpopuler))
                                <h5 class="text-left">Laku Terjual : {{ $item->total_qty }}</h5>
                                @endif
                                <h4 class="shirt_text">{{ ucfirst($item->name) }}</h4>
                                <p class="price_text">Harga <span style="color: #262626;">Rp.
                                        {{ number_format($item->harga, 0, ',', '.') }}</span></p>
                                <div class="text-center my-2" style="height: 16rem"><img
                                        src="{{ asset('storage/photo/' . $item->photo) }}" class="img-fluid"
                                        style="max-height: 18rem; width: 100%;
                            height: 100%; object-fit: cover;">
                                </div>
                                <h5 class="text-left">{{ $item->toko->name }}</h5>
                                
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
@endsection
