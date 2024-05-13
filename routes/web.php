<?php

use App\Http\Controllers\PemesananController;
use App\Models\Keranjang;
use App\Models\Toko;
use App\Models\User;
use App\Models\Produk;
use App\Models\Vtoko;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $user = Auth::user();
    $data = [
        'smartphonetermahal' => Produk::where('kategori', 'smartphone')->orderByDesc('harga')->limit(3)->get(),
        'smartphonetermurah' => Produk::where('kategori', 'smartphone')->orderBy('harga')->limit(3)->get(),
        'laptoptermahal' => Produk::where('kategori', 'laptop')->orderByDesc('harga')->limit(3)->get(),
        'laptoptermurah' => Produk::where('kategori', 'laptop')->orderBy('harga')->limit(3)->get(),
        'aksesoristermahal' => Produk::where('kategori', 'aksesoris')->orderByDesc('harga')->limit(3)->get(),
        'aksesoristermurah' => Produk::where('kategori', 'aksesoris')->orderBy('harga')->limit(3)->get(),
    ];
    if ($user) {
        $data['jmlkeranjang'] = Keranjang::where('user_id', $user->id)->count();
        //memeriksa apakah user mempunyai toko atau tidak
        $toko = Toko::where('user_id', $user->id)->first();
        if ($toko) {
            if ($toko->status == '1') {
                return view('produk.showproduk', compact('toko', 'data'));
            }elseif($toko->status == '2'){
                $pesan = Vtoko::where('toko_id',$toko->id)->first();
                return view('toko.revisitoko', compact('toko','pesan'));
            } else {
                //akan di eksekusi jika toko masi belum aktif
                return view('toko.statustoko', compact('toko'));
            }
        } else {
            return view('produk.showproduk', compact('data'));
        }
    }
    return view('produk.showproduk', compact('data'));

});

Route::get('/produk/show/{id}', [ProdukController::class, 'show'])->name('produk.show');
Route::get('/produk/show/{id}', [ProdukController::class, 'show'])->name('produk.show');
Route::get('/produk/popular', [ProdukController::class, 'showpopular'])->name('produk.popular');
Route::get('/produk/new', [ProdukController::class, 'shownew'])->name('produk.new');
Route::get('/produk/show1', [ProdukController::class, 'show1'])->name('produk.show1');
Route::post('/createtoko', [TokoController::class, 'store']);
Route::get('/registerpemiliktoko', function () {
    return view('auth.registerpemiliktoko');
});
Route::get('toko/daftar', [TokoController::class, 'daftartoko'])->name('toko.daftar');
Route::get('toko/detail/{id}', [TokoController::class, 'detailtoko'])->name('toko.detail');



Route::group(['middleware' => ['auth']], function () {
    Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda.index');
    Route::get('/beranda/daftartoko', [BerandaController::class, 'daftartoko'])->name('beranda.daftartoko');
    Route::get('/beranda/daftarproduk', [BerandaController::class, 'daftarproduk'])->name('beranda.daftarproduk');
    Route::get('/daftartoko', [TokoController::class, 'index'])->name('toko.index');
    Route::get('toko/show/{id}', [TokoController::class, 'show']);
    Route::get('toko/showtoko/{id}', [TokoController::class, 'showtoko']);
    Route::get('toko/update/{id}', [TokoController::class, 'update']);
    Route::post('toko/revisi/{id}', [TokoController::class, 'revisitoko'])->name('toko.revisi');
    Route::post('toko/perbaikan/{id}', [TokoController::class, 'updateperbaikan'])->name('toko.updateperbaikan');
    Route::get('toko/destroy/{id}', [TokoController::class, 'destroy']);
    Route::get('toko/perbaiki/{id}', [TokoController::class, 'perbaikitoko'])->name('toko.perbaiki');

    Route::get('/daftarproduk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::get('/produk/detaildaritoko/{id}', [ProdukController::class, 'detailproduk'])->name('produk.detaildaritoko');
    Route::post('/produk/store', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/edit/{id}', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/update/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::post('/produk/updatestok/{id}', [ProdukController::class, 'updatestok'])->name('produk.updatestok');
    Route::get('/produk/delete/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

    Route::get('keranjang/create/{id}', [ProdukController::class, 'inputkeranjang'])->name('create.keranjang');
    Route::get('keranjang/delete/{id}', [ProdukController::class, 'deletekeranjang'])->name('delete.keranjang');
    Route::get('keranjang/show', [ProdukController::class, 'showkeranjang'])->name('show.keranjang');
    // Route::post('keranjang/updateqty/{id}', [ProdukController::class, 'updateqty'])->name('update.qty');
    Route::post('keranjang/updateqty/{id}', [ProdukController::class, 'updateqty'])->name('update.keranjang');

    Route::post('pemesanan/create/{id}', [ProdukController::class, 'createpemesanan'])->name('pemesanan.create');
    Route::get('pemesananlangsung/create/{id}', [ProdukController::class, 'createpemesananlangsung'])->name('pemesananlangsung.create');

    //store pemesanan
    Route::post('Pemesananlangsung/{id}', [ProdukController::class, 'storepemesananlangsung'])->name('pemesananlangsung.store');
    Route::post('pesandarikeranjang/{id}', [ProdukController::class, 'storepemesanankeranjang'])->name('pesandarikeranjang.store');

    Route::get('/profile/{id}', [ProfileController::class, 'show']);
    Route::get('/profile', function () {
        return view('saya.keranjangsaya', );
    });

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/keranjangsaya', function () {
        return view('saya.keranjangsaya');
    });
    Route::get('/pesanansaya', [PemesananController::class, 'index'])->name('daftar.pesanan');
    Route::get('/riwayatbelanja', [PemesananController::class, 'riwayatbelanja'])->name('daftar.riwayatbelanja');
    Route::get('/penjualan/show', [PemesananController::class, 'show'])->name('penjualan.show');
    Route::post('/pesanan/tolak', [PemesananController::class, 'tolak'])->name('pesanan.tolak');
    Route::put('/pesanan/antar/{id}', [PemesananController::class, 'antar'])->name('pesanan.antar');
    Route::put('/pesanan/selesai/{id}', [PemesananController::class, 'selesai'])->name('pesanan.selesai');
    Route::get('pemesanan/hapus/{id}', [PemesananController::class, 'hapuspesanan'])->name('pesanan.hapus');
    Route::get('pesanan/cetak/{id}', [PemesananController::class, 'cetakpesanan'])->name('cetak.pesanan');
    Route::get('resipengiriman/cetak/{id}', [PemesananController::class, 'cetakresipengiriman'])->name('cetak.resipengiriman');
});

Route::get('/produk/detail/{id}', [ProdukController::class, 'detail'])->name('produk.detail');


Route::middleware(['auth', 'verified', 'role:admin'])->get('/profile', [ProfileController::class, 'index'])->name('profile.index');

route::middleware(['auth'])->group(function () {

});

Auth::routes();