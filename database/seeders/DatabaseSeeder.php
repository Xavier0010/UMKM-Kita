<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::firstOrCreate(
            ['email' => 'admin@umkmkita.id'],
            [
                'name'     => 'Admin UMKM Kita',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
            ]
        );

        // Default categories
        $categories = [
            ['name' => 'Makanan & Minuman',    'slug' => 'makanan-minuman',    'icon' => '🍜'],
            ['name' => 'Fashion & Aksesoris',  'slug' => 'fashion-aksesoris',  'icon' => '👗'],
            ['name' => 'Kerajinan Tangan',     'slug' => 'kerajinan-tangan',   'icon' => '🎨'],
            ['name' => 'Elektronik & Gadget',  'slug' => 'elektronik-gadget',  'icon' => '📱'],
            ['name' => 'Kesehatan & Kecantikan','slug' => 'kesehatan-kecantikan','icon' => '💆'],
            ['name' => 'Rumah Tangga',         'slug' => 'rumah-tangga',       'icon' => '🏠'],
            ['name' => 'Lainnya',              'slug' => 'lainnya',            'icon' => '📦'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
