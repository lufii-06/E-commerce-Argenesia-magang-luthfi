@extends('saya.beranda')
@section('daftar')
    <div class="fashion_section" id="fashion_section">
        <div class="container p-5">
            <div class="daftarpengguna" id="daftarpengguna">
                <div class="card-header mt-5">
                    <h3 class="">Daftar Pengguna</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Nomor</th>
                                <th>Email</th>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $index => $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        @if ($item->hasRole('penjual') && $item->toko->status == 1)
                                            {{ 'Penjual Aktif' }}
                                        @elseif($item->hasRole('penjual') && $item->toko->status == 0)
                                            {{ ' Toko belum disetujui' }}
                                        @else
                                            {{ 'Pembeli' }}
                                        @endif
                                        {{-- @role('penjual')
                                @if ($item->hasRole('penjual') && $item->status == '1')
                                {{ 'Penjual Aktif' }}   
                            @elseif($item->hasRole('penjual') && $item->status == '0')
                                {{ ' Toko belum disetujui' }}
                            @else
                                {{ 'Pembeli' }}
                            @endif
                                @endrole --}}
                                    </td>
                                    <td>
                                        @if ($item->hasRole('penjual') && $item->status == '0')
                                            <form action="{{ url('toko/show/' . $item->id) }}" method="GET">
                                                <button type="submit" class="btn-sm btn-dark">Detail</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="">
                        {{ $user->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
