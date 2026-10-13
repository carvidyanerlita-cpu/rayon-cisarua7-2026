<?php

// 1. Arahkan direktori penyimpanan temporary Laravel ke folder /tmp bawaan Vercel
$app = require __DIR__ . '/../bootstrap/app.php';

# Memastikan folder /tmp/storage tersedia agar Laravel tidak crash saat menulis cache/session
$storagePath = '/tmp/storage';
if (!file_exists($storagePath)) {
    mkdir($storagePath . '/framework/views', 0755, true);
    mkdir($storagePath . '/framework/sessions', 0755, true);
    mkdir($storagePath . '/framework/cache', 0755, true);
    mkdir($storagePath . '/logs', 0755, true);
}

$app->useStoragePath($storagePath);

// 2. Jalankan penanganan request
$request = Illuminate\Http\Request::capture();
$response = $app->handleRequest($request);
$response->send();