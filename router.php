<?php
// PHP Built-in Server Router
// Bu dosya tüm istekleri index.php'ye yönlendirir

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Statik dosyalar için (css, js, images, media)
if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|ico|svg|woff|woff2|ttf|eot)$/', $path)) {
    return false; // Dosyayı doğrudan sun
}

// API ve media klasörü için
if (preg_match('/^\/(?:api|media)/', $path)) {
    return false;
}

// Tüm diğer istekleri index.php'ye yönlendir
$_SERVER['SCRIPT_NAME'] = '/index.php';
require 'index.php';

