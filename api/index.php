<?php

require __DIR__ . '/../vendor/autoload.php';

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

// Copy database.sqlite dari repo ke /tmp jika belum ada
if (!file_exists($dbPath)) {
    $sourceDb = __DIR__ . '/../database/database.sqlite';
    if (file_exists($sourceDb)) {
        copy($sourceDb, $dbPath);
    } else {
        touch($dbPath);
    }
}

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

$app = require __DIR__ . '/../bootstrap/app.php';
$app->useStoragePath($storagePath);

// Penanganan Request yang aman untuk Laravel 10/11/12
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);