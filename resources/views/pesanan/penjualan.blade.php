@extends('layouts.home')
@section('isi')

    <head>
        <style>
            details {
                background: #f8f9fa;
                /* Bootstrap light background color */
                padding: 10px;
                /* Bootstrap border color */
                border-radius: 4px;
                /* Slightly rounded corners */
            }

            summary {
                font-weight: bold;
                /* Make the summary text bold */
                cursor: pointer;
                /* Change cursor to pointer on hover */
            }

            .btn-pesan {
                text-align: center;
                border: 2px solid;
                border-radius: 5px;
                background-color: white;
                color: orangered;
                padding: 0.15rem;
                margin-top: -5px
            }

            .btn-pesan:hover {
                color: black;
                border-color: black;
            }

            .nav-link.button-style {
                background-color: black;
                /* Border dengan warna yang sama */
                color: white;
                transition: background-color 0.3s, color 0.3s;
                /* Transisi lembut */
                border-radius: 10px;
                margin: 2px;
            }

            /* Efek hover */
            .nav-link.button-style:hover {
                background-color: orangered;
            }

            /* Mengubah warna saat tab aktif */
            .nav-link.active.button-style {
                background-color: orangered;
                /* Warna biru gelap saat aktif */
                border-color: orangered;
                /* Border lebih gelap */
            }

            /* Cegah body dari perubahan lebar */
            body.modal-open {
                padding-right: 0 !important;
            }
        </style>
    </head>

    <div class="fashion_section" id="fashion_section">
        <div class="container p-5">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active button-style text-white" id="home-tab" data-toggle="tab" href="#pesanan"
                        role="tab" aria-controls="home" aria-selected="true">Pesanan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link button-style text-white" id="help-tab" data-toggle="tab" href="#dikirim"
                        role="tab" aria-controls="help" aria-selected="false">Sedang Dikirim</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link button-style text-white" id="about-tab" data-toggle="tab" href="#riwayat"
                        role="tab" aria-controls="about" aria-selected="false">Riwayat Penjualan</a>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="pesanan" role="tabpanel" aria-labelledby="home-tab">
                    <div class="card-header">
                    </div>
                    <div class="card-body ">
                        <h2>Pesanan</h2>
                        @foreach ($pesanan as $item)
                            <details open>
                                <summary>Tanggal: {{ $item->tanggal }} &nbsp; | &nbsp; Total
                                    Belanja:&nbsp;&nbsp;{{ 'Rp.' . number_format($item->total, 0, ',', '.') }}
                                    <a href="#" class="btn-pesan float-right" data-toggle="modal"
                                        data-target="#exampleModal{{ $item->id }}">Lihat Invoice</a>

                                </summary>
                                <ul>
                                    @foreach ($detailpemesanan[$item->id] as $itemdetail)
                                        <li class="d-flex align-items-center">
                                            <figure class="m-0">
                                                <img src="{{ asset('/storage/photo/' . $itemdetail->produk->photo) }}"
                                                    class="img-fluid"
                                                    style="max-height: 5rem; min-height: 5rem; max-width:5rem;"
                                                    alt="Produk">
                                                <figcaption class="text-muted small">
                                                    {{ 'Rp.' . number_format($itemdetail->produk->harga, 0, ',', '.') }}
                                                </figcaption>
                                            </figure>
                                            <div class="ml-5">
                                                {{ $itemdetail->qty }}&nbsp;Item&nbsp;{{ $itemdetail->produk->name }}
                                                <br>Subtotal &nbsp;
                                                {{ 'Rp.' . number_format($itemdetail->subtotal, 0, ',', '.') }}
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </details>
                        @endforeach
                    </div>

                    @foreach ($pesanan as $item)
                        <form action="{{ route('pesanan.antar', $item->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content" id="invoicepemesanan">
                                        <div class="modal-header d-flex justify-content-center">
                                            <h5 class="modal-title" id="exampleModalLabel"><b>Invoice</b></h5>
                                            <button type="button" class="close mr-2 no-print" data-dismiss="modal"
                                                aria-label="Close" style="position: absolute; right: 10px;">
                                                <span aria-hidden="true" class="no-print">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        {{ 'Nomor Invoice : ' . sprintf('%07d', $item->id) }}</div>
                                                    <div class="col-md-12">{{ 'Nama Penerima : ' . $item->name }}</div>
                                                    <div class="col-md-12">{{ 'Nohp : ' . $item->nohp }}</div>
                                                    <div class="col-md-12">{{ 'Alamat : ' . $item->alamat }}</div>
                                                    <div class="col-md-12">Status pemesanan :
                                                        @if ($item->status == 0)
                                                            {{ 'Sudah Diterima' }}
                                                        @elseif ($item->status == 1)
                                                            {{ 'Sedang Diproses' }}
                                                        @else
                                                            {{ 'Sudah Diantar' }}
                                                        @endif
                                                    </div>
                                                    <div class="col-md-12">
                                                        {{ 'Jenis Pembayaran : ' . Str::upper($item->jenispembayaran) }}
                                                    </div>
                                                    <div class="col-md-12 mt-3">
                                                        <h5>Daftar belanja</h5>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    @foreach ($detailpemesanan[$item->id] as $itemdetail)
                                                        <div class="col-md-4">Nama Produk : {{ $itemdetail->produk->name }}
                                                        </div>
                                                        <div class="col-md-3">Harga :
                                                            {{ 'Rp.' . number_format($itemdetail->produk->harga, 0, ',', '.') }}
                                                        </div>
                                                        <div class="col-md-2">Qty : {{ $itemdetail->qty }}</div>
                                                        <div class="col-md-3">Subtotal :
                                                            {{ 'Rp.' . number_format($itemdetail->subtotal, 0, ',', '.') }}
                                                        </div>
                                                        <div class="col-md-3">
                                                            Total {{ 'Rp.' . number_format($item->total, 0, ',', '.') }}
                                                        </div>
                                                        <hr>
                                                    @endforeach
                                                    <div class="col-md-9">
                                                        {{ $item->toko->name }}
                                                        <br>
                                                        <div class="border-top border-dark w-25 mt-5"></div>
                                                    </div>
                                                    <div class="col-md-3 ">
                                                        <div class="font-weight-bold">
                                                            Total :
                                                            {{ 'Rp.' . number_format($item->total, 0, ',', '.') }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer d-flex justify-content-between">
                                            <div class="">
                                                @if ($item->jenispembayaran === 'bank')
                                                    <button class="btn-pesan py-1" type="button" data-toggle="modal"
                                                        data-target="#imageModal{{ $item->id }}">
                                                        Bukti Pembayaran
                                                    </button>
                                                @endif
                                                <button type="submit" class="btn-pesan py-1">Antar Pesanan</button>
                                            </div>
                                            <div class="">
                                                <a href="{{ route('cetak.pesanan', $item->id) }}" target="_blank"
                                                    class="btn-pesan float-right mr-1">Download Invoice</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- HANYA MODAL UNTUK MENAMPILKAN BUKTI PEMESANAN --}}
                            <!-- Modal Baru -->
                            <div class="modal fade" id="imageModal{{ $item->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Bukti Pembayaran</h5>
                                        </div>
                                        <div class="modal-body">
                                            <img src="{{ asset('/storage/photo/' . $item->buktipembayaran) }}"
                                                alt="Bukti Pembayaran" class="img-fluid"
                                                style="max-width: 100%; cursor: pointer;" data-toggle="modal"
                                                data-target="#fullScreenImageModal">
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn-pesan py-1 px-2" type="button" data-toggle="modal"
                                                data-target="#imageModal{{ $item->id }}">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="fullScreenImageModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-fullscreen">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img id="fullScreenImage" src="" alt="Layar penuh"
                                                class="img-fluid" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- END HANYA MODAL UNTUK MENAMPILKAN BUKTI PEMESANAN --}}

                        </form>
                    @endforeach
                </div>

                <div class="tab-pane fade" id="dikirim" role="tabpanel" aria-labelledby="help-tab">
                    <div class="card-header">
                    </div>
                    <div class="card-body ">
                        <h2>Sedang Dikirim</h2>
                        @foreach ($sedangdiantar as $item1)
                            <details open>
                                <summary>Tanggal: {{ $item1->tanggal }} &nbsp; | &nbsp; Total
                                    Belanja:&nbsp;&nbsp;{{ 'Rp.' . number_format($item1->total, 0, ',', '.') }}
                                    <a href="#" class="btn-pesan float-right" data-toggle="modal"
                                        data-target="#exampleModal{{ $item1->id }}">Lihat Invoice</a>
                                </summary>
                                <ul>
                                    @foreach ($detailpesanansedangdiantar[$item1->id] as $itemdetail1)
                                        <li class="d-flex align-items-center">
                                            <figure class="m-0">
                                                <img src="{{ asset('/storage/photo/' . $itemdetail1->produk->photo) }}"
                                                    class="img-fluid"
                                                    style="max-height: 5rem; min-height: 5rem; max-width:5rem;"
                                                    alt="Produk">
                                                <figcaption class="text-muted small">
                                                    {{ 'Rp.' . number_format($itemdetail1->produk->harga, 0, ',', '.') }}
                                                </figcaption>
                                            </figure>
                                            <div class="ml-5">
                                                {{ $itemdetail1->qty }}&nbsp;Item&nbsp;{{ $itemdetail1->produk->name }}
                                                <br>Subtotal &nbsp;
                                                {{ 'Rp.' . number_format($itemdetail1->subtotal, 0, ',', '.') }}
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </details>
                        @endforeach
                    </div>

                    @foreach ($sedangdiantar as $item1)
                        <form action="{{ route('pesanan.selesai', $item1->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal{{ $item1->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content" id="invoicepemesanan">
                                        <div class="modal-header d-flex justify-content-center">
                                            <h5 class="modal-title" id="exampleModalLabel"><b>Invoice</b></h5>
                                            <button type="button" class="close mr-2 no-print" data-dismiss="modal"
                                                aria-label="Close" style="position: absolute; right: 10px;">
                                                <span aria-hidden="true" class="no-print">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        {{ 'Nomor Invoice : ' . sprintf('%07d', $item1->id) }}</div>
                                                    <div class="col-md-12">{{ 'Nama Penerima : ' . $item1->name }}</div>
                                                    <div class="col-md-12">{{ 'Nohp : ' . $item1->nohp }}</div>
                                                    <div class="col-md-12">{{ 'Alamat : ' . $item1->alamat }}</div>
                                                    <div class="col-md-12">Status pemesanan :
                                                        @if ($item1->status == 0)
                                                            {{ 'Sudah Diterima' }}
                                                        @elseif ($item1->status == 1)
                                                            {{ 'Sedang Diproses' }}
                                                        @else
                                                            {{ 'Sudah Diantar' }}
                                                        @endif
                                                    </div>
                                                    <div class="col-md-12">
                                                        {{ 'Jenis Pembayaran : ' . Str::upper($item1->jenispembayaran) }}
                                                    </div>
                                                    <div class="col-md-12 mt-3">
                                                        <h5>Daftar belanja</h5>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    @foreach ($detailpesanansedangdiantar[$item1->id] as $itemdetail1)
                                                        <div class="col-md-4">Nama Produk :
                                                            {{ $itemdetail1->produk->name }}
                                                        </div>
                                                        <div class="col-md-3">Harga :
                                                            {{ 'Rp.' . number_format($itemdetail1->produk->harga, 0, ',', '.') }}
                                                        </div>
                                                        <div class="col-md-2">Qty : {{ $itemdetail1->qty }}</div>
                                                        <div class="col-md-3">Subtotal :
                                                            {{ 'Rp.' . number_format($itemdetail1->subtotal, 0, ',', '.') }}
                                                        </div>
                                                        <hr>
                                                    @endforeach
                                                    <div class="text-right">
                                                        Total : {{ 'Rp.' . number_format($item1->total, 0, ',', '.') }}
                                                    </div>
                                                    <div class="col-md-9">

                                                        {{ $item1->toko->name }}
                                                        <br>
                                                        <div class="border-top border-dark w-25 mt-5"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer d-flex justify-content-between">
                                            <div class="">
                                                @if ($item1->jenispembayaran === 'bank')
                                                    <button class="btn-pesan py-1" type="button" data-toggle="modal"
                                                        data-target="#imageModal{{ $item1->id }}">
                                                        Bukti Pembayaran
                                                    </button>
                                                @endif

                                            </div>
                                            <div class="">
                                                <a href="{{ route('cetak.pesanan', $item1->id) }}" target="_blank"
                                                    class="btn-pesan py-1">Resi Pengiriman</a>
                                                <a href="{{ route('cetak.resipengiriman', $item1->id) }}" target="_blank"
                                                    class="btn-pesan py-1">Download Invoice</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- HANYA MODAL UNTUK MENAMPILKAN BUKTI PEMESANAN --}}
                            <!-- Modal Baru -->
                            <div class="modal fade" id="imageModal{{ $item1->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Bukti Pembayaran</h5>
                                        </div>
                                        <div class="modal-body">
                                            <img src="{{ asset('/storage/photo/' . $item1->buktipembayaran) }}"
                                                alt="Bukti Pembayaran" class="img-fluid"
                                                style="max-width: 100%; cursor: pointer;" data-toggle="modal"
                                                data-target="#fullScreenImageModal1">
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn-pesan py-1 px-2" type="button" data-toggle="modal"
                                                data-target="#imageModal{{ $item1->id }}">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="fullScreenImageModal1" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-fullscreen">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img id="fullScreenImage" src="" alt="Layar penuh"
                                                class="img-fluid" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- END HANYA MODAL UNTUK MENAMPILKAN BUKTI PEMESANAN --}}
                        </form>
                    @endforeach
                </div>

                <div class="tab-pane fade" id="riwayat" role="tabpanel" aria-labelledby="about-tab">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <h2>Penjualan</h2>
                        @php
                            $total = 0;
                        @endphp
                        @foreach ($penjualan as $item2)
                            @php
                                $total += $item2->total;
                            @endphp
                            <details open>
                                <summary>Tanggal: {{ $item2->tanggal }} &nbsp; | &nbsp; Total
                                    Belanja:&nbsp;&nbsp;{{ 'Rp.' . number_format($item2->total, 0, ',', '.') }}
                                    <a href="#" class="btn-pesan float-right" data-toggle="modal"
                                        data-target="#exampleModal1{{ $item2->id }}">Lihat Invoice</a>
                                </summary>
                                <ul>
                                    @foreach ($detailpenjualan[$item2->id] as $itemdetail2)
                                        <li class="d-flex align-items-center">
                                            <figure class="m-0">
                                                <img src="{{ asset('/storage/photo/' . $itemdetail2->produk->photo) }}"
                                                    class="img-fluid"
                                                    style="max-height: 5rem; min-height: 5rem; max-width:5rem;"
                                                    alt="Produk">
                                                <figcaption class="text-muted small">
                                                    {{ 'Rp.' . number_format($itemdetail2->produk->harga, 0, ',', '.') }}
                                                </figcaption>
                                            </figure>
                                            <div class="ml-5">
                                                {{ $itemdetail2->qty }}&nbsp;Item&nbsp;{{ $itemdetail2->produk->name }}
                                                <br>Subtotal &nbsp;
                                                {{ 'Rp.' . number_format($itemdetail2->subtotal, 0, ',', '.') }}
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </details>
                        @endforeach
                        <h5 class="mt-3">Total Penjualan : {{ 'Rp.' . number_format($total, 0, ',', '.') }}</h5>
                    </div>


                    @foreach ($penjualan as $item2)
                        <form action="{{ route('pesanan.selesai', $item2->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal1{{ $item2->id }}" tabindex="-1"
                                aria-labelledby="exampleModal1Label" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header d-flex justify-content-center">
                                            <h5 class="modal-title" id="exampleModal1Label">Invoice</h5>
                                            <button type="button" class="close mr-2" data-dismiss="modal"
                                                aria-label="Close" style="position: absolute; right: 10px;">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        {{ 'Nomor Invoice : ' . sprintf('%07d', $item2->id) }}</div>
                                                    <div class="col-md-12">{{ 'Nama Penerima : ' . $item2->name }}</div>
                                                    <div class="col-md-12">{{ 'Nohp : ' . $item2->nohp }}</div>
                                                    <div class="col-md-12">{{ 'Alamat : ' . $item2->alamat }}</div>
                                                    <div class="col-md-12">Status pemesanan :
                                                        @if ($item2->status == 0)
                                                            {{ 'Sudah Diterima' }}
                                                        @elseif ($item2->status == 1)
                                                            {{ 'Sedang Diproses' }}
                                                        @else
                                                            {{ 'Sudah Diantar' }}
                                                        @endif
                                                    </div>
                                                    <div class="col-md-12">
                                                        {{ 'Jenis Pembayaran : ' . Str::upper($item2->jenispembayaran) }}
                                                    </div>
                                                    <div class="col-md-12 mt-3">
                                                        <h5>Daftar belanja</h5>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    @foreach ($detailpenjualan[$item2->id] as $itemdetail2)
                                                        <div class="col-md-4">Nama Produk :
                                                            {{ $itemdetail2->produk->name }}
                                                        </div>
                                                        <div class="col-md-3">Harga :
                                                            {{ 'Rp.' . number_format($itemdetail2->produk->harga, 0, ',', '.') }}
                                                        </div>
                                                        <div class="col-md-2">Qty : {{ $itemdetail2->qty }}</div>
                                                        <div class="col-md-3">Subtotal :
                                                            {{ 'Rp.' . number_format($itemdetail2->subtotal, 0, ',', '.') }}
                                                        </div>
                                                        <hr>
                                                    @endforeach
                                                    <div class="col-md-9">
                                                        {{ $item2->toko->name }}
                                                        <br>
                                                        {{-- <div class="border-top border-dark w-25 mt-5"></div> --}}
                                                    </div>
                                                    <div class="col-md-3 ">
                                                        <div class="font-weight-bold">
                                                            Total :
                                                            {{ 'Rp.' . number_format($item2->total, 0, ',', '.') }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer d-flex justify-content-end">
                                            <a href="{{ route('cetak.pesanan', $item2->id) }}" target="_blank"
                                                class="btn-pesan py-1">Download Invoice</a>
                                            <a href="{{ route('cetak.resipengiriman', $item2->id) }}" target="_blank"
                                                class="btn-pesan py-1">Resi Pengiriman</a>
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
    <script>
        $(document).ready(function() {
            // Simpan padding-right awal body
            const originalPaddingRight = $('body').css('padding-right');

            // Saat modal dibuka, pastikan padding-right diatur ke 0
            $(document).on('show.bs.modal', function() {
                $('body').css('padding-right', '0');
            });

            // Saat modal ditutup, kembalikan padding-right ke nilai awal
            $(document).on('hidden.bs.modal', function() {
                $('body').css('padding-right', originalPaddingRight);
            });
        });

        // JavaScript untuk mengubah src gambar dalam modal saat gambar diklik
        document.querySelectorAll('img[data-toggle="modal"]').forEach(img => {
            img.addEventListener('click', function() {
                const fullScreenImage = document.getElementById('fullScreenImage');
                fullScreenImage.setAttribute('src', this.getAttribute('src')); // Atur gambar di modal
            });
        });

        $(document).ready(function() {
            var itemId = '{{ isset($item) ? $item->id : '' }}';
            if (itemId) {
                var modalId = 'imageModal' + itemId;

                $('#closeModalButton' + itemId).click(function() {
                    $('#' + modalId).modal('hide'); // Menutup modal jika ID valid
                });
            } else {
                console.error('Item ID tidak ditemukan.'); // Tindakan alternatif jika ID tidak ada
                // Bisa menampilkan pesan ke pengguna atau melakukan tindakan lain
            }
        });
    </script>
@endsection
