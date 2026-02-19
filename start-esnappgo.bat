@echo off
title EsnappGO - PHP E-ticaret Platformu (RESTART MODE)
color 0A

echo.
echo ========================================
echo    EsnappGO FULL RESTART MODE
echo ========================================
echo.

REM Mevcut PHP sunucularını kapat
echo Mevcut PHP sunuculari kapatiliyor...
taskkill /F /IM php.exe >nul 2>&1
timeout /t 2 /nobreak >nul

REM Port 8080'i temizle
echo Port 8080 temizleniyor...
netstat -ano | findstr :8080 >nul
if not errorlevel 1 (
    for /f "tokens=5" %%a in ('netstat -ano ^| findstr :8080') do (
        taskkill /F /PID %%a >nul 2>&1
    )
)
timeout /t 1 /nobreak >nul

REM PHP sürümünü kontrol et
php --version >nul 2>&1
if errorlevel 1 (
    echo HATA: PHP yuklu degil veya PATH'de tanimli degil!
    echo.
    echo PHP yuklemek icin:
    echo 1. https://www.php.net/downloads.php adresinden PHP indirin
    echo 2. PHP'yi C:\php gibi bir klasore cikarin
    echo 3. C:\php'yi sistem PATH'ine ekleyin
    echo.
    pause
    exit /b 1
)

echo PHP surumu kontrol ediliyor...
php --version | findstr /C:"PHP"
echo.

REM Cache ve session temizliği
echo Cache ve session dosyalari temizleniyor...
if exist "php-backend\cache" (
    rmdir /s /q "php-backend\cache" >nul 2>&1
)
if exist "php-backend\sessions" (
    rmdir /s /q "php-backend\sessions" >nul 2>&1
)
if exist "tmp" (
    rmdir /s /q "tmp" >nul 2>&1
)
echo Cache temizlendi.
echo.

REM Veritabanı kontrolü
echo Veritabani kontrol ediliyor...
if exist "php-backend\esnappgo.db" (
    echo Mevcut veritabani bulundu - korunuyor.
    echo Veritabani verileriniz guvende!
) else (
    echo Veritabani bulunamadi, yeni olusturuluyor...
    echo.
    php setup-database.php
    echo.
    if errorlevel 1 (
        echo HATA: Veritabani kurulumu basarisiz!
        pause
        exit /b 1
    )
    echo Veritabani basariyla olusturuldu!
)
echo.

REM Media klasörünü oluştur
if not exist "media" (
    mkdir media
    echo Media klasoru olusturuldu.
)

echo ========================================
echo   TEMIZ BASLATMA TAMAMLANDI!
echo ========================================
echo.

REM Son kontroller
echo Son kontroller yapiliyor...
timeout /t 2 /nobreak >nul

echo Sunucu baslatiliyor...
echo.
echo ========================================
echo   Sunucu Bilgileri:
echo   - URL: http://localhost:8080
echo   - Backend API: http://localhost:8080/api
echo   - Media: http://localhost:8080/media
echo ========================================
echo.

REM Test kullanıcıları göster
echo Test Kullanicilari:
echo - Admin: admin@esnappgo.com / admin123
echo - Ogrenci: ogrenci@test.com / student123
echo - Esnaf: esnaf@test.com / esnaf123
echo - Musteri: musteri@test.com / musteri123
echo.

echo ========================================
echo   SUNUCU CALISIYOR! CTRL+C ile durdurun
echo   Tarayiciyi acip http://localhost:8080
echo   adresine gidin!
echo ========================================
echo.

REM PHP built-in server'ı router ile başlat (verbose mode)
php -S localhost:8080 -t . router.php -d display_errors=1 -d log_errors=1

REM Sunucu kapandığında
echo.
echo Sunucu durduruldu.
pause
