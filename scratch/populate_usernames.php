<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Str;

User::all()->each(function($user) {
    if (!$user->username) {
        $username = Str::slug($user->name, '');
        // Ensure uniqueness
        $count = 1;
        $original = $username;
        while (User::where('username', $username)->exists()) {
            $username = $original . $count++;
        }
        $user->username = $username;
        $user->save();
        echo "Updated user {$user->name} with username: {$user->username}\n";
    }
});
