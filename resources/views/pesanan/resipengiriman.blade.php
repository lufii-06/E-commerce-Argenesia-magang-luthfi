<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Resi Pengiriman</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="text-center my-4"> <!-- resi-header -->
            <h3>Resi Pengiriman</h3>
            <hr class="my-2" style="border-top: 4px solid black;"> <!-- hr-thick -->
        </div>

        @foreach ($pesanan as $item)
            <div class="my-4"> <!-- resi-details -->
                <div class="p-4 border rounded bg-light"> <!-- resi-box -->
                    <h5 class="text-center"> <!-- Kelas text-center pada h5 -->
                        No. Resi Pengiriman: {{ sprintf('%07d', $item->id) }}
                        <br><br>
                        <div style="display: inline-block;">
                            <!-- Gunakan inline-block untuk memastikan tetap di tengah -->
                            {!! DNS1D::getBarcodeHTML(sprintf('%07d', $item->id), 'C39') !!}
                        </div>
                    </h5>
                </div>
                <table class="mt-2" style="width: 34rem;">
                    <tr>
                        <td>Penerima : {{ $item->name }}</td>
                        <td>Pengirim : {{ $item->user->name }}</td>
                    </tr>
                    <tr>
                        <td>Alamat : {{ $item->alamat }}</td>
                        <td>Nohp : {{ $item->nohp }}</td>
                    </tr>
                    <tr class="" style="border-bottom: 4px solid black;">
                        <td class="">Jenis Pembayaran : {{ $item->jenispembayaran }}</td>
                        <td class="text-danger">Penjual Tidak perlu membayar tip ke kurir</td>
                    </tr>

                </table>
                <div class="row">
                </div>
                <p>
                    Berat : xx gr <br>
                    Batar Kirim : {{ $item->created_at->addDays(7)->format('d F Y') }}
                </p>
                <table class="w-100">
                    <tr style="border-top: 2px solid black;">
                        <td>Nama Produk</td>
                        <td>Harga</td>
                        <td>qty</td>
                        <td>subtotal</td>
                    </tr>
                    @foreach ($detailpemesanan[$item->id] as $itemdetail)
                        <tr>
                            <td>{{ $itemdetail->produk->name }}</td>
                            <td>{{ $itemdetail->produk->harga }}</td>
                            <td>{{ $itemdetail->qty }}</td>
                            <td>{{ $itemdetail->subtotal }}</td>
                        </tr>
                    @endforeach
                    <tr style="border-top: 3px solid black;">
                        <td colspan="3">Total</td>
                        <td>{{ $item->total }}</td>
                    </tr>
                </table>
            </div>
        @endforeach

    </div>

</body>

</html>
