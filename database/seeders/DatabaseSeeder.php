<?php

namespace Database\Seeders;

use App\Models\User;
use DateTime;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Testing\Fakes\Fake;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create();

        DB::table('roles')->insert([
            [
                'nama_role' => 'Owner',
            ],
            [
                'nama_role' => 'Admin',
            ],
            [
                'nama_role' => 'Manager Operasional',
            ],
            [
                'nama_role' => 'Customer',
            ]
        ]);



        DB::table('users')->insert([
            [
                'id_role' => 1,
                'email' => 'owner@atmabakery.com',
                'password' => bcrypt('12345'),
                'tanggal_diverifikasi' => now(),
                'username' => 'Owner',
                'verif_key' => '12345',
                'url_foto' => null,
            ], [
                'id_role' => 2,
                'email' => 'admin@atmabakery.com',
                'password' => bcrypt('12345'),
                'tanggal_diverifikasi' => now(),
                'username' => 'Admin',
                'verif_key' => '12345',
                'url_foto' => null,
            ],
            [
                'id_role' => 3,
                'email' => 'manageroperational@atmabakery.com',
                'password' => bcrypt('12345'),
                'tanggal_diverifikasi' => now(),
                'username' => 'MOO',
                'verif_key' => '12345',
                'url_foto' => null,
            ]
        ]);

        DB::table('users')->insert([
            [
                'id_role' => 4,
                'email' => 'ryan@gmail.com',
                'password' => bcrypt('12345'),
                'tanggal_diverifikasi' => now(),
                'username' => 'ryan',
                'verif_key' => '12345',
                'url_foto' => null,
            ],
            [
                'id_role' => 4,
                'email' => 'alvian@gmail.com',
                'password' => bcrypt('12345'),
                'tanggal_diverifikasi' => now(),
                'username' => 'alvian',
                'verif_key' => '12345',
                'url_foto' => 'http://null',
            ],
            [
                'id_role' => 4,
                'email' => 'billy@gmail.com',
                'password' => bcrypt('12345'),
                'tanggal_diverifikasi' => null,
                'username' => 'billy',
                'verif_key' => '12345',
                'url_foto' => null,
            ],
            [
                'id_role' => 4,
                'email' => 'abraham@gmail.com',
                'password' => bcrypt('12345'),
                'tanggal_diverifikasi' => null,
                'username' => 'abraham',
                'verif_key' => '12345',
                'url_foto' => null,
            ],
            [
                'id_role' => 4,
                'email' => 'vivi@gmail.com',
                'password' => bcrypt('12345'),
                'tanggal_diverifikasi' => now(),
                'username' => 'vivi',
                'verif_key' => '12345',
                'url_foto' => "HTTP://NULL",
            ],
            [
                'id_role' => 4,
                'email' => 'iyori@gmail.com',
                'password' => bcrypt('12345'),
                'tanggal_diverifikasi' => now(),
                'username' => 'iyori',
                'verif_key' => '12345',
                'url_foto' => "HTTP://NULL",
            ],
            [
                'id_role' => 4,
                'email' => 'dendy@gmail.com',
                'password' => bcrypt('12345'),
                'tanggal_diverifikasi' => null,
                'username' => 'dendy',
                'verif_key' => '12345',
                'url_foto' => null,
            ],
            [
                'id_role' => 4,
                'email' => 'john@gmail.com',
                'password' => bcrypt('12345'),
                'tanggal_diverifikasi' => now(),
                'username' => 'John',
                'verif_key' => '12345',
                'url_foto' => null,
            ]
        ]);

        DB::table('customers')->insert([
            [

                'id_user' => 4,
                'jenis_kelamin' => 'Laki-laki',
                'nama_customer' => 'Ryan',
                'no_telp' => '081234567890',
                'poin' => 0,
                'tanggal_lahir' => '2003-02-08',
            ],
            [

                'id_user' => 5,
                'jenis_kelamin' => 'Laki-laki',
                'nama_customer' => 'alvian',
                'no_telp' => '081234567890',
                'poin' => 0,
                'tanggal_lahir' => '2003-06-16',
            ],
            [

                'id_user' => 6,
                'jenis_kelamin' => 'Laki-laki',
                'nama_customer' => 'billy',
                'no_telp' => '081234567890',
                'poin' => 0,
                'tanggal_lahir' => '2003-06-20',
            ],
            [

                'id_user' => 7,
                'jenis_kelamin' => 'Laki-laki',
                'nama_customer' => 'abraham',
                'no_telp' => '081234567890',
                'poin' => 0,
                'tanggal_lahir' => '2003-09-20',
            ],
            [

                'id_user' => 8,
                'jenis_kelamin' => 'Perempuan',
                'nama_customer' => 'vivi',
                'no_telp' => '081234567890',
                'poin' => 0,
                'tanggal_lahir' => '2003-11-16',
            ],
            [

                'id_user' => 9,
                'jenis_kelamin' => 'Perempuan',
                'nama_customer' => 'iyori',
                'no_telp' => '081234567890',
                'poin' => 0,
                'tanggal_lahir' => '2003-09-21',
            ],
            [

                'id_user' => 10,
                'jenis_kelamin' => 'Laki-laki',
                'nama_customer' => 'dendy',
                'no_telp' => '081234567890',
                'poin' => 0,
                'tanggal_lahir' => '2003-03-01',
            ],
            [

                'id_user' => 11,
                'jenis_kelamin' => 'Men',
                'nama_customer' => 'John',
                'no_telp' => '081234567890',
                'poin' => 560,
                'tanggal_lahir' => '2003-06-13',
            ],
        ]);


        DB::table('penitip')->insert([
            [
                'nama_penitip' => $faker->name,
                'alamat_penitip' => $faker->address,
                'telp_penitip' => $faker->phoneNumber,
            ],

            [
                'nama_penitip' => $faker->name,
                'alamat_penitip' => $faker->address,
                'telp_penitip' => $faker->phoneNumber,
            ],

            [
                'nama_penitip' => $faker->name,
                'alamat_penitip' => $faker->address,
                'telp_penitip' => $faker->phoneNumber,
            ],

            [
                'nama_penitip' => $faker->name,
                'alamat_penitip' => $faker->address,
                'telp_penitip' => $faker->phoneNumber,
            ],

            [
                'nama_penitip' => $faker->name,
                'alamat_penitip' => $faker->address,
                'telp_penitip' => $faker->phoneNumber,
            ],

        ]);
        DB::table('produk')->insert([
            [
                'id_penitip' => 1,
                'nama_produk' => 'Keripik Kentang',
                'harga' => 75000,
                'limit_produksi' => 20,
                'jenis_produk' => 'Snack',
                'deskripsi' => 'Deskripsi Produk Deskripsi Produk Deskripsi Produk Deskripsi Produk Deskripsi Produk',
                'foto' => 'https://atmabakerycontainer.blob.core.windows.net/images/products/1716825762.png'
            ],
            [
                'id_penitip' => 2,
                'nama_produk' => 'Kopi Luwak Bubuk',
                'harga' => 250000,
                'limit_produksi' => 20,
                'jenis_produk' => 'Snack',
                'deskripsi' => 'Deskripsi Produk Deskripsi Produk Deskripsi Produk Deskripsi Produk Deskripsi Produk',
                'foto' => 'https://atmabakerycontainer.blob.core.windows.net/images/products/1716825710.png',
            ],
            [
                'id_penitip' => 3,
                'nama_produk' => 'Matcha Original Bubuk',
                'harga' => 300000,
                'limit_produksi' => 20,
                'jenis_produk' => 'Snack',
                'deskripsi' => 'Deskripsi Produk Deskripsi Produk Deskripsi Produk Deskripsi Produk Deskripsi Produk',
                'foto' => 'https://atmabakerycontainer.blob.core.windows.net/images/products/1716827397.png',
            ],
            [
                'id_penitip' => 4,
                'nama_produk' => 'Chocolate Bar',
                'harga' => 120000,
                'limit_produksi' => 20,
                'jenis_produk' => 'Snack',
                'deskripsi' => 'Deskripsi Produk Deskripsi Produk Deskripsi Produk Deskripsi Produk Deskripsi Produk',
                'foto' => 'https://atmabakerycontainer.blob.core.windows.net/images/products/1716825785.png',
            ],
            [
                'id_penitip' => 5,
                'nama_produk' => 'Lanting Bumbu',
                'harga' => 45000,
                'limit_produksi' => 20,
                'jenis_produk' => 'Snack',
                'deskripsi' => 'Deskripsi Produk Deskripsi Produk Deskripsi Produk Deskripsi Produk Deskripsi Produk',
                'foto' => 'https://atmabakerycontainer.blob.core.windows.net/images/products/1716826024.png',
            ],
        ]);


        DB::table('produk')->insert([
            [
                'nama_produk' => 'Lapis Legit',
                'harga' => 850_000,
                'limit_produksi' => 10,
                'jenis_produk' => 'Cake',
                'deskripsi' => 'Kue lapis lembut yang rasa istimewa denga buah plum kering dan rempah tradisional khas Indonesia',
                'foto' => 'https://atmabakerycontainer.blob.core.windows.net/images/products/1716825654.png',
                'id_penitip' => null,
            ],
            [
                'nama_produk' => 'Lapis Legit (1/2 loyang)',
                'harga' => 450_000,
                'limit_produksi' => 20,
                'jenis_produk' => 'Cake',
                'deskripsi' => 'Kue lapis lembut yang rasa istimewa denga buah plum kering dan rempah tradisional khas Indonesia',
                'foto' => 'https://atmabakerycontainer.blob.core.windows.net/images/products/1716825654.png',
                'id_penitip' => null,
            ],
            [
                'nama_produk' => 'Lapis Surabaya',
                'harga' => 550_000,
                'limit_produksi' => 10,
                'jenis_produk' => 'Cake',
                'deskripsi' => 'Kue lapis yang lembut dengan lapisan bolu cokelat dan vanilla serta selai stroberi yang segar dibaigan dalam',
                'foto' => 'https://atmabakerycontainer.blob.core.windows.net/images/products/1716826109.png',
                'id_penitip' => null,
            ],
            [
                'nama_produk' => 'Lapis Surabaya (1/2 loyang)',
                'harga' => 300_000,
                'limit_produksi' => 20,
                'jenis_produk' => 'Cake',
                'deskripsi' => 'Kue lapis yang lembut dengan lapisan bolu cokelat dan vanilla serta selai stroberi yang segar dibaigan dalam',
                'foto' => 'https://atmabakerycontainer.blob.core.windows.net/images/products/1716826109.png',
                'id_penitip' => null,
            ],
            [
                'nama_produk' => 'Brownies',
                'harga' => 250_000,
                'limit_produksi' => 10,
                'jenis_produk' => 'Cake',
                'deskripsi' => 'Tekstur yang lembut dan rasa cokelat yang kaya, memberikan sensasi rasa yang tak terlupakan',
                'foto' => 'https://atmabakerycontainer.blob.core.windows.net/images/products/1716825309.png',
                'id_penitip' => null,
            ],
            [
                'nama_produk' => 'Brownies (1/2 loyang)',
                'harga' => 150_000,
                'limit_produksi' => 20,
                'jenis_produk' => 'Cake',
                'deskripsi' => 'tekstur yang lembut dan rasa cokelat yang kaya, memberikan sensasi rasa yang tak terlupakan',
                'foto' => 'https://atmabakerycontainer.blob.core.windows.net/images/products/1716825309.png',
                'id_penitip' => null,
            ],
            [
                'nama_produk' => 'Mandarin',
                'harga' => 450_000,
                'limit_produksi' => 10,
                'jenis_produk' => 'Cake',
                'deskripsi' => 'Kue Mandarin kami adalah mahakarya kuliner yang menggabungkan rasa jeruk mandarin yang segar dengan tekstur kue yang lembut dan moist',
                'foto' => 'https://atmabakerycontainer.blob.core.windows.net/images/products/1716829112.png',
                'id_penitip' => null,
            ],
            [
                'nama_produk' => 'Mandarin (1/2 loyang)',
                'harga' => 250_000,
                'limit_produksi' => 20,
                'jenis_produk' => 'Cake',
                'deskripsi' => 'Kue Mandarin kami adalah mahakarya kuliner yang menggabungkan rasa jeruk mandarin yang segar dengan tekstur kue yang lembut dan moist',
                'foto' => 'https://atmabakerycontainer.blob.core.windows.net/images/products/1716829112.png',
                'id_penitip' => null,
            ],
            [
                'nama_produk' => 'Spikoe',
                'harga' => 350_000,
                'limit_produksi' => 10,
                'jenis_produk' => 'Cake',
                'deskripsi' => 'Deskripsi Produk Deskripsi Produk Deskripsi Produk Deskripsi Produk Deskripsi Produk',
                'foto' => 'https://atmabakerycontainer.blob.core.windows.net/images/products/1716825553.png',
                'id_penitip' => null,
            ],
            [
                'nama_produk' => 'Spikoe (1/2 loyang)',
                'harga' => 350_000,
                'limit_produksi' => 20,
                'jenis_produk' => 'Cake',
                'deskripsi' => 'Deskripsi Produk Deskripsi Produk Deskripsi Produk Deskripsi Produk Deskripsi Produk',
                'foto' => 'https://atmabakerycontainer.blob.core.windows.net/images/products/1716825553.png',
                'id_penitip' => null,
            ],
            [
                'nama_produk' => 'Roti Sosis',
                'harga' => 180_000,
                'limit_produksi' => 10,
                'jenis_produk' => 'Roti',
                'deskripsi' => 'Deskripsi Produk Deskripsi Produk Deskripsi Produk Deskripsi Produk Deskripsi Produk',
                'foto' => 'https://atmabakerycontainer.blob.core.windows.net/images/products/1716825519.png',
                'id_penitip' => null,
            ],
            [
                'nama_produk' => 'Milk Bun',
                'harga' => 120_000,
                'limit_produksi' => 10,
                'jenis_produk' => 'Roti',
                'deskripsi' => 'Deskripsi Produk Deskripsi Produk Deskripsi Produk Deskripsi Produk Deskripsi Produk',
                'foto' => 'https://atmabakerycontainer.blob.core.windows.net/images/products/1716825829.png',
                'id_penitip' => null,
            ],
            [
                'nama_produk' => 'Roti Keju',
                'harga' => 150_000,
                'limit_produksi' => 10,
                'jenis_produk' => 'Roti',
                'deskripsi' => 'Deskripsi Produk Deskripsi Produk Deskripsi Produk Deskripsi Produk Deskripsi Produk',
                'foto' => 'https://atmabakerycontainer.blob.core.windows.net/images/products/1716828538.png',
                'id_penitip' => null,
            ],
            [
                'nama_produk' => 'Choco Creamy Latte',
                'harga' => 75_000,
                'limit_produksi' => 10,
                'jenis_produk' => 'Minuman',
                'deskripsi' => 'Deskripsi Produk Deskripsi Produk Deskripsi Produk Deskripsi Produk Deskripsi Produk',
                'foto' => 'https://atmabakerycontainer.blob.core.windows.net/images/products/1716825399.png',
                'id_penitip' => null,
            ],
            [
                'nama_produk' => 'Matcha Creamy Latte',
                'harga' => 100_000,
                'limit_produksi' => 10,
                'jenis_produk' => 'Minuman',
                'deskripsi' => 'Deskripsi Produk Deskripsi Produk Deskripsi Produk Deskripsi Produk Deskripsi Produk',
                'foto' => 'https://atmabakerycontainer.blob.core.windows.net/images/products/1716825493.png',
                'id_penitip' => null,
            ],
        ]);

        DB::table('produk')->insert([
            [
                'id_produk' => 991,
                'nama_produk' => 'Paket A',
                'harga' => 650_000,
                'limit_produksi' => 10,
                'jenis_produk' => 'Hampers',
                'deskripsi' => 'Deskripsi Produk Deskripsi Produk Deskripsi Produk Deskripsi Produk Deskripsi Produk',
                'foto' => 'https://atmabakerycontainer.blob.core.windows.net/images/products/1716828563.png',
                'id_penitip' => null,
            ],
            [
                'id_produk' => 992,
                'nama_produk' => 'Paket B',
                'harga' => 500_000,
                'limit_produksi' => 10,
                'jenis_produk' => 'Hampers',
                'deskripsi' => 'Deskripsi Produk Deskripsi Produk Deskripsi Produk Deskripsi Produk Deskripsi Produk',
                'foto' => 'https://atmabakerycontainer.blob.core.windows.net/images/products/1716828586.png',
                'id_penitip' => null,
            ],
            [
                'id_produk' => 993,
                'nama_produk' => 'Paket C',
                'harga' => 350_000,
                'limit_produksi' => 10,
                'jenis_produk' => 'Hampers',
                'deskripsi' => 'Deskripsi Produk Deskripsi Produk Deskripsi Produk Deskripsi Produk Deskripsi Produk',
                'foto' => 'https://atmabakerycontainer.blob.core.windows.net/images/products/1716828609.png',
                'id_penitip' => null,
            ]
        ]);

        DB::table('detail_hampers')->insert([
            [
                'id_hampers' => 991,
                'id_produk' => 6,
                'id_kemasan' => 30,
            ],
            [
                'id_hampers' => 991,
                'id_produk' => 10,
                'id_kemasan' => 30,
            ],
            [
                'id_hampers' => 992,
                'id_produk' => 8,
                'id_kemasan' => 30,
            ],
            [
                'id_hampers' => 992,
                'id_produk' => 17,
                'id_kemasan' => 30,
            ],
            [
                'id_hampers' => 993,
                'id_produk' => 14,
                'id_kemasan' => 30,
            ],
            [
                'id_hampers' => 993,
                'id_produk' => 19,
                'id_kemasan' => 30,
            ],
        ]);

        DB::table('bahan_baku')->insert([
            [
                //1
                'nama_bahan_baku' => 'Butter',
                'satuan' => 'gr',
                'stok' => 70000,
                'min_stok' => 5000,
            ],
            [
                //2
                'nama_bahan_baku' => 'Creamer',
                'satuan' => 'gr',
                'stok' => 3000,
                'min_stok' => 5000,
            ],
            [
                //3
                'nama_bahan_baku' => 'Telur',
                'satuan' => 'butir',
                'stok' => 50,
                'min_stok' => 100,
            ],
            [
                //4
                'nama_bahan_baku' => 'Gula Pasir',
                'satuan' => 'gr',
                'stok' => 15000,
                'min_stok' => 5000,
            ],
            [
                //5
                'nama_bahan_baku' => 'Susu Bubuk',
                'satuan' => 'gr',
                'stok' => 13000,
                'min_stok' => 4000,
            ],
            [
                //6
                'nama_bahan_baku' => 'Tepung Terigu',
                'satuan' => 'gr',
                'stok' => 30000,
                'min_stok' => 5000,
            ],
            [
                //7 
                'nama_bahan_baku' => 'Garam',
                'satuan' => 'gr',
                'stok' => 1000,
                'min_stok' => 2000,
            ],
            [
                //8
                'nama_bahan_baku' => 'Cokelat Bubuk',
                'satuan' => 'gr',
                'stok' => 10000,
                'min_stok' => 3000,
            ],
            [
                //9
                'nama_bahan_baku' => 'Selai Strawberry',
                'satuan' => 'gr',
                'stok' => 3000,
                'min_stok' => 2000,
            ],
            [
                //10
                'nama_bahan_baku' => 'Minyak Goreng',
                'satuan' => 'ml',
                'stok' => 10000,
                'min_stok' => 5000,
            ],
            [
                //11
                'nama_bahan_baku' => 'Tepung Maizena',
                'satuan' => 'gr',
                'stok' => 1500,
                'min_stok' => 2000,
            ],
            [
                'nama_bahan_baku' => 'Baking Powder',
                'satuan' => 'gr',
                'stok' => 2000,
                'min_stok' => 2000,
            ],
            [
                'nama_bahan_baku' => 'Kacang Kenari',
                'satuan' => 'gr',
                'stok' => 4600,
                'min_stok' => 1000,
            ],
            [
                'nama_bahan_baku' => 'Kuning telur',
                'satuan' => 'buah',
                'stok' => 20,
                'min_stok' => 10,
            ],
            [
                'nama_bahan_baku' => 'Ragi',
                'satuan' => 'gr',
                'stok' => 1500,
                'min_stok' => 2000,
            ],
            [
                'nama_bahan_baku' => 'Susu Cair',
                'satuan' => 'ml',
                'stok' => 5000,
                'min_stok' => 4000,
            ],
            [
                'nama_bahan_baku' => 'Sosis Blackpapper',
                'satuan' => 'buah',
                'stok' => 50,
                'min_stok' => 20,
            ],
            [
                'nama_bahan_baku' => 'Whipped Cream',
                'satuan' => 'ml',
                'stok' => 5000,
                'min_stok' => 2000,
            ],
            [
                'nama_bahan_baku' => 'Susu Full Cream',
                'satuan' => 'ml',
                'stok' => 4300,
                'min_stok' => 4000,
            ],
            [
                'nama_bahan_baku' => 'Keju Mozzarella',
                'satuan' => 'gr',
                'stok' => 4000,
                'min_stok' => 1000,
            ],
            [
                'nama_bahan_baku' => 'Matcha Bubuk',
                'satuan' => 'gr',
                'stok' => 3800,
                'min_stok' => 2000,
            ],
            [
                'nama_bahan_baku' => 'Cokelat Batang',
                'satuan' => 'gr',
                'stok' => 3800,
                'min_stok' => 1000,
            ],
        ]);
        DB::table('bahan_baku')->insert(
            [
                'id_bahan_baku' => 30,
                'nama_bahan_baku' => 'exclusive box and card',
                'stok' => 100,
                'min_stok' => 10,
                'satuan' => 'buah',
            ],
        );

        DB::table('resep')->insert([
            //Lapis Legit
            [
                'jumlah_bahan' => 500,
                'id_produk' => 6,
                'id_bahan_baku' => 1,
            ],
            [
                'jumlah_bahan' => 50,
                'id_produk' => 6,
                'id_bahan_baku' => 2,
            ],
            [
                'jumlah_bahan' => 50,
                'id_produk' => 6,
                'id_bahan_baku' => 3,
            ],
            [
                'jumlah_bahan' => 300,
                'id_produk' => 6,
                'id_bahan_baku' => 4,
            ],
            [
                'jumlah_bahan' => 100,
                'id_produk' => 6,
                'id_bahan_baku' => 5,
            ],
            [
                'jumlah_bahan' => 20,
                'id_produk' => 6,
                'id_bahan_baku' => 6,
            ],

            //Lapis Legit 1/2
            [
                'jumlah_bahan' => 250,
                'id_produk' => 7,
                'id_bahan_baku' => 1,
            ],
            [
                'jumlah_bahan' => 25,
                'id_produk' => 7,
                'id_bahan_baku' => 2,
            ],
            [
                'jumlah_bahan' => 25,
                'id_produk' => 7,
                'id_bahan_baku' => 3,
            ],
            [
                'jumlah_bahan' => 150,
                'id_produk' => 7,
                'id_bahan_baku' => 4,
            ],
            [
                'jumlah_bahan' => 50,
                'id_produk' => 7,
                'id_bahan_baku' => 5,
            ],
            [
                'jumlah_bahan' => 10,
                'id_produk' => 7,
                'id_bahan_baku' => 6,
            ],

            //Lapis Surabaya
            [
                'jumlah_bahan' => 500,
                'id_produk' => 8,
                'id_bahan_baku' => 1,
            ],
            [
                'jumlah_bahan' => 50,
                'id_produk' => 8,
                'id_bahan_baku' => 2,
            ],
            [
                'jumlah_bahan' => 40,
                'id_produk' => 8,
                'id_bahan_baku' => 3,
            ],
            [
                'jumlah_bahan' => 300,
                'id_produk' => 8,
                'id_bahan_baku' => 4,
            ],
            [
                'jumlah_bahan' => 100,
                'id_produk' => 8,
                'id_bahan_baku' => 6,
            ],
            [
                'jumlah_bahan' => 100,
                'id_produk' => 8,
                'id_bahan_baku' => 5,
            ],
            [
                'jumlah_bahan' => 10,
                'id_produk' => 8,
                'id_bahan_baku' => 7,
            ],
            [
                'jumlah_bahan' => 25,
                'id_produk' => 8,
                'id_bahan_baku' => 8,
            ],
            [
                'jumlah_bahan' => 100,
                'id_produk' => 8,
                'id_bahan_baku' => 9,
            ],

            //Lapis Surabaya 1/2
            [
                'jumlah_bahan' => 250,
                'id_produk' => 9,
                'id_bahan_baku' => 1,
            ],
            [
                'jumlah_bahan' => 25,
                'id_produk' => 9,
                'id_bahan_baku' => 2,
            ],
            [
                'jumlah_bahan' => 20,
                'id_produk' => 9,
                'id_bahan_baku' => 3,
            ],
            [
                'jumlah_bahan' => 150,
                'id_produk' => 9,
                'id_bahan_baku' => 4,
            ],
            [
                'jumlah_bahan' => 50,
                'id_produk' => 9,
                'id_bahan_baku' => 6,
            ],
            [
                'jumlah_bahan' => 50,
                'id_produk' => 9,
                'id_bahan_baku' => 5,
            ],
            [
                'jumlah_bahan' => 5,
                'id_produk' => 9,
                'id_bahan_baku' => 7,
            ],
            [
                'jumlah_bahan' => 12.5,
                'id_produk' => 9,
                'id_bahan_baku' => 8,
            ],
            [
                'jumlah_bahan' => 50,
                'id_produk' => 9,
                'id_bahan_baku' => 9,
            ],

            //Brownies
            [
                'jumlah_bahan' => 250,
                'id_produk' => 10,
                'id_bahan_baku' => 22,
            ],
            [
                'jumlah_bahan' => 100,
                'id_produk' => 10,
                'id_bahan_baku' => 1,
            ],
            [
                'jumlah_bahan' => 50,
                'id_produk' => 10,
                'id_bahan_baku' => 10,
            ],
            [
                'jumlah_bahan' => 6,
                'id_produk' => 10,
                'id_bahan_baku' => 3,
            ],
            [
                'jumlah_bahan' => 200,
                'id_produk' => 10,
                'id_bahan_baku' => 4,
            ],
            [
                'jumlah_bahan' => 150,
                'id_produk' => 10,
                'id_bahan_baku' => 6,
            ],
            [
                'jumlah_bahan' => 60,
                'id_produk' => 10,
                'id_bahan_baku' => 8,
            ],

            //Brownies 1/2
            [
                'jumlah_bahan' => 125,
                'id_produk' => 11,
                'id_bahan_baku' => 22,
            ],
            [
                'jumlah_bahan' => 50,
                'id_produk' => 11,
                'id_bahan_baku' => 1,
            ],
            [
                'jumlah_bahan' => 25,
                'id_produk' => 11,
                'id_bahan_baku' => 10,
            ],
            [
                'jumlah_bahan' => 3,
                'id_produk' => 11,
                'id_bahan_baku' => 3,
            ],
            [
                'jumlah_bahan' => 100,
                'id_produk' => 11,
                'id_bahan_baku' => 4,
            ],
            [
                'jumlah_bahan' => 75,
                'id_produk' => 11,
                'id_bahan_baku' => 6,
            ],
            [
                'jumlah_bahan' => 30,
                'id_produk' => 11,
                'id_bahan_baku' => 8,
            ],

            //Mandarin
            [
                'jumlah_bahan' => 300,
                'id_produk' => 12,
                'id_bahan_baku' => 1,
            ],
            [
                'jumlah_bahan' => 30,
                'id_produk' => 12,
                'id_bahan_baku' => 2,
            ],
            [
                'jumlah_bahan' => 30,
                'id_produk' => 12,
                'id_bahan_baku' => 3,
            ],
            [
                'jumlah_bahan' => 200,
                'id_produk' => 12,
                'id_bahan_baku' => 4,
            ],
            [
                'jumlah_bahan' => 80,
                'id_produk' => 12,
                'id_bahan_baku' => 6,
            ],
            [
                'jumlah_bahan' => 80,
                'id_produk' => 12,
                'id_bahan_baku' => 5,
            ],
            [
                'jumlah_bahan' => 5,
                'id_produk' => 12,
                'id_bahan_baku' => 7,
            ],
            [
                'jumlah_bahan' => 25,
                'id_produk' => 12,
                'id_bahan_baku' => 8,
            ],
            [
                'jumlah_bahan' => 50,
                'id_produk' => 12,
                'id_bahan_baku' => 9,
            ],
            [
                'jumlah_bahan' => 50,
                'id_produk' => 12,
                'id_bahan_baku' => 9,
            ],

            //Mandarin 1/2
            [
                'jumlah_bahan' => 150,
                'id_produk' => 13,
                'id_bahan_baku' => 1,
            ],
            [
                'jumlah_bahan' => 15,
                'id_produk' => 13,
                'id_bahan_baku' => 2,
            ],
            [
                'jumlah_bahan' => 15,
                'id_produk' => 13,
                'id_bahan_baku' => 3,
            ],
            [
                'jumlah_bahan' => 10,
                'id_produk' => 13,
                'id_bahan_baku' => 4,
            ],
            [
                'jumlah_bahan' => 40,
                'id_produk' => 13,
                'id_bahan_baku' => 6,
            ],
            [
                'jumlah_bahan' => 40,
                'id_produk' => 13,
                'id_bahan_baku' => 5,
            ],
            [
                'jumlah_bahan' => 2.5,
                'id_produk' => 13,
                'id_bahan_baku' => 7,
            ],
            [
                'jumlah_bahan' => 12.5,
                'id_produk' => 13,
                'id_bahan_baku' => 8,
            ],
            [
                'jumlah_bahan' => 25,
                'id_produk' => 13,
                'id_bahan_baku' => 9,
            ],
            [
                'jumlah_bahan' => 25,
                'id_produk' => 13,
                'id_bahan_baku' => 9,
            ],

            //Spikoe
            [
                'jumlah_bahan' => 20,
                'id_produk' => 14,
                'id_bahan_baku' => 3,
            ],
            [
                'jumlah_bahan' => 200,
                'id_produk' => 14,
                'id_bahan_baku' => 4,
            ],
            [
                'jumlah_bahan' => 90,
                'id_produk' => 14,
                'id_bahan_baku' => 6,
            ],
            [
                'jumlah_bahan' => 20,
                'id_produk' => 14,
                'id_bahan_baku' => 11,
            ],
            [
                'jumlah_bahan' => 10,
                'id_produk' => 14,
                'id_bahan_baku' => 5,
            ],
            [
                'jumlah_bahan' => 5,
                'id_produk' => 14,
                'id_bahan_baku' => 12,
            ],
            [
                'jumlah_bahan' => 200,
                'id_produk' => 14,
                'id_bahan_baku' => 1,
            ],
            [
                'jumlah_bahan' => 100,
                'id_produk' => 14,
                'id_bahan_baku' => 13,
            ],

            //Spikoe 1/2
            [
                'jumlah_bahan' => 10,
                'id_produk' => 15,
                'id_bahan_baku' => 3,
            ],
            [
                'jumlah_bahan' => 100,
                'id_produk' => 15,
                'id_bahan_baku' => 4,
            ],
            [
                'jumlah_bahan' => 45,
                'id_produk' => 15,
                'id_bahan_baku' => 6,
            ],
            [
                'jumlah_bahan' => 10,
                'id_produk' => 15,
                'id_bahan_baku' => 11,
            ],
            [
                'jumlah_bahan' => 5,
                'id_produk' => 15,
                'id_bahan_baku' => 5,
            ],
            [
                'jumlah_bahan' => 2.5,
                'id_produk' => 15,
                'id_bahan_baku' => 12,
            ],
            [
                'jumlah_bahan' => 100,
                'id_produk' => 15,
                'id_bahan_baku' => 1,
            ],
            [
                'jumlah_bahan' => 50,
                'id_produk' => 15,
                'id_bahan_baku' => 13,
            ],

            //Roti Sosis
            [
                'jumlah_bahan' => 250,
                'id_produk' => 16,
                'id_bahan_baku' => 3,
            ],
            [
                'jumlah_bahan' => 30,
                'id_produk' => 16,
                'id_bahan_baku' => 4,
            ],
            [
                'jumlah_bahan' => 3,
                'id_produk' => 16,
                'id_bahan_baku' => 6,
            ],
            [
                'jumlah_bahan' => 3,
                'id_produk' => 16,
                'id_bahan_baku' => 11,
            ],
            [
                'jumlah_bahan' => 150,
                'id_produk' => 16,
                'id_bahan_baku' => 5,
            ],
            [
                'jumlah_bahan' => 50,
                'id_produk' => 16,
                'id_bahan_baku' => 16,
            ],
            [
                'jumlah_bahan' => 2,
                'id_produk' => 16,
                'id_bahan_baku' => 1,
            ],
            [
                'jumlah_bahan' => 10,
                'id_produk' => 16,
                'id_bahan_baku' => 13,
            ],

            //Milk Bun
            [
                'jumlah_bahan' => 250,
                'id_produk' => 17,
                'id_bahan_baku' => 6,
            ],
            [
                'jumlah_bahan' => 30,
                'id_produk' => 17,
                'id_bahan_baku' => 4,
            ],
            [
                'jumlah_bahan' => 3,
                'id_produk' => 17,
                'id_bahan_baku' => 15,
            ],
            [
                'jumlah_bahan' => 4,
                'id_produk' => 17,
                'id_bahan_baku' => 14,
            ],
            [
                'jumlah_bahan' => 300,
                'id_produk' => 17,
                'id_bahan_baku' => 16,
            ],
            [
                'jumlah_bahan' => 60,
                'id_produk' => 17,
                'id_bahan_baku' => 1,
            ],
            [
                'jumlah_bahan' => 3,
                'id_produk' => 17,
                'id_bahan_baku' => 7,
            ],
            [
                'jumlah_bahan' => 200,
                'id_produk' => 17,
                'id_bahan_baku' => 18,
            ],
            [
                'jumlah_bahan' => 50,
                'id_produk' => 17,
                'id_bahan_baku' => 5,
            ],

            //Roti Keju
            [
                'jumlah_bahan' => 250,
                'id_produk' => 18,
                'id_bahan_baku' => 6,
            ],
            [
                'jumlah_bahan' => 30,
                'id_produk' => 18,
                'id_bahan_baku' => 4,
            ],
            [
                'jumlah_bahan' => 3,
                'id_produk' => 18,
                'id_bahan_baku' => 15,
            ],
            [
                'jumlah_bahan' => 3,
                'id_produk' => 18,
                'id_bahan_baku' => 14,
            ],
            [
                'jumlah_bahan' => 150,
                'id_produk' => 18,
                'id_bahan_baku' => 19,
            ],
            [
                'jumlah_bahan' => 50,
                'id_produk' => 18,
                'id_bahan_baku' => 1,
            ],
            [
                'jumlah_bahan' => 2,
                'id_produk' => 18,
                'id_bahan_baku' => 7,
            ],
            [
                'jumlah_bahan' => 350,
                'id_produk' => 18,
                'id_bahan_baku' => 20,
            ],

            //Choco Creamy Latte
            [
                'jumlah_bahan' => 120,
                'id_produk' => 19,
                'id_bahan_baku' => 8,
            ],
            [
                'jumlah_bahan' => 80,
                'id_produk' => 19,
                'id_bahan_baku' => 2,
            ],
            [
                'jumlah_bahan' => 800,
                'id_produk' => 19,
                'id_bahan_baku' => 16,
            ],


            //Matcha Creamy Latte
            [
                'jumlah_bahan' => 120,
                'id_produk' => 20,
                'id_bahan_baku' => 21,
            ],
            [
                'jumlah_bahan' => 80,
                'id_produk' => 20,
                'id_bahan_baku' => 2,
            ],
            [
                'jumlah_bahan' => 800,
                'id_produk' => 20,
                'id_bahan_baku' => 16,
            ],

            //Matcha Creamy Latte
            [
                'jumlah_bahan' => 120,
                'id_produk' => 20,
                'id_bahan_baku' => 21,
            ],
            [
                'jumlah_bahan' => 80,
                'id_produk' => 20,
                'id_bahan_baku' => 2,
            ],
            [
                'jumlah_bahan' => 800,
                'id_produk' => 20,
                'id_bahan_baku' => 16,
            ],
        ]);

        DB::table('penggunaan_bahan_baku')->insert([
            [
                'tanggal_penggunaan' => now()->addDay(-2),
                'jumlah_penggunaan' => 500,
                'id_bahan_baku' => 4,
            ],
            [
                'tanggal_penggunaan' => now()->addDay(-2),
                'jumlah_penggunaan' => 150,
                'id_bahan_baku' => 5,
            ],
            [
                'tanggal_penggunaan' => now()->addDay(-2),
                'jumlah_penggunaan' => 600,
                'id_bahan_baku' => 2,
            ],
            [
                'tanggal_penggunaan' => now()->addDay(-2),
                'jumlah_penggunaan' => 200,
                'id_bahan_baku' => 1,
            ],
            [
                'tanggal_penggunaan' => now()->addDay(-2),
                'jumlah_penggunaan' => 450,
                'id_bahan_baku' => 7,
            ],
            [
                'tanggal_penggunaan' => now()->addDay(-3),
                'jumlah_penggunaan' => 700,
                'id_bahan_baku' => 9,
            ],
            [
                'tanggal_penggunaan' => now()->addDay(-3),
                'jumlah_penggunaan' => 500,
                'id_bahan_baku' => 4,
            ],
            [
                'tanggal_penggunaan' => now()->addDay(-3),
                'jumlah_penggunaan' => 560,
                'id_bahan_baku' => 10,
            ],
            [
                'tanggal_penggunaan' => now()->addDay(-3),
                'jumlah_penggunaan' => 50,
                'id_bahan_baku' => 11,
            ],
            [
                'tanggal_penggunaan' => now()->addDay(-3),
                'jumlah_penggunaan' => 300,
                'id_bahan_baku' => 1,
            ],
            [
                'tanggal_penggunaan' => now()->addDay(-2),
                'jumlah_penggunaan' => 45,
                'id_bahan_baku' => 12,
            ],
        ]);

        DB::table('pembelian_bahan_baku')->insert([
            [
                'tanggal_pembelian' => now()->addDay(-2),
                'jumlah_pembelian' => 500,
                'harga_beli' => 1000,
                'id_bahan_baku' => 4,
            ],
            [
                'tanggal_pembelian' => now()->addDay(-2),
                'jumlah_pembelian' => 1000,
                'harga_beli' => 3000,
                'id_bahan_baku' => 15,
            ],
            [
                'tanggal_pembelian' => now()->addDay(-2),
                'jumlah_pembelian' => 800,
                'harga_beli' => 2000,
                'id_bahan_baku' => 13,
            ],
            [
                'tanggal_pembelian' => now()->addDay(-2),
                'jumlah_pembelian' => 5000,
                'harga_beli' => 3400,
                'id_bahan_baku' => 7,
            ],
            [
                'tanggal_pembelian' => now()->addDay(-2),
                'jumlah_pembelian' => 2500,
                'harga_beli' => 850,
                'id_bahan_baku' => 2,
            ],
            [
                'tanggal_pembelian' => now()->addDay(-3),
                'jumlah_pembelian' => 360,
                'harga_beli' => 1500,
                'id_bahan_baku' => 3,
            ],
            [
                'tanggal_pembelian' => now()->addDay(-3),
                'jumlah_pembelian' => 5000,
                'harga_beli' => 500,
                'id_bahan_baku' => 18,
            ],
            [
                'tanggal_pembelian' => now()->addDay(-3),
                'jumlah_pembelian' => 3500,
                'harga_beli' => 600,
                'id_bahan_baku' => 21,
            ],
            [
                'tanggal_pembelian' => now()->addDay(-3),
                'jumlah_pembelian' => 6000,
                'harga_beli' => 1350,
                'id_bahan_baku' => 10,
            ],
            [
                'tanggal_pembelian' => now()->addDay(-3),
                'jumlah_pembelian' => 3400,
                'harga_beli' => 300,
                'id_bahan_baku' => 10,
            ],
        ]);

        DB::table('pengeluaran_lain_lain')->insert([
            [
                'nama_pengeluaran' => 'Pembayaran Listrik',
                'tanggal_pengeluaran' => now()->addDay(-5),
                'total_pengeluaran' => 1000000,
            ],
            [
                'nama_pengeluaran' => 'Pembayaran Bensin',
                'tanggal_pengeluaran' => now()->addDay(-5),
                'total_pengeluaran' => 500_000,
            ],
            [
                'nama_pengeluaran' => 'Biaya Penyusutan',
                'tanggal_pengeluaran' => now()->addDay(-4),
                'total_pengeluaran' => 400_000,
            ],
            [
                'nama_pengeluaran' => 'Biaya Sampah',
                'tanggal_pengeluaran' => now()->addDay(5),
                'total_pengeluaran' => 150_000,
            ],
            [
                'nama_pengeluaran' => 'Pembayaran Asuransi BPJS',
                'tanggal_pengeluaran' => now()->addDay(-5),
                'total_pengeluaran' => 1_500_000,
            ],
            [
                'nama_pengeluaran' => 'Pembelian Mesin Oven',
                'tanggal_pengeluaran' => now()->addDay(4),
                'total_pengeluaran' => 20_000_001,
            ],
        ]);

        for ($i = 1; $i < 15; $i++) {
            $id_karyawan = DB::table('karyawan')->insertGetId([
                'nama_karyawan' => $faker->name,
                'gaji_karyawan' => rand(30000, 25000),
                'bonus_gaji_karyawan' => rand(0, 500000),
            ]);

            for ($j = 0; $j < rand(0, 2); $j++) {
                DB::table('presensi_karyawan')->insert([
                    'id_karyawan' => $id_karyawan,
                    'tanggal_absen' => $faker->dateTimeBetween('-3 Week', '+1 Week'),
                ]);
            }
        }

        for ($i = 1; $i <= 7; $i++) {
            $id_alamat = DB::table('alamat_customers')->insertGetId([
                'label_alamat' => $faker->word,
                'alamat' => $faker->address,
                'id_customer' => $i,
            ]);
        }

        DB::table('alamat_customers')->insert([
            [
                'label_alamat' => 'Home',
                'alamat' => 'Jl. Babarsari No. 43, Yogyakarta',
                'id_customer' => 8,
            ],
            [
                'label_alamat' => 'Office',
                'alamat' => 'Jl. Kaliurang No. 43, Yogyakarta',
                'id_customer' => 8,
            ],
        ]);

        //transaksi gagal 1
        DB::table('pembayaran')->insert([
            [
                //1
                'jenis_pembayaran' => 'Transfer',
                'bukti_pembayaran' => 'http://null',
                'tanggal_pembayaran' => '2024-02-01',
                'tanggal_pembayaran_valid' => '2024-02-01',
                'total_pembayaran' => 850000,
                'tip' => 0,

                'id_customer' => 1,
            ]
        ]);
        DB::table('transaksi')->insert(
            [
                'id_transaksi' => '24.02.001',
                'tanggal_nota_dibuat' => '2024-02-01',
                'tanggal_ditolak' => '2024-02-03',
                'total' => 850000,
                'jenis_pengiriman' => 'Ambil Sendiri',
                'status_transaksi' => 'Rejected',
                'id_customer' => 1,
                'id_pembayaran' => 1,
            ]
        );
        DB::table('detail_transaksi')->insert([
            'jumlah_item' => 1,
            'harga_satuan' => 75000,
            'id_transaksi' => '24.02.001',
            'id_produk' => 1
        ]);
        DB::table('mutasi_saldo')->insert([
            [
                'id_customer' => 1,
                'debit' => 850000,
                'kredit' => 0,
                'saldo' => 850000,
                'tanggal_mutasi' => '2024-02-03',
            ],
            [
                'id_customer' => 1,
                'debit' => 0,
                'kredit' => 850000,
                'saldo' => 0,
                'tanggal_mutasi' => '2024-02-03',
            ],
        ]);
        DB::table('pengembalian_dana')->insert([
            'tanggal_pengembalian_diajukan' => '2024-02-03',
            'tanggal_pengembalian_diterima' => '2024-02-03',
            'jumlah_pengembalian' => 850000,
            'nomor_rekening_tujuan' => $faker->bankAccountNumber,
            'status_pengembalian' => 'Waiting Confirmation',
            'id_customer' => 1,
        ]);
        //transaksi gagal 2
        DB::table('pembayaran')->insert([
            [
                //1
                'jenis_pembayaran' => 'Transfer',
                'bukti_pembayaran' => 'http://null',
                'tanggal_pembayaran' => '2024-02-10',
                'tanggal_pembayaran_valid' => '2024-02-10',
                'total_pembayaran' => 850000,
                'tip' => 0,
                'id_customer' => 1,
            ]
        ]);
        DB::table('transaksi')->insert(
            [
                'id_transaksi' => '24.02.002',
                'tanggal_nota_dibuat' => '2024-02-10',
                'tanggal_ditolak' => '2024-02-12',
                'total' => 850000,
                'jenis_pengiriman' => 'Ambil Sendiri',
                'status_transaksi' => 'Cancelled',

                'id_customer' => 1,
                'id_pembayaran' => 2,
            ]
        );
        DB::table('detail_transaksi')->insert([
            'jumlah_item' => 1,
            'harga_satuan' => 75000,
            'id_transaksi' => '24.02.002',
            'id_produk' => 1
        ]);
        DB::table('mutasi_saldo')->insert([
            [
                'id_customer' => 1,
                'debit' => 850000,
                'kredit' => 0,
                'saldo' => 850000,
                'tanggal_mutasi' => '2024-02-12',
            ],
            [
                'id_customer' => 1,
                'debit' => 0,
                'kredit' => 850000,
                'saldo' => 0,
                'tanggal_mutasi' => '2024-02-13',
            ],
        ]);
        DB::table('pengembalian_dana')->insert([
            'tanggal_pengembalian_diajukan' => '2024-02-12',
            'tanggal_pengembalian_diterima' => '2024-02-13',
            'jumlah_pengembalian' => 850000,
            'nomor_rekening_tujuan' => $faker->bankAccountNumber,
            'status_pengembalian' => 'Waiting Confirmation',
            'id_customer' => 1,
        ]);
        //transaksi gagal 3
        DB::table('pembayaran')->insert([
            [
                //1
                'jenis_pembayaran' => 'Transfer',
                'bukti_pembayaran' => 'http://null',
                'tanggal_pembayaran' => '2024-02-12',
                'tanggal_pembayaran_valid' => '2024-02-13',
                'total_pembayaran' => 850000,
                'tip' => 0,

                'id_customer' => 3,
            ]
        ]);
        DB::table('transaksi')->insert(
            [
                'id_transaksi' => '24.02.003',
                'tanggal_nota_dibuat' => '2024-02-12',
                'tanggal_ditolak' => '2024-02-14',
                'total' => 850000,
                'jenis_pengiriman' => 'Pickup',
                'status_transaksi' => 'Cancelled',

                'id_customer' => 3,
                'id_pembayaran' => 3,
            ]
        );
        DB::table('detail_transaksi')->insert([
            'jumlah_item' => 1,
            'harga_satuan' => 75000,
            'id_transaksi' => '24.02.003',
            'id_produk' => 1
        ]);
        DB::table('mutasi_saldo')->insert([
            [
                'id_customer' => 3,
                'debit' => 850000,
                'kredit' => 0,
                'saldo' => 850000,
                'tanggal_mutasi' => '2024-02-14',
            ],
            [
                'id_customer' => 3,
                'debit' => 0,
                'kredit' => 850000,
                'saldo' => 0,
                'tanggal_mutasi' => '2024-02-14',
            ],
        ]);
        DB::table('pengembalian_dana')->insert([
            'tanggal_pengembalian_diajukan' => '2024-02-14',
            'tanggal_pengembalian_diterima' => '2024-02-14',
            'jumlah_pengembalian' => 850000,
            'nomor_rekening_tujuan' => $faker->bankAccountNumber,
            'status_pengembalian' => 'Waiting Confirmation',
            'id_customer' => 3,
        ]);
        //transaksi gagal 4
        DB::table('pembayaran')->insert([
            [
                //1
                'jenis_pembayaran' => 'Transfer',
                'bukti_pembayaran' => 'http://null',
                'tanggal_pembayaran' => '2024-03-01',
                'tanggal_pembayaran_valid' => '2024-03-02',
                'total_pembayaran' => 850000,
                'tip' => 0,

                'id_customer' => 2,
            ]
        ]);
        DB::table('transaksi')->insert(
            [
                'id_transaksi' => '24.03.001',
                'tanggal_nota_dibuat' => '2024-03-01',
                'tanggal_ditolak' => '2024-03-03',
                'total' => 850000,
                'jenis_pengiriman' => 'Pickup',
                'status_transaksi' => 'Cancelled',

                'id_customer' => 2,
                'id_pembayaran' => 4,
            ]
        );
        DB::table('detail_transaksi')->insert([
            'jumlah_item' => 1,
            'harga_satuan' => 75000,
            'id_transaksi' => '24.03.001',
            'id_produk' => 1
        ]);
        DB::table('mutasi_saldo')->insert([
            [
                'id_customer' => 2,
                'debit' => 850000,
                'kredit' => 0,
                'saldo' => 850000,
                'tanggal_mutasi' => '2024-03-03',
            ],
            [
                'id_customer' => 2,
                'debit' => 0,
                'kredit' => 850000,
                'saldo' => 0,
                'tanggal_mutasi' => '2024-03-03',
            ],
        ]);
        DB::table('pengembalian_dana')->insert([
            'tanggal_pengembalian_diajukan' => '2024-03-03',
            'tanggal_pengembalian_diterima' => '2024-03-03',
            'jumlah_pengembalian' => 850000,
            'nomor_rekening_tujuan' => $faker->bankAccountNumber,
            'status_pengembalian' => 'Waiting Confirmation',
            'id_customer' => 2,
        ]);
        //transaksi gagal 5
        DB::table('pembayaran')->insert([
            [
                //1
                'jenis_pembayaran' => 'Transfer',
                'bukti_pembayaran' => 'http://null',
                'tanggal_pembayaran' => '2024-03-02',
                'tanggal_pembayaran_valid' => '2024-03-03',
                'total_pembayaran' => 850000,
                'tip' => 0,

                'id_customer' => 5,
            ]
        ]);
        DB::table('transaksi')->insert(
            [
                'id_transaksi' => '24.03.002',
                'tanggal_nota_dibuat' => '2024-03-02',
                'tanggal_ditolak' => '2024-03-04',
                'total' => 850000,
                'jenis_pengiriman' => 'Pickup',
                'status_transaksi' => 'Rejected',

                'id_customer' => 5,
                'id_pembayaran' => 5,
            ]
        );
        DB::table('detail_transaksi')->insert([
            'jumlah_item' => 1,
            'harga_satuan' => 75000,
            'id_transaksi' => '24.03.002',
            'id_produk' => 1
        ]);
        DB::table('mutasi_saldo')->insert([
            [
                'id_customer' => 5,
                'debit' => 850000,
                'kredit' => 0,
                'saldo' => 850000,
                'tanggal_mutasi' => '2024-03-04',
            ],
            [
                'id_customer' => 5,
                'debit' => 0,
                'kredit' => 850000,
                'saldo' => 0,
                'tanggal_mutasi' => '2024-03-04',
            ],
        ]);
        DB::table('pengembalian_dana')->insert([
            'tanggal_pengembalian_diajukan' => '2024-03-04',
            'tanggal_pengembalian_diterima' => '2024-03-04',
            'jumlah_pengembalian' => 850000,
            'nomor_rekening_tujuan' => $faker->bankAccountNumber,
            'status_pengembalian' => 'Waiting Confirmation',
            'id_customer' => 5,
        ]);

        DB::table('pembayaran')->insert([
            [
                'jenis_pembayaran' => 'Cash',
                'tanggal_pembayaran' => '2024-02-11',
                'tanggal_pembayaran_valid' => '2024-02-15',
                'total_pembayaran' => 1110000,
                'tip' => 5000,
                'id_customer' => 3,
            ],
            [
                'jenis_pembayaran' => 'Transfer',
                'tanggal_pembayaran' => '2024-02-15',
                'tanggal_pembayaran_valid' => '2024-03-16',
                'total_pembayaran' => 515000,
                'tip' => 0,
                'id_customer' => 6,
            ],
        ]);
        DB::table('transaksi')->insert(
            [
                [
                    'id_transaksi' => '24.02.004',
                    'tanggal_nota_dibuat' => '2024-02-11',
                    'tanggal_ambil' => '2024-02-15',
                    'tanggal_diterima' => '2024-02-13',
                    'tanggal_diproses' => '2024-02-14',
                    'tanggal_siap' => '2024-02-15',
                    'tanggal_diambil' => '2024-02-15',
                    'tanggal_selesai' => '2024-02-16',
                    'total' => 1110000,
                    'jenis_pengiriman' => 'Pickup',
                    'status_transaksi' => 'Completed',

                    'id_customer' => 3,
                    'id_pembayaran' => 6,
                ],
                [
                    'id_transaksi' => '24.02.005',
                    'tanggal_nota_dibuat' => '2024-02-15',
                    'tanggal_ambil' => '2024-02-17',
                    'tanggal_diterima' => '2024-02-16',
                    'tanggal_diproses' => '2024-02-16',
                    'tanggal_siap' => '2024-02-17',
                    'tanggal_diambil' => '2024-02-17',
                    'tanggal_selesai' => '2024-02-17',
                    'total' => 500000,
                    'jenis_pengiriman' => 'Delivery',
                    'status_transaksi' => 'Completed',

                    'id_customer' => 6,
                    'id_pembayaran' => 7,
                ],
            ]
        );
        DB::table('detail_transaksi')->insert([
            'jumlah_item' => 1,
            'harga_satuan' => 45000,
            'id_transaksi' => '24.02.004',
            'id_produk' => 5
        ]);
        DB::table('detail_transaksi')->insert([
            'jumlah_item' => 1,
            'harga_satuan' => 350000,
            'id_transaksi' => '24.02.004',
            'id_produk' => 15
        ],);
        DB::table('detail_transaksi')->insert([
            'jumlah_item' => 1,
            'harga_satuan' => 75000,
            'id_transaksi' => '24.02.004',
            'id_produk' => 1
        ]);
        DB::table('detail_transaksi')->insert([
            'jumlah_item' => 1,
            'harga_satuan' => 75000,
            'id_transaksi' => '24.02.005',
            'id_produk' => 1
        ]);

        DB::table('pengiriman')->insert([
            [
                'jarak_pengiriman' => 10,
                'biaya_pengiriman' => 15000,
                'tanggal_dikirim' => '2024-02-17',
                'kurir' => 'Andi',
                'alamat_tujuan' => $faker->address,

                'id_transaksi' => '24.02.005',
            ],
        ]);

        //MARET
        DB::table('pembayaran')->insert([
            [
                'jenis_pembayaran' => 'Transfer',
                'tanggal_pembayaran' => '2024-03-05',
                'tanggal_pembayaran_valid' => '2024-03-06',
                'total_pembayaran' => 670000,
                'tip' => 0,
                'id_customer' => 7,
            ],
            [
                'jenis_pembayaran' => 'Transfer',
                'tanggal_pembayaran' => '2024-03-10',
                'tanggal_pembayaran_valid' => '2024-03-11',
                'total_pembayaran' => 515_000,
                'tip' => 0,
                'id_customer' => 3,
            ],
            [
                'jenis_pembayaran' => 'Transfer',
                'tanggal_pembayaran' => '2024-03-14',
                'tanggal_pembayaran_valid' => '2024-03-15',
                'total_pembayaran' => 3_610_000,
                'tip' => 0,
                'id_customer' => 4,
            ],
            [
                'jenis_pembayaran' => 'Transfer',
                'tanggal_pembayaran' => '2024-03-14',
                'tanggal_pembayaran_valid' => '2024-03-15',
                'total_pembayaran' => 130_000,
                'tip' => 0,
                'id_customer' => 5,
            ],
            [
                'jenis_pembayaran' => 'Transfer',
                'tanggal_pembayaran' => '2024-03-20',
                'tanggal_pembayaran_valid' => '2024-03-21',
                'total_pembayaran' => 190_000,
                'tip' => 0,
                'id_customer' => 6,
            ],
            [
                'jenis_pembayaran' => 'Transfer',
                'tanggal_pembayaran' => '2024-03-24',
                'tanggal_pembayaran_valid' => '2024-03-25',
                'total_pembayaran' => 1_000_000,
                'tip' => 0,
                'id_customer' => 2,
            ],
        ]);
        DB::table('transaksi')->insert(
            [
                [
                    'id_transaksi' => '24.06.001',
                    'tanggal_nota_dibuat' => '2024-06-14',
                    'tanggal_ambil' => '2024-06-19',
                    'tanggal_diterima' => null,
                    'tanggal_diproses' => null,
                    'tanggal_siap' => null,
                    'tanggal_diambil' => null,
                    'tanggal_selesai' => null,
                    'total' => 650000,
                    'jenis_pengiriman' => 'Delivery',
                    'status_transaksi' => 'Inputing Range',

                    'id_customer' => 7,
                    'id_pembayaran' => 8,
                ],
                [
                    'id_transaksi' => '24.06.002',
                    'tanggal_nota_dibuat' => '2024-06-14',
                    'tanggal_ambil' => '2024-06-16',
                    'tanggal_diterima' => null,
                    'tanggal_diproses' => null,
                    'tanggal_siap' => null,
                    'tanggal_diambil' => null,
                    'tanggal_selesai' => null,
                    'total' => 500000,
                    'jenis_pengiriman' => 'Delivery',
                    'status_transaksi' => 'Paid',

                    'id_customer' => 3,
                    'id_pembayaran' => 9,
                ],
                [
                    'id_transaksi' => '24.06.003',
                    'tanggal_nota_dibuat' => '2024-06-14',
                    'tanggal_ambil' => '2024-06-17',
                    'tanggal_diterima' => null,
                    'tanggal_diproses' => null,
                    'tanggal_siap' => null,
                    'tanggal_diambil' => null,
                    'tanggal_selesai' => null,
                    'total' => 3_595_000,
                    'jenis_pengiriman' => 'Delivery',
                    'status_transaksi' => 'Completed',

                    'id_customer' => 4,
                    'id_pembayaran' => 10,
                ],
                [
                    'id_transaksi' => '24.06.004',
                    'tanggal_nota_dibuat' => '2024-06-07',
                    'tanggal_ambil' => '2024-06-10',
                    'tanggal_diterima' => '2024-06-07',
                    'tanggal_diproses' => '2024-06-09',
                    'tanggal_siap' => '2024-06-10',
                    'tanggal_diambil' => '2024-06-10',
                    'tanggal_selesai' => '2024-06-10',
                    'total' => 120_000,
                    'jenis_pengiriman' => 'Delivery',
                    'status_transaksi' => 'Completed',

                    'id_customer' => 5,
                    'id_pembayaran' => 11,
                ],
                [
                    'id_transaksi' => '24.06.005',
                    'tanggal_nota_dibuat' => '2024-06-08',
                    'tanggal_ambil' => '2024-06-12',
                    'tanggal_diterima' => '2024-06-08',
                    'tanggal_diproses' => '2024-06-11',
                    'tanggal_siap' => '2024-06-11',
                    'tanggal_diambil' => '2024-06-12',
                    'tanggal_selesai' => '2024-06-12',
                    'total' => 175_000,
                    'jenis_pengiriman' => 'Delivery',
                    'status_transaksi' => 'Completed',

                    'id_customer' => 6,
                    'id_pembayaran' => 12,
                ],
                [
                    'id_transaksi' => '24.06.006',
                    'tanggal_nota_dibuat' => '2024-03-13',
                    'tanggal_ambil' => '2024-03-15',
                    'tanggal_diterima' => '2024-03-15',
                    'tanggal_diproses' => '2024-03-14',
                    'tanggal_siap' => null,
                    'tanggal_diambil' => null,
                    'tanggal_selesai' => null,
                    'total' => 1000000,
                    'jenis_pengiriman' => 'Delivery',
                    'status_transaksi' => 'On Process',

                    'id_customer' => 2,
                    'id_pembayaran' => 13,
                ],
            ]
        );
        DB::table('detail_transaksi')->insert([
            [
                'jumlah_item' => 1,
                'harga_satuan' => 650000,
                'id_transaksi' => '24.06.001',
                'id_produk' => 991
            ],
            [
                'jumlah_item' => 1,
                'harga_satuan' => 250_000,
                'id_transaksi' => '24.06.002',
                'id_produk' => 2
            ],
            [
                'jumlah_item' => 1,
                'harga_satuan' => 300_000,
                'id_transaksi' => '24.06.002',
                'id_produk' => 9
            ],
            [
                'jumlah_item' => 2,
                'harga_satuan' => 75_000,
                'id_transaksi' => '24.06.003',
                'id_produk' => 1
            ],
            [
                'jumlah_item' => 4,
                'harga_satuan' => 45000,
                'id_transaksi' => '24.06.003',
                'id_produk' => 5
            ],
            [
                'jumlah_item' => 1,
                'harga_satuan' => 150000,
                'id_transaksi' => '24.06.003',
                'id_produk' => 11
            ],
            [
                'jumlah_item' => 1,
                'harga_satuan' => 180000,
                'id_transaksi' => '24.06.004',
                'id_produk' => 16
            ],
            [
                'jumlah_item' => 1,
                'harga_satuan' => 150_000,
                'id_transaksi' => '24.06.005',
                'id_produk' => 18
            ],
            [
                'jumlah_item' => 1,
                'harga_satuan' => 75000,
                'id_transaksi' => '24.06.006',
                'id_produk' => 19
            ],
            [
                'jumlah_item' => 1,
                'harga_satuan' => 650_000,
                'id_transaksi' => '24.06.006',
                'id_produk' => 991
            ],
            [
                'jumlah_item' => 1,
                'harga_satuan' => 350_000,
                'id_transaksi' => '24.06.006',
                'id_produk' => 993
            ],

        ]);

        DB::table('pengiriman')->insert([
            [
                'jarak_pengiriman' => 14,
                'biaya_pengiriman' => 20000,
                'tanggal_dikirim' => '2024-03-10',
                'kurir' => 'Andi',
                'alamat_tujuan' => $faker->address,

                'id_transaksi' => '24.06.001',
            ],
            [
                'jarak_pengiriman' => 5,
                'biaya_pengiriman' => 15_000,
                'tanggal_dikirim' => '2024-03-12',
                'kurir' => 'Andi',
                'alamat_tujuan' => $faker->address,

                'id_transaksi' => '24.06.002',
            ],
            [
                'jarak_pengiriman' => 8,
                'biaya_pengiriman' => 15000,
                'tanggal_dikirim' => '2024-03-17',
                'kurir' => 'Andi',
                'alamat_tujuan' => $faker->address,

                'id_transaksi' => '24.06.003',
            ],
            [
                'jarak_pengiriman' => 3,
                'biaya_pengiriman' => 10_000,
                'tanggal_dikirim' => '2024-03-17',
                'kurir' => 'Andi',
                'alamat_tujuan' => $faker->address,

                'id_transaksi' => '24.06.004',
            ],
            [
                'jarak_pengiriman' => 8,
                'biaya_pengiriman' => 15_000,
                'tanggal_dikirim' => '2024-03-25',
                'kurir' => 'Andi',
                'alamat_tujuan' => $faker->address,

                'id_transaksi' => '24.06.005',
            ],
            [
                'jarak_pengiriman' => 8,
                'biaya_pengiriman' => 15_000,
                'tanggal_dikirim' => '2024-03-25',
                'kurir' => 'Andi',
                'alamat_tujuan' => $faker->address,

                'id_transaksi' => '24.06.006',
            ],
        ]);

        DB::table('keranjang')->insert([
            [
                'tanggal_keranjang' => '2024-03-26',
                'jumlah_item_keranjang' => 2,
                'id_customer' => 1,
                'id_produk' => 1,
            ],
            [
                'tanggal_keranjang' => '2024-03-26',
                'jumlah_item_keranjang' => 1,
                'id_customer' => 1,
                'id_produk' => 2,
            ],
            [
                'tanggal_keranjang' => '2024-03-26',
                'jumlah_item_keranjang' => 2,
                'id_customer' => 1,
                'id_produk' => 3,
            ],
            [
                'tanggal_keranjang' => '2024-03-26',
                'jumlah_item_keranjang' => 1,
                'id_customer' => 2,
                'id_produk' => 1,
            ],
            [
                'tanggal_keranjang' => '2024-03-27',
                'jumlah_item_keranjang' => 1,
                'id_customer' => 2,
                'id_produk' => 15,
            ],
            [
                'tanggal_keranjang' => '2024-03-29',
                'jumlah_item_keranjang' => 1,
                'id_customer' => 5,
                'id_produk' => 10,
            ],
            [
                'tanggal_keranjang' => '2024-03-29',
                'jumlah_item_keranjang' => 1,
                'id_customer' => 5,
                'id_produk' => 11,
            ],
            [
                'tanggal_keranjang' => '2024-03-29',
                'jumlah_item_keranjang' => 1,
                'id_customer' => 5,
                'id_produk' => 16,
            ],
        ]);
    }
}
