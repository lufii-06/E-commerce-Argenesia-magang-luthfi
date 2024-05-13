<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Toko;
use App\Models\Produk;
use App\Models\Keranjang;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use App\Models\DetailPemesanan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $idtoko = Toko::where("user_id", $user->id)->get()->pluck('id');
        $toko = Toko::where("user_id", $user->id)->first();
        if ($user->hasRole("admin")) {
            $produk = Produk::orderBy('name', 'desc')->filter(request(['search']))->paginate(5);
            return response(view("saya.daftarproduk", compact("produk")));
        } else {
            $produk = Produk::where("toko_id", $idtoko)->paginate(10);
            // dd($produk);
            return response(view("produk.daftarproduk", compact("produk", "toko")));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $toko = Toko::where("user_id", $user->id)->first();
        return response(view("produk.buatproduk", compact("toko")));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $produkValidate = $request->validate([
            "toko_id" => "required",
            "kategori" => "required",
            "nama" => "required",
            "deskripsi" => "required",
            "stok" => "required",
            "harga" => "required",
            "photo" => "required|file|image|mimes:jpg, png, jpeg|max : 10000",
            "photo1" => "required|file|image|mimes:jpg, png, jpeg|max : 10000",
            "photo2" => "required|file|image|mimes:jpg, png, jpeg|max : 10000"
        ]);

        $file = $request->file('photo');
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/photo/', $fileName);

        $file1 = $request->file('photo1');
        $fileName1 = uniqid() . '.' . $file1->getClientOriginalExtension();
        $file1->storeAs('public/photo/', $fileName1);

        $file2 = $request->file('photo2');
        $fileName2 = uniqid() . '.' . $file2->getClientOriginalExtension();
        $file2->storeAs('public/photo/', $fileName2);

        $toko_id = $request->get('toko_id');
        $data = [
            "toko_id" => $toko_id,
            "kategori" => $produkValidate['kategori'],
            "name" => $produkValidate['nama'],
            "deskripsi" => $produkValidate['deskripsi'],
            "stok" => $produkValidate['stok'],
            "harga" => $produkValidate['harga'],
            "photo" => $fileName,
            "photo1" => $fileName1,
            "photo2" => $fileName2
        ];
        Produk::create($data);
        return redirect(url('/daftarproduk'))->with('success', 'Produk berhasil dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($id == '0') {
            $produk = Produk::paginate(6);
            $kategori = 'Semua';
        } elseif ($id == '1') {
            $produk = Produk::where('kategori', 'smartphone')->paginate(6);
            $kategori = 'Smartphone';

        } elseif ($id == '2') {
            $produk = Produk::where('kategori', 'laptop')->paginate(6);
            $kategori = 'Laptop';

        } else {
            $produk = Produk::where('kategori', 'aksesoris')->paginate(6);
            $kategori = 'Aksesoris';
        }
        $user = Auth::user();
        if ($user) {
            $toko = Toko::where("user_id", $user->id)->first();
            $data['jmlkeranjang'] = Keranjang::where('user_id', $user->id)->count();
            return view('produk.tampilproduk', compact('produk', 'kategori', 'toko', 'data'));
        } else {
            return view('produk.tampilproduk', compact('produk', 'kategori'));
        }
    }

    public function showpopular()
    {
        $produk = Produk::join('detail_pemesanans', 'produks.id', '=', 'detail_pemesanans.produk_id')
            ->select('produks.*', DB::raw('SUM(detail_pemesanans.qty) AS total_qty'))
            ->groupBy('produks.id')->orderBy('total_qty', 'desc') // mengelompokkan berdasarkan ID produk
            ->paginate(6);
        // dd($produk);
        $user = Auth::user();
        $terpopuler = true;
        if ($user) {
            $toko = Toko::where("user_id", $user->id)->first();
            $data['jmlkeranjang'] = Keranjang::where('user_id', $user->id)->count();
            return view('produk.tampilproduk', compact('produk', 'toko', 'data', 'terpopuler'));
        } else {
            return view('produk.tampilproduk', compact('produk', 'terpopuler'));
        }
    }

    public function shownew()
    {
        $produk = Produk::orderBy('created_at', 'desc')->paginate(6);
        $user = Auth::user();
        $terbaru = true;
        if ($user) {
            $toko = Toko::where("user_id", $user->id)->first();
            $data['jmlkeranjang'] = Keranjang::where('user_id', $user->id)->count();
            return view('produk.tampilproduk', compact('produk', 'toko', 'data', 'terbaru'));
        } else {
            return view('produk.tampilproduk', compact('produk', 'terbaru'));
        }
    }

    public function show1()
    {
        $produk = Produk::latest()->filter(request(['search']))->paginate(6);
        $user = Auth::user();
        if ($user) {
            $toko = Toko::where("user_id", $user->id)->first();
            $data['jmlkeranjang'] = Keranjang::where('user_id', $user->id)->count();
            return view('produk.tampilproduk', compact('produk', 'toko', 'data'));
        } else {
            return view('produk.tampilproduk', compact('produk'));
        }
    }

    public function detail($id)
    {
        $user = Auth::user();
        $produk = Produk::find($id);
        if ($user) {
            // $toko = Toko::where("id", $id)->first();
            $data = [
                'jmlkeranjang' => Keranjang::where('user_id', $user->id)->count(),
                //mengambil status sudah dikeranjang atau belum
                'isikeranjang' => Keranjang::where('produk_id', $produk->id)->where('user_id', $user->id)->first()
            ];
            echo view('produk.detailproduk', compact('produk', 'data'));
        } else {
            echo view('produk.detailproduk', compact('produk'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $toko = Toko::where("user_id", $user->id)->first();
        $data = Produk::find($id);
        return view('produk.editproduk', compact('data', 'toko'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $produkValidate = $request->validate([
            "kategori" => "required",
            "nama" => "required",
            "deskripsi" => "required",
            "harga" => "required",
            "photo" => "file|image|mimes:jpg, png, jpeg|max : 2048",
            "photo1" => "file|image|mimes:jpg, png, jpeg|max : 2048",
            "photo2" => "file|image|mimes:jpg, png, jpeg|max : 2048"
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/photo/', $fileName);
            Storage::delete('public/photo/' . $request->oldPhoto);
            $data['photo'] = $fileName;
        } else {
            $data['photo'] = $request->oldPhoto;
        }

        if ($request->hasFile('photo1')) {
            $file1 = $request->file('photo1');
            $fileName1 = uniqid() . '.' . $file1->getClientOriginalExtension();
            $file1->storeAs('public/photo/', $fileName1);
            Storage::delete('public/photo/' . $request->oldPhoto1);
            $data['photo1'] = $fileName1;
        } else {
            $data['photo1'] = $request->oldPhoto1;
        }

        if ($request->hasFile('photo2')) {
            $file2 = $request->file('photo2');
            $fileName2 = uniqid() . '.' . $file2->getClientOriginalExtension();
            $file2->storeAs('public/photo/', $fileName2);
            Storage::delete('public/photo/' . $request->oldPhoto2);
            $data['photo2'] = $fileName2;
        } else {
            $data['photo2'] = $request->oldPhoto2;
        }

        $data = array_merge($data, [
            "kategori" => $produkValidate['kategori'],
            "name" => $produkValidate['nama'],
            "deskripsi" => $produkValidate['deskripsi'],
            "harga" => $produkValidate['harga'],
        ]);
        Produk::where('id', $id)->update($data);
        return redirect(url('daftarproduk'))->with('success', 'data berhasil diubah');
    }

    public function updatestok(Request $request, $id)
    {
        Produk::where('id', $id)->update(['stok' => $request->input('stok')]);
        return redirect(url('daftarproduk'))->with('success', 'data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Produk::find($id);
        Storage::delete('public/photo/' . $data->photo);
        Storage::delete('public/photo/' . $data->photo1);
        Storage::delete('public/photo/' . $data->photo2);
        $data->delete();
        return redirect(url('daftarproduk'))->with('success', 'data berhasil dihapus');
    }

    public function showkeranjang()
    {
        $user = auth::user();
        $keranjang = Keranjang::with('produk.toko')->where('user_id', $user->id)->paginate(6);
        $data = [
            'jmlkeranjang' => Keranjang::where('user_id', $user->id)->count(),
        ];
        // Dapatkan semua produk_id yang ada di keranjang
        $produkIds = Keranjang::pluck('produk_id')->unique();

        // Dapatkan toko yang memiliki produk-produk tersebut
        $tokos = Toko::whereHas('produk', function ($query) use ($produkIds) {
            $query->whereIn('id', $produkIds);
        })->get();

        // Dapatkan keranjang untuk user tertentu
        $isikeranjang = Keranjang::with(['produk.toko'])->where('user_id', $user->id)->get();

        // Kelompokkan keranjang berdasarkan toko
        $keranjangGroupedByToko = $isikeranjang->groupBy('produk.toko.id');
        return response(view('saya.keranjangsaya', compact('keranjang', 'data', 'tokos', 'keranjangGroupedByToko')));
    }

    public function inputkeranjang($id)
    {
        $user = Auth::user();
        $produk = Produk::where('id', $id)->first();
        $data = [
            'produk_id' => $produk->id,
            'user_id' => $user->id,
            'qty' => '1'
        ];
        Keranjang::create($data);
        return redirect()->back()->with('success', 'Produk dimasukan ke keranjang');
    }

    public function deletekeranjang($id)
    {
        $user = Auth::user();
        $produk = Produk::find($id);
        Keranjang::where('user_id', $user->id)->where('produk_id', $produk->id)->delete();
        return redirect()->back()->with('success', 'Berhasil mengeluarkan dari keranjang');
    }

    public function updateqty(Request $request, $id)
    {
        $keranjang = Keranjang::find($id);
        $qty = $keranjang->qty + $request->qty;
        Keranjang::where('id', $id)->update(['qty' => $qty]);
        return redirect()->back()->with('success', 'Berhasil menambahkankan Produk keranjang');
    }

    public function createPemesanan(Request $request)
    {
        // Validasi umum
        $validator = Validator::make($request->all(), [
            'checkbox_*' => 'nullable|exists:produk,id', // Validasi keberadaan produk
            'qty_*' => 'required|numeric|min:1', // Validasi kuantitas minimum
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Mengumpulkan ID produk yang dipilih
        $selectedProductIds = [];
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'checkbox_') === 0 && $value) { // Pastikan key dimulai dengan 'checkbox_'
                $selectedProductIds[] = (int) $value; // Tambahkan ID produk ke array
            }
        }

        if (empty($selectedProductIds)) {
            return redirect()->back()->with('failed', 'Tidak ada produk yang dipilih untuk checkout.');
        }

        // Validasi stok
        foreach ($selectedProductIds as $index => $produkId) {
            $qtyKey = 'qty_' . $produkId;
            $qty = (int) $request->input($qtyKey); // Dapatkan kuantitas

            $produk = Produk::find($produkId);
            if ($produk && $qty > $produk->stok) {
                return redirect()->back()->with('failed', "Stok tidak mencukupi untuk produk {$produk->name}.");
            }
        }

        // Array ID dari entri keranjang
        $selectedKeranjangIds = [];
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'checkbox_') === 0 && $value) { // Pastikan key dimulai dengan 'checkbox_'
                $selectedKeranjangIds[] = (int) $value; // Tambahkan ID keranjang ke array
            }
        }
        foreach ($selectedKeranjangIds as $keranjangId) {
            $qtyKey = 'qty_' . $keranjangId;
            $qty = (int) $request->input($qtyKey);
            $keranjang = Keranjang::updateOrCreate(
                ['id' => $keranjangId], // Kriteria untuk menemukan
                ['qty' => $qty] // Nilai yang di-update
            );
        }

        // Mengambil produk yang dipilih untuk checkout
        $isikeranjang = Keranjang::with('produk.toko')
            ->whereIn('id', $selectedProductIds)
            ->get();
        foreach ($isikeranjang as $item) {
            $namatoko[] = $item->produk->toko->name;
        }

        // Menghapus nilai yang sama (unik) dan menghitung jumlahnya
        $uniqueStores = array_unique($namatoko);

        // Cek jika ada lebih dari satu toko unik
        if (count($uniqueStores) > 1) {
            return Redirect::back()->withErrors(['msg' => 'Anda hanya dapat memesan dari satu toko pada saat yang sama.']);
        } else {
            $user = Auth::user();
            $data = ['jmlkeranjang' => Keranjang::where('user_id', $user->id)->count()];
            return view('saya.pesanansaya', compact("isikeranjang", 'data'));
        }
    }

    public function createpemesananlangsung(Request $request, $id)
    {
        $produk = Produk::with('toko')->find($id);
        $user = Auth::user();
        $data = ['jmlkeranjang' => Keranjang::where('user_id', $user->id)->count()];
        return view('saya.pesanansaya', compact("produk", 'data'));
    }

    public function storepemesananlangsung(Request $request, $id)
    {
        $produkValidate = $request->validate([
            "toko_id" => "required",
            "nama" => "required",
            "nohp" => "required",
            "alamat" => "required",
            "totalpesanlangsung" => "required",
        ]);
        $user = Auth::user();
        if ($request->hasFile('buktipembayaran')) {
            $gambar = $request->file('buktipembayaran');
            $fileName = uniqid() . '.' . $gambar->getClientOriginalExtension();
            $gambar->storeAs('public/photo/', $fileName);
        } else {
            $fileName = '';
        }
        $data = [
            "user_id" => $user->id,
            "toko_id" => $produkValidate['toko_id'],
            "name" => $produkValidate['nama'],
            "nohp" => $produkValidate['nohp'],
            "alamat" => $produkValidate['alamat'],
            "tanggal" => Carbon::now()->format('Y-m-d'),
            "total" => $produkValidate['totalpesanlangsung'],
            "status" => '1',
            "jenispembayaran" => $request->pembayaran,
            "buktipembayaran" => $fileName
        ];
        $datapemesanan = Pemesanan::create($data);

        $detailproduk = [
            'pemesanan_id' => $datapemesanan->id,
            'produk_id' => $request->produk_id,
            'qty' => $request->qty,
            'subtotal' => $produkValidate['totalpesanlangsung']
        ];
        DetailPemesanan::create(($detailproduk));
        return redirect()->route('daftar.pesanan');
    }

    public function storepemesanankeranjang(Request $request, $id)
    {
        $produkValidate = $request->validate([
            "toko_id" => "required",
            "nama" => "required",
            "nohp" => "required",
            "alamat" => "required",
            "total" => "required",
        ]);
        $user = Auth::user();

        $fileName = null;

        if ($request->hasFile('buktipembayaran')) {
            $gambar = $request->file('buktipembayaran');
            $fileName = uniqid() . '.' . $gambar->getClientOriginalExtension();
            $gambar->storeAs('public/photo/', $fileName);
        }
        $data = [
            "user_id" => $user->id,
            "toko_id" => $produkValidate['toko_id'],
            "name" => $produkValidate['nama'],
            "nohp" => $produkValidate['nohp'],
            "alamat" => $produkValidate['alamat'],
            "tanggal" => Carbon::now()->format('Y-m-d'),
            "total" => $produkValidate['total'],
            "status" => '1',
            "jenispembayaran" => $request->pembayaran,
            "buktipembayaran" => $fileName
        ];
        $datapemesanan = Pemesanan::create($data);

        for ($i = 0; $i < $id; $i++) {
            $idproduk_1 = 'idproduk_' . $i + 1;
            $subtotalisi = 'subtotal_' . $i + 1;
            $qtyisi = 'qty_' . $i + 1;
            $detailproduk = [
                'pemesanan_id' => $datapemesanan->id,
                'produk_id' => $request->$idproduk_1,
                'qty' => $request->$qtyisi,
                'subtotal' => $request->$subtotalisi
            ];
            DetailPemesanan::create(($detailproduk));
            $idkeranjang = 'id_' . $i + 1;
            Keranjang::find($request->$idkeranjang)->delete();
        }
        return redirect()->route('daftar.pesanan');
    }

    public function detailproduk($id)
    {
        $produk = Produk::find($id);
        $user = Auth::user();
        $toko = Toko::where("user_id", $user->id)->first();
        return view('produk.detailprodukdaritoko', compact("produk", "toko"));
    }
}
