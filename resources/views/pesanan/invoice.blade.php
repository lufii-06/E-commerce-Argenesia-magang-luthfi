<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <style>
        .hr-thick {
            border-top: 4px solid #000;
        }
    </style>
</head>

<body>
    <h3 class="text-center">Invoice</h3>
    <hr class="hr-thick">
    @foreach ($pesanan as $item)
        <table>
            <tr>
                <td  style="width: 15rem">
                    <h5>Nomor Invoice</h5>
                </td>
                <td>: {{ sprintf('%07d', $item->id) }}</td>
            </tr>
            <tr>
                <td>
                    <h5>Nama Penerima</h5>
                </td>
                <td>: {{ $item->name }}</td>
            </tr>
            <tr>
                <td>
                    <h5>Nohp</h5>
                </td>
                <td>: {{ $item->nohp }}</td>
            </tr>
            <tr>
                <td>
                    <h5>Alamat</h5>
                </td>
                <td>: {{ $item->alamat }}</td>
            </tr>
            <tr>
                <td>
                    <h5>Status</h5>
                </td>
                <td>:
                    @if ($item->status == 0)
                        {{ 'Sudah Diterima' }}
                    @elseif ($item->status == 1)
                        {{ 'Sedang Diproses' }}
                    @else
                        {{ 'Sudah Diantar' }}
                    @endif
                </td>
            </tr>
            <tr>
                <td><h5>Pembayaran</h5></td>
                <td>: {{ Str::upper($item->jenispembayaran) }}</td>
            </tr>
        </table>
        <br>
        <h5>Daftar Belanja</h5>
        <table class="w-100">
            <tr class="hr-thick">
                <td>Nama Produk</td>
                <td>Harga Produk</td>
                <td>Qty</td>
                <td>Subtotal</td>
            </tr>
            @foreach ($detailpemesanan[$item->id] as $itemDetail)
                <tr >
                    <td class="pt-2 pb-1">{{ $itemDetail->produk->name }}</td>
                    <td class="pt-2 pb-1">{{ $itemDetail->produk->harga }}</td>
                    <td class="pt-2 pb-1">{{ $itemDetail->qty }}</td>
                    <td class="pt-2 pb-1">{{ $itemDetail->subtotal }}</td>
                </tr>
            @endforeach
            <tr class="hr-thick">
                <td colspan="2">{{ $item->toko->name }}</td>
                <td>Total</td>
                <td>{{ $item->total }}</td>
            </tr>
        </table>
    @endforeach

</body>

</html>
