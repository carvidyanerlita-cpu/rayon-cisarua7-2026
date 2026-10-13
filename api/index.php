<?php

// 1. Muat Autoloader dari Composer
require __DIR__ . '/../vendor/autoload.php';

// 2. Buat direktori temporary & file SQLite di Serverless Vercel
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
if (!file_exists($dbPath)) {
    touch($dbPath);
}

// 3. Set Environment Variable untuk Path Temp & SQLite
putenv("VIEW_COMPILED_PATH={$viewsPath}");
$_ENV['VIEW_COMPILED_PATH'] = $viewsPath;
$_SERVER['VIEW_COMPILED_PATH'] = $viewsPath;

putenv("DB_DATABASE={$dbPath}");
$_ENV['DB_DATABASE'] = $dbPath;
$_SERVER['DB_DATABASE'] = $dbPath;

// 4. Inisialisasi aplikasi Laravel
$app = require __DIR__ . '/../bootstrap/app.php';

// Arahkan storage path utama
$app->useStoragePath($storagePath);

// 5. Tangani HTTP Request
$request = Illuminate\Http\Request::capture();
$response = $app->handleRequest($request);
$response->send();