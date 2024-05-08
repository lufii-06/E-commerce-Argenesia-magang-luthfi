<?php

namespace Database\Seeders;

use App\Models\Toko;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' =>'tambah-toko']);
        Permission::create(['name' =>'edit-toko']);
        Permission::create(['name' =>'hapus-toko']);
        Permission::create(['name' =>'lihat-toko']);

        Permission::create(['name' =>'tambah-produk']);
        Permission::create(['name' =>'edit-produk']);
        Permission::create(['name' =>'hapus-produk']);
        Permission::create(['name' =>'lihat-produk']);

        Role::create(['name'=> 'admin']);
        Role::create(['name'=> 'penjual']);
        Role::create(['name'=> 'pembeli']);

        $roleAdmin = Role::findByName('admin');
        $roleAdmin->givePermissionTo('lihat-toko');
        $roleAdmin->givePermissionTo('hapus-toko');
        $roleAdmin->givePermissionTo('lihat-produk');
        $roleAdmin->givePermissionTo('hapus-produk');

        $rolePenjual = Role::findByName('penjual');
        $rolePenjual->givePermissionTo('tambah-toko');
        $rolePenjual->givePermissionTo('edit-toko');
        $rolePenjual->givePermissionTo('lihat-toko');
        $rolePenjual->givePermissionTo('hapus-toko');
        $rolePenjual->givePermissionTo('tambah-produk');
        $rolePenjual->givePermissionTo('edit-produk');
        $rolePenjual->givePermissionTo('hapus-produk');
        $rolePenjual->givePermissionTo('lihat-produk');

        $rolePembeli = Role::findByName('pembeli');
        $rolePembeli->givePermissionTo('lihat-toko');
        $rolePembeli->givePermissionTo('lihat-produk');

        User::create([
            "name"=> "Luthfi",
            "email"=> "luthfi2@gmail.com",
            "password"=> bcrypt("password")
        ])->assignRole("admin");

        User::create([
            "name"=> "Hadhit",
            "email"=> "hadhit2@gmail.com",
            "password"=> bcrypt("password")
        ])->assignRole("penjual");
        Toko::create([
            "user_id" => '2',
            "name"=> "Hadhit Store",
            "deskripsi"=>"-",
            "nik"=>"1234567890",
            "jenisrekening"=>"BRI",
            "norek"=>"123456789032123",
            "gambarktp"=> "tes ktp",
        ]);
        
    }
}
