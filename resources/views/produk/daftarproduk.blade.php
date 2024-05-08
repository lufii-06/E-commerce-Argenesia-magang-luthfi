@extends('layouts.home')
@section('isi')
<style>
    .tombol{
        margin-left:-8px;
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
                <h3 class="">Daftar Produk</h3>
            </div>
            <div class="card-body">
                <a href="{{ route('produk.create') }}" class="btn btn-dark mb-2">Buat Produk</a>
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nomor</th>
                            <th>Kategori</th>
                            <th>Nama Produk</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th width="100px">Kelola Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($produk->isEmpty())
                            <td colspan="7">Anda Belum Membuat Produk</td>
                        @else
                            @foreach ($produk as $index => $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->kategori }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->deskripsi }}</td>
                                    <td>{{ $item->harga }}</td>
                                    <td>{{ $item->stok }}</td>
                                    <td>
                                        <div class="dropdown tombol">
                                            <a class="btn dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                                Aksi
                                              </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('produk.detaildaritoko', $item->id) }}">Detail</a>
                                                <a class="dropdown-item" href="#stok{{ $item->id }}" data-toggle="modal"
                                                    data-target="#stok{{ $item->id }}">Kelola Stok</a>
                                                <a class="dropdown-item" href="{{ route('produk.edit', $item->id) }}">Edit</a>
                                                <a class="dropdown-item" href="{{ route('produk.destroy', $item->id) }}">Hapus</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <!-- MODAL STOK -->
                                <form action="{{ url('produk/updatestok/' . $item->id) }}" method="post">
                                    @csrf
                                    <div class="modal fade" id="stok{{ $item->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Stok {{ $item->name }}</h5>
                                                    <button type="button" class="btn-close" data-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <label>Stok</label>
                                                    <input type="number" class="form-control stok" name="stok"
                                                        value="{{ $item->stok }}" min="0" id="stok">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Kembali</button>
                                                    <button type="submit" class="btn btn-primary">Edit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- END MODAL STOK -->
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="">
                    {{ $produk->links() }}
                </div>
            </div>
        </div>
    </div>
    </div>


@endsection
