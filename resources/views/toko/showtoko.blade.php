@extends('layouts.home')
@section('isi')
    <div class="fashion_section" id="fashion_section">
        <div class="container p-5">
            <div class="card-header mt-5" id="daftartoko">
                <h3 class="">Daftar Toko</h3>
            </div>
            <div class="card-body">
                <form action="{{ url('toko/daftar') }}" method="GET" id="searchForm1">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa-solid fa-search fa-md"></i></span>
                        </div>
                        <input type="text" name="search1" id="search1" class="form-control w-50" placeholder="Search Toko"
                            value="{{ request('search1') }}">
                        <div class="input-group-append">
                            <span id="clearSearch1"
                                class="input-group-text cursor-pointer {{ request('search1') ? '' : 'd-none' }} hover:bg-gray-300">x</span>
                        </div>
                    </div>
                </form>
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nomor</th>
                            <th>Nama Toko</th>
                            <th>Pemilik</th>
                            <th>Status</th>
                            <th>Jumlah Produk</th>
                            <th>Detail Toko</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($daftartoko as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->status == '1' ? 'Aktif' : 'Tidak aktif' }}</td>
                                <td>{{ $jmlproduk[$item->id] }}</td>
                                <td><a class="btn btn-light" href="{{ route('toko.detail', $item->id) }}">Kunjungi</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            const searchInput = $('#search1');
            const clearSearch = $('#clearSearch1');
            let formSubmitted = {{ request()->has('search1') ? 'true' : 'false' }};
            if (searchInput.val().trim().length > 0) {
                clearSearch.show();
            }
            searchInput.on('input', function() {
                if ($(this).val().trim().length > 0) {
                    clearSearch.show();
                } else {
                    clearSearch.hide();
                }
            })
            searchInput.keypress(function(e) {
                if (e.which == 13) {
                    e.preventDefault();
                    $('#searchForm1').submit();
                }
            });
            clearSearch.click(function() {
                searchInput.val('');
                clearSearch.hide();
                if (formSubmitted) {
                    window.location.href = "{{ url('toko/daftar') }}";
                }
            });
        });
    </script>
@endsection
