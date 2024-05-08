@extends('layouts.home')
@section('isi')
    <div class="fashion_section" id="fashion_section">
        <div class="container p-5">
            <div class="card-header mt-5" id="daftartoko">
                <h3 class="">Keranjang saya</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('pemesanan.create', $keranjang->total()) }}" method="POST" id="formcheckout">
                    @csrf
                    @if (session('failed'))
                        <div class="alert alert-danger">
                            {{ session('failed') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th><label for="">Gambar</label></th>
                                <th><label for="">Nama Produk</label></th>
                                <th><label for="">Stok</label></th>
                                <th><label for="">Harga</label></th>
                                <th><label for="">Qty</label></th>
                                <th><label for="">Subtotal</label></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($keranjangGroupedByToko as $tokoId => $items)
                                <!-- Informasi Nama Toko -->
                                @php
                                    $tokoName = $items->first()->produk->toko->name;
                                @endphp
                                <tr>
                                    <td colspan="7">Nama Toko: {{ $tokoName }}</td>
                                </tr>
                                <!-- Barang di toko -->
                                @foreach ($items as $item)
                                    <tr>
                                        <td>
                                            <input type="checkbox" id="myCheckbox_{{ $item->id }}"
                                                name="checkbox_{{ $item->id }}" value="{{ $item->id }}"
                                                style="transform: scale(1.5);"
                                                onchange="toggleInputDisable('myCheckbox_{{ $item->id }}', 'qty_{{ $item->id }}', 'harga_{{ $item->id }}', 'subtotal_{{ $item->id }}')">
                                            <label for="myCheckbox_{{ $item->id }}">&nbsp;Pilih</label>
                                        </td>
                                        <td><img class="img-fluid"
                                                src="{{ asset('storage/photo/' . $item->produk->photo) }}"
                                                alt="Gambar Produk" style="height: 5rem"></td>
                                        <td>{{ $item->produk->name }}</td>
                                        <td>Sisa Stok: <div class="stok_{{ $item->id }}" id="stok_{{ $item->id }}"
                                                name>{{ $item->produk->stok }}</div>
                                        </td>
                                        <td>
                                            <input type="hidden" value="{{ $item->produk->harga }}"
                                                id="harga_{{ $item->id }}">
                                            {{ 'Rp. ' . number_format($item->produk->harga, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" min="0"
                                                value="{{ $item->qty }}" max="{{ $item->produk->stok }}"
                                                id="qty_{{ $item->id }}" name="qty_{{ $item->id }}"
                                                data-cart-id="{{ $item->id }}"
                                                onchange="calculateSubtotal('qty_{{ $item->id }}','harga_{{ $item->id }}','subtotal_{{ $item->id }}');">
                                        </td>
                                        <td>
                                            <input type="text" name="subtotal_{{ $item->id }}" class="form-control"
                                                readonly id="subtotal_{{ $item->id }}">
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                            <tr>
                                <td colspan="4"></td>
                                <td colspan="2">Total  Harga Semua Keranjang</td>
                                <td><input type="text" name="total" class="form-control" readonly id="total"></td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td colspan="2">Total Pesanan saat ini</td>
                                <td><input type="text" name="total" class="form-control" readonly id="totalsaatini">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="float-right mr-2">
                        <div class="btn_main">
                            <div class="buy_bt"><a href="#" class="p-1"
                                    onclick="document.getElementById('formcheckout').submit(); return false;"
                                    style="border:2px solid;border-radius:5px;">Checkout</a>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function toggleSelectAll(masterCheckbox) {
            // Menemukan semua checkbox dengan nama yang dimulai dengan 'checkbox_'
            var checkboxes = document.querySelectorAll("input[name^='checkbox_']");
            // Mengatur status semua checkbox berdasarkan status master checkbox
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = masterCheckbox.checked;
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Hitung semua subtotal dan kemudian total
            document.querySelectorAll("input[id^='qty_']").forEach(function(qtyInput) {
                var inputId = qtyInput.id;
                var idSuffix = inputId.split('_')[1];
                var hargaId = "harga_" + idSuffix;
                var subtotalId = "subtotal_" + idSuffix;

                // Hitung subtotal
                calculateSubtotal(inputId, hargaId, subtotalId);
            });

            // Hitung total setelah menghitung semua subtotal
            calculateAllTotal();
        });

        // Menambahkan event listener ke semua input 'qty' untuk menghitung ulang total
        document.querySelectorAll("input[id^='qty_']").forEach(function(qtyInput) {
            qtyInput.addEventListener("input", function() {
                var inputId = qtyInput.id;
                var idSuffix = inputId.split('_')[1];
                var hargaId = "harga_" + idSuffix;
                var subtotalId = "subtotal_" + idSuffix;

                // Hitung subtotal saat kuantitas berubah
                calculateSubtotal(inputId, hargaId, subtotalId);

                // Setelah menghitung subtotal, hitung total
                calculateAllTotal();

                // Periksa stok dan pastikan kuantitas tidak melebihi stok
                var stokId = "stok_" + idSuffix;
                var stokSpan = document.getElementById(stokId);
                if (stokSpan) {
                    var stokTersedia = parseInt(stokSpan.innerText);
                    if (parseInt(qtyInput.value) > stokTersedia) {
                        qtyInput.value = stokTersedia;
                        alert("Qty melebihi stok");
                    }
                }
            });
        });

        // Fungsi untuk menghitung subtotal berdasarkan kuantitas dan harga
        function calculateSubtotal(inputId, hargaId, subtotalId) {
            var qtyInput = document.getElementById(inputId); // Ambil input qty
            var harga = document.getElementById(hargaId); // Ambil harga produk
            var subtotal = document.getElementById(subtotalId); // Ambil field subtotal

            if (qtyInput && harga && subtotal) {
                // Hitung subtotal sebagai harga * qty
                var qty = parseInt(qtyInput.value) || 0; // Jika kosong atau NaN, set ke 0
                var hargaProduk = parseFloat(harga.value); // Ambil harga produk

                // Hitung subtotal dalam format angka
                var total = qty * hargaProduk;

                // Format sebagai mata uang Rupiah (IDR)
                var formatter = new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR",
                    minimumFractionDigits: 0 // Jumlah digit desimal
                });
                // Set nilai subtotal dengan format Rupiah
                subtotal.value = formatter.format(total); // Format ke Rupiah
            } else {
                console.warn("Gagal menghitung subtotal. Salah satu elemen tidak ditemukan.");
            }

            calculateTotal();   
        }

        // Fungsi untuk menghitung total harga berdasarkan semua subtotal
        function calculateAllTotal() {
            // Temukan semua elemen subtotal yang memiliki ID yang dimulai dengan 'subtotal_'
            var subtotalElements = document.querySelectorAll("input[id^='subtotal_']");
            var total = 0; // Inisialisasi total
            // Loop melalui semua elemen subtotal dan tambahkan ke total
            subtotalElements.forEach(function(subtotalElement) {
                // Ambil nilai dari elemen subtotal dan konversi ke angka
                var subtotalValue = subtotalElement.value.replace(/[^\d,]/g,
                    ''); // Hapus karakter selain angka dan koma
                var subtotalNumber = parseFloat(subtotalValue.replace(',',
                    '.')); // Ganti koma dengan titik lalu ubah ke angka
                if (!isNaN(subtotalNumber)) {
                    total += subtotalNumber; // Tambahkan ke total
                }
            });
            // Temukan elemen untuk menampilkan total
            var totalElement = document.getElementById("total"); // Asumsikan elemen dengan ID 'total'
            if (totalElement) {
                // Format total sebagai mata uang Rupiah (IDR)
                var formatter = new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR",
                    minimumFractionDigits: 0
                });

                totalElement.value = formatter.format(total); // Set total dengan format Rupiah
            } else {
                console.warn("Elemen total tidak ditemukan.");
            }
        }

        // Fungsi untuk mengaktifkan/menghentikan input dan mengatur subtotal
        function toggleInputDisable(checkboxId, inputId, hargaId, subtotalId) {
            var checkbox = document.getElementById(checkboxId);
            var input = document.getElementById(inputId);
            var harga = document.getElementById(hargaId);
            var subtotal = document.getElementById(subtotalId);

            if (checkbox) {
                if (checkbox.checked) {
                    if (subtotal) {}
                } else {
                    if (subtotal) {
                        subtotal.value = input.value * harga.value;
                    }
                }
            } else {
                console.warn("Checkbox dengan ID " + checkboxId + " tidak ditemukan.");
            }
        }

        // Fungsi untuk menghitung total harga berdasarkan subtotal dari item yang dicentang
        function calculateTotal() {
            var total = 0; // Inisialisasi total

            // Temukan semua checkbox dan elemen subtotal
            var checkboxes = document.querySelectorAll("input[id^='myCheckbox_']");
            var subtotalElements = document.querySelectorAll("input[id^='subtotal_']");

            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) { // Jika checkbox dicentang
                    var checkboxId = checkbox.id;
                    var idSuffix = checkboxId.split('_')[1];
                    var subtotalId = "subtotal_" + idSuffix; // ID dari subtotal terkait
                    var subtotalElement = document.getElementById(subtotalId);

                    if (subtotalElement) {
                        var subtotalValue = subtotalElement.value.replace(/[^\d,]/g, '');
                        var subtotalNumber = parseFloat(subtotalValue.replace(',', '.'));

                        if (!isNaN(subtotalNumber)) {
                            total += subtotalNumber; // Tambahkan ke total hanya jika dicentang
                        }
                    } else {
                        console.warn("Subtotal dengan ID " + subtotalId + " tidak ditemukan.");
                    }
                }
            });

            var totalElement = document.getElementById("totalsaatini"); // Elemen untuk menampilkan total yang dicentang
            if (totalElement) {
                var formatter = new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR",
                    minimumFractionDigits: 0
                });

                totalElement.value = formatter.format(total); // Format sebagai Rupiah
            } else {
                console.warn("Elemen total saat ini tidak ditemukan.");
            }
        }

        // Event listener untuk mengubah total saat checkbox dicentang/dibatalkan
        document.querySelectorAll("input[id^='myCheckbox_']").forEach(function(checkbox) {
            checkbox.addEventListener("change", function() {
                calculateTotal(); // Hitung ulang total saat checkbox berubah
            });
        });

        // Panggil fungsi calculateTotal untuk menginisialisasi nilai total berdasarkan checkbox
        document.addEventListener("DOMContentLoaded", function() {
            calculateTotal();
        });
    </script>
@endsection
