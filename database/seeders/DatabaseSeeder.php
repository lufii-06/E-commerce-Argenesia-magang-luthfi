<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Menghapus semua file dalam folder 'public/photo'
        $directory = 'public/photo';  // Jalur untuk direktori dalam storage yang di-link ke public
        Storage::deleteDirectory($directory); // Menghapus semua file dalam direktori
        Storage::makeDirectory($directory);  // Buat ulang direktori kosong

        // Memanggil Seeder lainnya
        $this->call(RolePermissionSeeder::class);

        // Membuat 10 pengguna dengan role 'pembeli'
        User::factory(10)->pembeli()->create();
    }
}
