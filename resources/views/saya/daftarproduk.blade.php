@extends('saya.beranda')
@section('daftar')
    <div class="card-header mt-5" id="daftartoko">
        <h3 class="">Daftar Produk</h3>
    </div>
    <div class="card-body">
        <table class="table table-striped table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Nomor</th>
                    <th>Nama produk</th>
                    <th>Asal Toko</th>
                    <th>Harga</th>
                    <th>stok</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produk as $index => $item)
                    <tr>
                        <td>{{ $index + $produk->firstItem() }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->toko->name }}</td>
                        <td>{{ $item->harga }}</td>
                        <td>{{ $item->stok }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="">
            {{ $produk->links() }}
        </div>
    </div>
    </div>
@endsection
