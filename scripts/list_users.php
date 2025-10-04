<?php
// Bootstraps the Laravel application and lists up to 20 users.
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$users = User::take(20)->get();
if ($users->isEmpty()) {
    echo "No users found\n";
    exit(0);
}
foreach ($users as $u) {
    echo sprintf("%d - %s - %s\n", $u->id, $u->name ?? '(no name)', $u->email);
}
