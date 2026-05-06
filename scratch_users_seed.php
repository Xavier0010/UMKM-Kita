<?php

use App\Models\User;

echo "Seeding additional users...\n";

User::updateOrCreate(
    ['email' => 'user@umkm.com'],
    [
        'name' => 'Admin User',
        'password' => bcrypt('123456'),
        'role' => 'admin',
    ]
);

User::updateOrCreate(
    ['email' => 'pembeli@umkm.com'],
    [
        'name' => 'Siti Pembeli',
        'password' => bcrypt('123456'),
        'role' => 'buyer', // 'pembeli'
    ]
);

echo "Additional users seeded!\n";
