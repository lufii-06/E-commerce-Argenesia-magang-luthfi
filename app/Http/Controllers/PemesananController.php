<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use App\Models\Produk;
use App\Models\Keranjang;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use App\Models\DetailPemesanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;

class PemesananController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pesanan = Pemesanan::with('toko')->where("user_id", $user->id)->whereIn("status", [1,3])->orderBy('status', 'asc')->get();
        $riwayat = Pemesanan::with('toko')->where("user_id", $user->id)->where("status", '0')->get();
        $sedangdiantar = Pemesanan::with('toko')->where("user_id", $user->id)->where("status", '2')->get();
        $detailpemesanan = [];
        $detailriwayat = [];
        $detailpesanansedangdiantar = [];
        foreach ($pesanan as $item) {
            $detailpemesanan[$item->id] = DetailPemesanan::with('produk')->where('pemesanan_id', $item->id)->get();
        }
        foreach ($riwayat as $item1) {
            $detailriwayat[$item1->id] = DetailPemesanan::with('produk')->where('pemesanan_id', $item1->id)->get();
        }
        foreach ($sedangdiantar as $item2) {
            $detailpesanansedangdiantar[$item2->id] = DetailPemesanan::with('produk')->where('pemesanan_id', $item2->id)->get();
        }
        $data = ['jmlkeranjang' => Keranjang::where('user_id', $user->id)->count()];
        return view('pesanan.daftarpesanan', compact('pesanan', 'detailpemesanan', 'data', 'riwayat', 'detailriwayat', 'sedangdiantar', 'detailpesanansedangdiantar'));
    }

    // public function riwayatbelanja(){
    //     $user = Auth::user();
    //     $pesanan = Pemesanan::with('toko')->where("user_id", $user->id)->where("status", '0')->get();
    //     $detailpemesanan = [];
    //     foreach ($pesanan as $item) {
    //         $detailpemesanan[$item->id] = DetailPemesanan::with('produk')->where('pemesanan_id', $item->id)->get();
    //     }
    //     $data = ['jmlkeranjang' => Keranjang::where('user_id', $user->id)->count()];
    //     return view('pesanan.daftarpesanan', compact('pesanan', 'detailpemesanan', 'data'));
    // }

    public function show()
    {
        $user = Auth::user();
        $toko = Toko::where("user_id", $user->id)->first();
        $pesanan = Pemesanan::with('toko')->where("status", '1')->where('toko_id', $toko->id)->get();
        $penjualan = Pemesanan::with('toko')->where("status", '0')->where('toko_id', $toko->id)->get();
        $sedangdiantar = Pemesanan::with('toko')->where("status", '2')->where('toko_id', $toko->id)->get();
        $detailpemesanan = [];
        $detailpenjualan = [];
        $detailpesanansedangdiantar = [];

        foreach ($pesanan as $item) {
            $detailpemesanan[$item->id] = DetailPemesanan::with('produk')->where('pemesanan_id', $item->id)->get();
        }
        foreach ($penjualan as $item1) {
            $detailpenjualan[$item1->id] = DetailPemesanan::with('produk')->where('pemesanan_id', $item1->id)->get();
        }
        foreach ($sedangdiantar as $item2) {
            $detailpesanansedangdiantar[$item2->id] = DetailPemesanan::with('produk')->where('pemesanan_id', $item2->id)->get();
        }
        return view('pesanan.penjualan', compact('pesanan', 'detailpemesanan', 'toko', 'penjualan', 'detailpenjualan', 'sedangdiantar', 'detailpesanansedangdiantar'));
    }

    // public function showpenjualan(){
    //     $user = Auth::user();
    //     $toko = Toko::where('user_id', $user->id)->first();
    //     $pesanan = Pemesanan::where("status", '0')->where('toko_id', $toko->id)->get();
    //     $detailpemesanan = [];
    //     foreach ($pesanan as $item) {
    //         $detailpemesanan[$item->id] = DetailPemesanan::with('produk')->where('pemesanan_id', $item->id)->get();
    //     }
    //     $toko = Toko::where("user_id", $user->id)->first();
    //     return view('pesanan.penjualan', compact('pesanan', 'detailpemesanan','toko'));
    // }

    public function antar(Request $request, $id)
    {
        $request->validate([
            'resipengiriman' => 'required|size:16'
        ], [
            'resipengiriman.required' => 'Nomor resi pengiriman wajib diisi.',
            'resipengiriman.size' => 'Nomor resi pengiriman harus memiliki panjang tepat 16 karakter.'
        ]);

        Pemesanan::where('id', $id)->update(['status' => '2', 'resipengiriman' => $request->resipengiriman]);
        return redirect()->route('penjualan.show');
    }

    public function tolak(Request $request)
    {
        if ($request->hasFile('buktipenolakan')) {
            $gambar = $request->file('buktipenolakan');
            $fileName = uniqid() . '.' . $gambar->getClientOriginalExtension();
            $gambar->storeAs('public/photo/', $fileName);
        }else{
            $fileName = '';
        }
        Pemesanan::where('id', $request->id)->update(['status' => '3', 'pesan' => $request->pesan, 'buktipenolakan' => $fileName]);
        return redirect()->route('penjualan.show');
    }

    public function selesai(Request $request, $id)
    {
        Pemesanan::where('id', $id)->update(['status' => '0']);
        return redirect()->route('daftar.pesanan');
    }

    public function cetakpesanan($id)
    {
        // Mendapatkan data dinamis dari database
        $pesanan = Pemesanan::with('toko')->where("id", $id)->get();
        $detailpemesanan = [];

        // Pastikan pesanan ditemukan
        if (!$pesanan) {
            abort(404, 'Pemesanan tidak ditemukan');
        } else {
            foreach ($pesanan as $item) {
                $nomorinvoice = sprintf('%07d', $item->id);
                $detailpemesanan[$item->id] = DetailPemesanan::with('produk')->where('pemesanan_id', $item->id)->get();
            }
        }

        // Merender konten Blade dengan data dinamis
        $html = View::make('pesanan.invoice', ['pesanan' => $pesanan, 'detailpemesanan' => $detailpemesanan])->render(); // Pastikan Anda mengirim data yang benar

        // Membuat objek DomPDF dan memuat HTML
        $pdf = PDF::loadHTML($html); // Menggunakan facade DomPDF

        // Mengembalikan PDF untuk streaming atau unduhan
        return $pdf->stream("Invoice{$nomorinvoice}.pdf"); // Gunakan ID pesanan untuk nama file
    }

    public function cetakresipengiriman($id)
    {
        // Mendapatkan data dinamis dari database
        $pesanan = Pemesanan::with('toko', 'user')->where("id", $id)->get();
        $detailpemesanan = [];

        // Pastikan pesanan ditemukan
        if (!$pesanan) {
            abort(404, 'Pemesanan tidak ditemukan');
        } else {
            foreach ($pesanan as $item) {
                $nomorinvoice = sprintf('%07d', $item->id);
                $detailpemesanan[$item->id] = DetailPemesanan::with('produk')->where('pemesanan_id', $item->id)->get();
            }
        }
        // Merender konten Blade dengan data dinamis
        $html = View::make('pesanan.resipengiriman', ['pesanan' => $pesanan, 'detailpemesanan' => $detailpemesanan])->render(); // Pastikan Anda mengirim data yang benar

        // Membuat objek DomPDF dan memuat HTML
        $pdf = PDF::loadHTML($html); // Menggunakan facade DomPDF

        // Mengembalikan PDF untuk streaming atau unduhan
        return $pdf->stream("ResiPengiriman{$nomorinvoice}.pdf"); // Gunakan ID pesanan untuk nama file
    }

    public function hapuspesanan($id){
        try {
            // Temukan data berdasarkan ID
            $item = Pemesanan::findOrFail($id);
            // Hapus data
            $item->delete();

            // Jika berhasil dihapus, kembalikan respons
            return redirect()->back();
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, kembalikan respons dengan pesan kesalahan
            return redirect()->back()->with('error', 'Gagal menghapus data. Silakan coba lagi.');
        }
    }
}
