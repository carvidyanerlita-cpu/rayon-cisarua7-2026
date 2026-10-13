<?php

// 1. Muat Autoloader dari Composer
require __DIR__ . '/../vendor/autoload.php';

// 2. Tentukan direktori temporary & file SQLite di Serverless Vercel
$storagePath = '/tmp/storage';
$viewsPath = '/tmp/storage/framework/views';
$sessionsPath = '/tmp/storage/framework/sessions';
$cachePath = '/tmp/storage/framework/cache';
$dbPath = '/tmp/database.sqlite';

if (!file_exists($viewsPath)) {
    mkdir($viewsPath, 0777, true);
}
if (!file_exists($sessionsPath)) {
    mkdir($sessionsPath, 0777, true);
}
if (!file_exists($cachePath)) {
    mkdir($cachePath, 0777, true);
}

$isNewDb = !file_exists($dbPath);
if ($isNewDb) {
    touch($dbPath);
}

// 3. Set Environment Variables wajib
putenv("VIEW_COMPILED_PATH={$viewsPath}");
$_ENV['VIEW_COMPILED_PATH'] = $viewsPath;
$_SERVER['VIEW_COMPILED_PATH'] = $viewsPath;

putenv("DB_CONNECTION=sqlite");
$_ENV['DB_CONNECTION'] = 'sqlite';
$_SERVER['DB_CONNECTION'] = 'sqlite';

putenv("DB_DATABASE={$dbPath}");
$_ENV['DB_DATABASE'] = $dbPath;
$_SERVER['DB_DATABASE'] = $dbPath;

putenv("SESSION_DRIVER=file");
$_ENV['SESSION_DRIVER'] = 'file';
$_SERVER['SESSION_DRIVER'] = 'file';

// 4. Inisialisasi aplikasi Laravel
$app = require __DIR__ . '/../bootstrap/app.php';
$app->useStoragePath($storagePath);

// 5. Jalankan Migration & Seeder otomatis hanya jika DB baru dibuat
if ($isNewDb) {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh', [
            '--force' => true,
            '--seed' => true
        ]);
    } catch (\Throwable $e) {
        // Fallback jika seeder error, tetap jalankan migrasi dasar
        try {
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        } catch (\Throwable $ex) {
            // Silence error
        }
    }
}

// 6. Tangani HTTP Request
$request = Illuminate\Http\Request::capture();
$response = $app->handleRequest($request);
$response->send();