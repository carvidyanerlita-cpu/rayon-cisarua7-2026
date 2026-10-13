<?php

// 1. Buat direktori temporary yang dibutuhkan Laravel di Serverless Vercel
$storagePath = '/tmp/storage';
$viewsPath = '/tmp/storage/framework/views';
$sessionsPath = '/tmp/storage/framework/sessions';
$cachePath = '/tmp/storage/framework/cache';

if (!file_exists($viewsPath)) {
    mkdir($viewsPath, 0777, true);
}
if (!file_exists($sessionsPath)) {
    mkdir($sessionsPath, 0777, true);
}
if (!file_exists($cachePath)) {
    mkdir($cachePath, 0777, true);
}

// 2. Set environment variable untuk Blade compiled view path
putenv("VIEW_COMPILED_PATH={$viewsPath}");
$_ENV['VIEW_COMPILED_PATH'] = $viewsPath;
$_SERVER['VIEW_COMPILED_PATH'] = $viewsPath;

// 3. Inisialisasi aplikasi Laravel
$app = require __DIR__ . '/../bootstrap/app.php';

// Arahkan storage path utama
$app->useStoragePath($storagePath);

// 4. Tangani HTTP Request
$request = Illuminate\Http\Request::capture();
$response = $app->handleRequest($request);
$response->send();