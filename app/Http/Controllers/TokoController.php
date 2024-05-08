<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use App\Models\User;
use App\Models\Vtoko;
use App\Models\Produk;
use App\Models\Keranjang;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TokoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $toko = Toko::where("user_id", $user->id)->get();
        return response(view("saya.tokosaya", compact("toko")));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedUser = $request->validate([
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:5|confirmed',
        ]);

        $validatedToko = $request->validate([
            'namatoko' => 'required|string|max:100',
            'deskripsi' => 'required',
            'nik' => 'required',
            'jenisrekening' => 'required',
            'norek' => 'required',
            'gambarktp' => 'required|file|image|mimes:jpg, png, jpeg|max : 4096',
            'gambarpendukung' => 'nullable',
        ]);
        $dataUser = User::create([
            'name' => $validatedUser['name'],
            'email' => $validatedUser['email'],
            'password' => bcrypt($validatedUser['password']),
            'status' => '0',
            'remember_token' => Str::random(10),
        ]);
        $dataUser->assignRole("penjual");

        $gambarktp = $request->file('gambarktp');
        $fileName = uniqid() . '.' . $gambarktp->getClientOriginalExtension();
        $gambarktp->storeAs('public/photo/', $fileName);

        $gambarpendukung = $request->file('gambarpendukung');
        $fileNamependukung = uniqid() . '.' . $gambarpendukung->getClientOriginalExtension();
        $gambarpendukung->storeAs('public/photo/', $fileNamependukung);

        // $data['gambarktp'] = $fileName;

        Toko::create([
            'user_id' => $dataUser->id,
            'name' => $validatedToko['namatoko'],
            'deskripsi' => $validatedToko['deskripsi'],
            'nik' => $validatedToko['nik'],
            'jenisrekening' => $validatedToko['jenisrekening'],
            'norek' => $validatedToko['norek'],
            'gambarktp' => $fileName,
            'gambarpendukung' => $fileNamependukung,
        ]);
        return redirect()->to('/');
        // return redirect(url('mahasiswa'))->with('success', 'data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dataToko = Toko::where('user_id', $id)->get();
        return response(view('saya.detailtoko', compact('dataToko')));
    }

    public function showtoko($id)
    {
        //sama dengan show tapi ini berdasarkan id toko
        $dataToko = Toko::where('id', $id)->get();
        return response(view('saya.detailtoko', compact('dataToko')));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $data = Toko::find($id);
        if ($data->status == '0') {
            Toko::where('id', $id)->update(['status' => '1']);
        } else {
            Toko::where('id', $id)->update(['status' => '0']);
        }
        return redirect()->to('/beranda');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Toko::find($id);
        Storage::delete('public/photo/' . $data->gambarktp);
        Storage::delete('public/photo/' . $data->gambarpendukung);
        $data->delete();
        User::find($data->user_id)->delete();
        return redirect(url('toko/daftar'))->with('success', 'berhasil menghapus toko');
    }

    public function daftartoko()
    {
        $user = Auth::user();
        $daftartoko = Toko::latest()->filter(request(['search1']))->paginate(5);
        $jmlproduk = [];
        if ($daftartoko) {
            foreach ($daftartoko as $item) {
                $jmlproduk[$item->id] = Produk::where('toko_id', $item->id)->count();
            }
        }
        if ($user) {
            $toko = Toko::where("user_id", $user->id)->first();
            $data['jmlkeranjang'] = Keranjang::where('user_id', $user->id)->count();
            // dd($toko->status);die;
            return response(view("toko.showtoko", compact("toko", "daftartoko", "jmlproduk", "data")));
        } else {
            return response(view("toko.showtoko", compact("daftartoko", "jmlproduk")));
        }
    }

    public function detailtoko($id)
    {
        $user = Auth::user();
        $detailtoko = Toko::where('id', $id)->first();
        $produk = Produk::where('toko_id', $detailtoko->id)->paginate(6);
        if ($user) {
            $toko = Toko::where("user_id", $user->id)->first();
            $data['jmlkeranjang'] = Keranjang::where('user_id', $user->id)->count();
            return (response(view('toko.detailtoko', compact('toko', 'detailtoko', 'produk', 'data'))));
        } else {
            return (response(view('toko.detailtoko', compact('detailtoko', 'produk'))));
        }
    }

    public function revisitoko(Request $request, $id)
    {
        $toko = Toko::findOrFail($id);

        // Data yang ingin Anda update atau masukkan
        $data = [
            'pesan' => $request->pesan,
        ];

        // Update atau buat Vtoko berdasarkan toko_id
        $vtoko = Vtoko::updateOrCreate(
            ['toko_id' => $toko->id], // Kriteria untuk menemukan entri
            $data // Data yang akan diupdate atau diinsert
        );

        DB::table('tokos')
            ->where('id', $id)
            ->update([
                'status' => '2',
            ]);
        return redirect()->route('beranda.daftartoko');
    }

    public function perbaikitoko($id)
    {
        $toko = Toko::find($id);
        return response(view("toko.inputrevisitoko", compact("toko")));

    }

    public function updateperbaikan(Request $request, $id)
    {
        $toko = Toko::findOrFail($id);
        $validatedToko = $request->validate([
            'namatoko' => 'required|string|max:100',
            'deskripsi' => 'required',
            'nik' => 'required',
            'gambarktp' => 'required|file|image|mimes:jpg, png, jpeg|max : 4096',
            'gambarpendukung' => 'nullable',
        ]);

        if ($toko->gambarktp) {
            Storage::delete('public/photo/' . $toko->gambarktp); // Menghapus file lama
        }
        $gambarktp = $request->file('gambarktp');
        $fileName = uniqid() . '.' . $gambarktp->getClientOriginalExtension();
        $gambarktp->storeAs('public/photo/', $fileName);

        if ($request->hasFile('gambarpendukung') && $toko->gambarpendukung) {
            Storage::delete('public/photo/' . $toko->gambarpendukung); // Menghapus file lama
        }
        $gambarpendukung = $request->file('gambarpendukung');
        $fileNamependukung = uniqid() . '.' . $gambarpendukung->getClientOriginalExtension();
        $gambarpendukung->storeAs('public/photo/', $fileNamependukung);

        $toko->Update([
            'name' => $validatedToko['namatoko'],
            'deskripsi' => $validatedToko['deskripsi'],
            'nik' => $validatedToko['nik'],
            'gambarktp' => $fileName,
            'gambarpendukung' => $fileNamependukung,
            'status' => '0'
            //status 0 merupakan status supaya admin bisa cek kembali data toko
        ]);
        return redirect()->to('/');
    }


}
