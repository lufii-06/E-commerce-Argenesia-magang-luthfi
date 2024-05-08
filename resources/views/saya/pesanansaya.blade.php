@extends('layouts.home')
@section('isi')

    <head>
        <style>
            .btn-pesan {
                text-align: center;
                border: 2px solid;
                border-radius: 5px;
                background-color: white;
                color: black;
            }

            .btn-pesan:hover {
                color: orangered;
                border-color: orangered;
            }
        </style>
    </head>
    <div class="fashion_section" id="fashion_section">
        <div class="container p-5">
            <div class="card-header mt-5" id="daftartoko">
                <h3 class="">Pesanan saya</h3>
                <!-- Cek apakah ada pesan error -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            {{ $error }} <br>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="card-body">
                <form id='formpesan'
                    action="{{ isset($isikeranjang) ? route('pesandarikeranjang.store', $isikeranjang->count()) : route('pemesananlangsung.store', $produk->id) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (session('failed'))
                        <div class="alert alert-danger">
                            {{ session('failed') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card  shadow p-5">
                                <h4>Pesanan</h4>
                                <table class="table">
                                    <tr>
                                        <td>Nama</td>
                                        <td><input type="text" class="form-control" placeholder="Masukan nama penerima"
                                                name="nama">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nohp</td>
                                        <td>
                                            <input type="tel" class="form-control" id="phone" name="nohp"
                                                oninput="keepPrefix(event)" placeholder="nomor telepon"
                                                pattern="\+62-[0-9]{3}-[0-9]{4}-[0-9]{4}" required>
                                            <small class="form-text text-muted">
                                                Contoh format yang disarankan: <br> +62-812-1234-5678
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td><input type="text" class="form-control" placeholder="Alamat Lengkap"
                                                name="alamat"></td>
                                    </tr>
                                    <tr>
                                        <input type="hidden" name="totalpesanlangsung" id="totalpesanlangsung">
                                        <td class="ml-5">Total Pesanan</td>
                                        <td id="total">
                                            @if (isset($isikeranjang) && count($isikeranjang) > 0)
                                                @php
                                                    $subtotal = [];
                                                @endphp
                                                
                                                @foreach ($isikeranjang as $item)
                                                    @php
                                                        $subtotal[] = $item->produk->harga * $item->qty;
                                                    @endphp
                                                @endforeach
                                                {{ 'Rp. ' . number_format(array_sum($subtotal), 0, ',', '.') }}
                                                <input type="hidden" value="{{ array_sum($subtotal) }}" name="total">
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Toko</td>
                                        <td>
                                            {{ ($produk->toko->name ?? $item->produk->toko->name) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pembayaran</td>
                                        <td>
                                            <select name="pembayaran" id="pembayaran" class="form-control" onchange="toggleFileInput(this)">
                                                <option value="" disabled selected>Pilih</option>
                                                <option value="cod">COD</option>
                                                <option value="bank">BANK</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <!-- Baris untuk bukti pembayaran -->
                                    <tr id="rek-bank" style="display: none;"> <!-- Sembunyikan awal -->
                                        <td>{{ $produk->toko->jenisrekening ?? $item->produk->toko->jenisrekening }}</td>
                                        <td><input type="text" readonly class="form-control" value="{{ $produk->toko->norek ?? $item->produk->toko->norek }}"></td>
                                    </tr>

                                    <tr id="bukti-pembayaran-row" style="display: none;"> <!-- Sembunyikan awal -->
                                        <td>Bukti Pembayaran</td>
                                        <td><input type="file" class="form-control" id="buktipembayaran" name="buktipembayaran"></td>
                                    </tr>
                                </table>
                                <button type="submit" class="btn-pesan p-1">Pesan</button>
                            </div>
                        </div>
                        <div style="max-height:32rem;" class="col-md-6 overflow-auto">

                            @if (isset($isikeranjang) && count($isikeranjang) > 0)
                                @foreach ($isikeranjang as $item)
                                    <input type="hidden" value="{{ $item->produk->toko->id }}" name="toko_id">
                                    <input type="hidden" value="{{ $item->id }}" name="id_{{ $loop->iteration }}">
                                    <input type="hidden" value="{{ $item->produk->harga * $item->qty }}"
                                        name="subtotal_{{ $loop->iteration }}">
                                    <input type="hidden" value="{{ $item->produk->id }}"
                                        name="idproduk_{{ $loop->iteration }}">
                                    <input type="hidden" value="{{ $item->qty }}" name="qty_{{ $loop->iteration }}">
                                    <div class="card mb-3 shadow ">
                                        <div class="card-body ">
                                            <h5 class="card-title">{{ $item->produk->name }}</h5>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="image-container"
                                                        style="position: relative; overflow: hidden; max-width: 200px; max-height: 200px;">
                                                        <!-- Membatasi gambar hingga lebar maksimal 200px dan tinggi maksimal 200px -->
                                                        <img src="{{ asset('storage/photo/' . $item->produk->photo) }}"
                                                            alt="Gambar Produk" class="img-fluid"
                                                            style="width: 100%; height: auto; object-fit: contain;">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <p class="card-text">Deskripsi produk : {{ $item->produk->Deskripsi }}
                                                    </p>
                                                    <p>Quantity : {{ $item->qty }}</p>
                                                    <p>harga :
                                                        {{ 'Rp. ' . number_format($item->produk->harga, 0, ',', '.') }}
                                                    </p>
                                                    <p>Subtotal
                                                        :{{ 'Rp. ' . number_format($item->produk->harga * $item->qty, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                    @endphp
                                @endforeach
                            @else
                                <input type="hidden" value="{{ $produk->id }}" name="produk_id">
                                <input type="hidden" value="{{ $produk->toko->id }}" name="toko_id">
                                <div class="card mb-3 shadow ">
                                    <div class="card-body ">
                                        <h5 class="card-title">{{ $produk->name }}</h5>
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="image-container"
                                                    style="position: relative; overflow: hidden; max-width: 200px; max-height: 200px;">
                                                    <!-- Membatasi gambar hingga lebar maksimal 200px dan tinggi maksimal 200px -->
                                                    <img src="{{ asset('storage/photo/' . $produk->photo) }}"
                                                        alt="Gambar Produk" class="img-fluid"
                                                        style="width: 100%; height: auto; object-fit: contain;">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <p class="card-text">Deskripsi produk : {{ $produk->Deskripsi }}
                                                </p>
                                                <p>Harga :
                                                    {{ 'Rp. ' . number_format($produk->harga, 0, ',', '.') }}
                                                </p>
                                                <div class="row">
                                                    <div class="col-5    mt-1 text-right">
                                                        Quantity
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="hidden" id="harga" value="{{ $produk->harga }}">
                                                        <input type="number" id="qty" value="1"
                                                            class="form-control" name="qty"
                                                            onchange="hitungtotal('{{ $produk->harga }}')">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function keepPrefix(event) {
            const input = event.target;
            if (!input.value.startsWith("+62")) {
                input.value = "+62"; // Memastikan prefiks tetap
            }
            // Mengatur posisi kursor ke akhir teks
            setTimeout(() => {
                input.selectionStart = input.selectionEnd = input.value.length;
            }, 0);
        }

        document.addEventListener('DOMContentLoaded', function() {
            var harga = document.getElementById('harga')
            hitungtotal(harga.value); // Panggil fungsi ketika halaman dimuat
        });

        function hitungtotal(harga) {
            var totalpesanlangsung = document.getElementById('totalpesanlangsung');
            var hargaproduk = harga;
            var qty = document.getElementById('qty');
            var total = document.getElementById('total');

            // Menghitung total harga
            var totalHarga = hargaproduk * parseFloat(qty.value);

            // Membuat formatter untuk mata uang rupiah
            var formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            });
            // Menggunakan formatter untuk mengubah total harga ke format mata uang rupiah
            total.innerText = formatter.format(totalHarga);
            totalpesanlangsung.value = totalHarga;
        }

        function toggleFileInput(selectElement) {
            const fileRow = document.getElementById('bukti-pembayaran-row');
            const fileRow1 = document.getElementById('rek-bank');
            if (selectElement.value === 'bank') {
                fileRow.style.display = 'table-row'; // Menampilkan baris jika "BANK" dipilih
                fileRow1.style.display = 'table-row'; // Menampilkan baris jika "BANK" dipilih
            } else {
                fileRow.style.display = 'none'; // Menyembunyikan baris jika "COD" atau lainnya
                fileRow1.style.display = 'none'; // Menyembunyikan baris jika "COD" atau lainnya
            }
        }
    </script>
@endsection
