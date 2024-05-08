@extends('saya.main')
@section('isi')
    <div class="card-header">
        <h5 class="">profile</h5>
    </div>
    <div class="card-body">
        {{-- <form action="{{ route('profile.index') }}" method="GET">
            <input class="form-control mr-sm-2 mb-2 w-50" type="search" placeholder="Search" aria-label="Search" name="search">
            
        </form> --}}
        <form action="{{ route('profile.index') }}" method="GET" id="searchForm">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa-solid fa-search fa-md"></i></span>
                </div>
                <input type="text" name="search" id="search" class="form-control"
                    placeholder="Search Menu" value="{{ request('search') }}">
                <div class="input-group-append">
                    <span id="clearSearch" class="input-group-text cursor-pointer {{ request('search') ? '' : 'd-none' }} hover:bg-gray-300">x</span>
                </div>
            </div>
        </form>
        <table class="table">
            <thead> 
                <tr>
                    <th>nomor</th>
                    <th> email</th>
                    <th> nama</th>
                </tr>
            </thead>
           <tbody>
                @foreach ($user as $index => $item)
                <tr>
                    <td>{{ $index + $user->firstItem() }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->name }}</td>
                </tr>
                @endforeach
           </tbody>
        </table>
        <div class="">
            {{ $user->links() }}
        </div>
        {{-- @foreach ($dataToko as $item)
            <p>{{ $item->name }}</p>
        @endforeach --}}
        <div>
            
            @role('admin')
            <p>ini admin</p>
            @endrole
            @role('penjual')
            <p>ini penjual</p>
            @endrole
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        //search
        $(document).ready(function() {
            const searchInput = $('#search');
            const clearSearch = $('#clearSearch');
            let formSubmitted = {{ request()->has('search') ? 'true' : 'false' }};
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
                    $('#searchForm').submit();
                }
            });
            clearSearch.click(function() {
                searchInput.val('');
                clearSearch.hide();
                if (formSubmitted) {
                    window.location.href = "{{ route('profile.index') }}";
                }
            });
        });
    </script>
@endsection
