@extends('saya.beranda')
@section('daftar')
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-eX/ZQsF2m1ItKK0M+hYy5L+F1woy1te4iF77vQVGbeW4M7cUZsI4+twSJPJ5dAfq" crossorigin="anonymous">
</head>
    <div class="fashion_section" id="fashion_section">
        <div class="container p-5">
            <div class="card-header mt-3" id="daftartoko">
                <h3 class="">Daftar Toko</h3>
            </div>
            <div class="card-body">
                <form action="{{ url('beranda/daftartoko') }}" method="GET" id="searchForm1">
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
                            <th>Tanggal Mendaftar</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($toko as $index => $item)
                            <tr>
                                <td>{{ $index + $toko->firstItem() }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->status == '1' ? 'Aktif' : 'Tidak aktif' }}</td>
                                <td>{{ $item->created_at->format('d F Y') }}</td>
                                <td>
                                    <form action="{{ url('toko/showtoko/' . $item->id) }}" method="GET">
                                        <button type="submit" class="btn-sm btn-dark">Detail</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="">
                    {{ $toko->links() }}
                </div>
            </div>
        </div>
    </div>
    <script>
        //search
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
                    window.location.href = "{{ url('beranda/daftartoko') }}";
                }
            });
        });
    </script>
@endsection
