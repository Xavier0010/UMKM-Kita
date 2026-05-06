<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Store;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class NativeDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create dummy seller
        $seller = User::firstOrCreate(
            ['email' => 'penjual@umkm.com'],
            [
                'name' => 'Budi Penjual',
                'password' => bcrypt('123456'),
                'role' => 'seller',
                'phone' => '08123456789',
                'address' => 'Sidoarjo'
            ]
        );

        // 2. Create dummy store
        $store = Store::firstOrCreate(
            ['user_id' => $seller->id],
            [
                'name' => 'Toko Budi',
                'slug' => 'toko-budi',
                'description' => 'Toko Budi yang menjual aneka macam produk UMKM.',
                'address' => 'Sidoarjo',
                'phone' => '08123456789',
                'status' => 'approved'
            ]
        );

        // 3. Create Categories
        $catMakanan = Category::firstOrCreate(['name' => 'Makanan'], ['slug' => 'makanan', 'description' => 'Kategori Makanan']);
        $catMinuman = Category::firstOrCreate(['name' => 'Minuman'], ['slug' => 'minuman', 'description' => 'Kategori Minuman']);
        $catKerajinan = Category::firstOrCreate(['name' => 'Kerajinan'], ['slug' => 'kerajinan', 'description' => 'Kategori Kerajinan']);

        // 4. Products from versi_native
        $products = [
            [
                'name' => 'Keripik Pisang Coklat',
                'price' => 15000,
                'main_image' => 'produk1.jpg',
                'description' => 'Keripik pisang renyah dengan balutan coklat lumer yang manis dan gurih. Cocok untuk cemilan sore bersama keluarga.',
                'category_id' => $catMakanan->id,
            ],
            [
                'name' => 'Sambal Roa Khas',
                'price' => 25000,
                'main_image' => 'produk2.jpg',
                'description' => 'Sambal roa asli dengan level pedas yang pas untuk teman makan nasi. Dibuat dari ikan roa pilihan.',
                'category_id' => $catMakanan->id,
            ],
            [
                'name' => 'Kopi Bubuk Robusta',
                'price' => 35000,
                'main_image' => 'produk3.jpg',
                'description' => 'Kopi robusta pilihan hasil panen petani lokal dengan aroma khas yang menggugah selera.',
                'category_id' => $catMinuman->id,
            ],
            [
                'name' => 'Kerajinan Tas Anyaman',
                'price' => 85000,
                'main_image' => 'produk4.jpg',
                'description' => 'Tas anyaman cantik yang dibuat dengan tangan oleh pengrajin lokal untuk kebutuhan fashion Anda.',
                'category_id' => $catKerajinan->id,
            ],
            [
                'name' => 'Madu Hutan Asli',
                'price' => 65000,
                'main_image' => 'produk5.jpg',
                'description' => 'Madu hutan murni tanpa campuran, diambil langsung dari lebah liar di hutan tropis.',
                'category_id' => $catMinuman->id,
            ],
            [
                'name' => 'Batik Tulis Motif Bunga',
                'price' => 120000,
                'main_image' => 'produk6.jpg',
                'description' => 'Batik tulis asli dengan motif bunga khas Nusantara, cocok untuk acara formal maupun kasual.',
                'category_id' => $catKerajinan->id,
            ],
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(
                ['name' => $p['name']],
                [
                    'store_id' => $store->id,
                    'category_id' => $p['category_id'],
                    'slug' => Str::slug($p['name']),
                    'description' => $p['description'],
                    'price' => $p['price'],
                    'stock' => 50,
                    'main_image' => $p['main_image'],
                    'is_active' => true,
                ]
            );
        }
    }
}
