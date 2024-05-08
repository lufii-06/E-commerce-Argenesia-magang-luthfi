@extends('saya.main')
@section('isi')
    <div class="card-header">
        <h5 class="">Toko</h5>
    </div>
    <div class="card-body">
        @foreach ($toko as $item)
        <label for="">Nama Pemilik</label>
        <input type="text" class="form-control" value="{{ $item->user->name }}" disabled>
        
        <label for="">Nama toko</label>
        <input type="text" class="form-control" value="{{ $item->name }}" disabled>
        
        <label for="">E-mail toko</label>
        <input type="text" class="form-control" value="{{ $item->deskripsi }}" disabled>

        <label for="">Deskripsi toko</label>
        <input type="text" class="form-control" value="{{ $item->deskripsi }}" disabled>
        @endforeach
    </div>
@endsection
