# EsnappGO - PHP E-ticaret Platformu

Türkiye'nin ilk öğrenci destekli e-ticaret platformu - PHP versiyonu

## 📋 Proje Hakkında

EsnappGO, geleneksel e-ticaret modelini yeniden tanımlayarak, her alışverişin topluma değer katmasını sağlayan bir platformdur. Üniversite öğrencilerinin sahadan çektiği gerçek ürün fotoğrafları ile yerel esnafların onayladığı kaliteli ürünleri bir araya getiriyoruz.

### 🎯 Özellikler

- **Öğrenci Destekli Model**: Öğrenciler ürün fotoğrafları çekerek gelir elde eder
- **Esnaf Güvencesi**: Her ürün yerel esnaflar tarafından onaylanır
- **Güvenli Alışveriş**: Kalite ve fiyat garantili ürünler
- **Sosyal Etki**: Her alışveriş öğrencileri destekler ve yerel ekonomiye katkı sağlar

## 🚀 Hızlı Başlangıç

### Gereksinimler

- PHP 7.4 veya üzeri
- SQLite3 desteği
- Web sunucusu (Apache, Nginx veya PHP built-in server)

### Kurulum

1. **Projeyi indirin veya klonlayın**
   ```bash
   git clone [repository-url]
   cd esnappgo-php
   ```

2. **Tek komutla başlatın**
   ```bash
   start-esnappgo.bat
   ```

Bu komut:
- PHP'nin yüklü olduğunu kontrol eder
- Veritabanını oluşturur ve örnek verilerle doldurur
- PHP built-in server'ı başlatır
- Projeyi http://localhost:8080 adresinde çalıştırır

### Manuel Kurulum

1. **Veritabanını oluşturun**
   ```bash
   php setup-database.php
   ```

2. **Sunucuyu başlatın**
   ```bash
   php -S localhost:8080
   ```

## 👥 Test Kullanıcıları

Kurulum sonrası aşağıdaki test kullanıcılarıyla giriş yapabilirsiniz:

| Rol | E-posta | Şifre | Özellikler |
|-----|---------|-------|------------|
| Admin | admin@esnappgo.com | admin123 | Tüm yönetim panelleri, anket sonuçları |
| Öğrenci | ogrenci@test.com | student123 | Ürün yükleme, kazanç takibi, cüzdan |
| Esnaf | esnaf@test.com | esnaf123 | Ürün onaylama, sipariş yönetimi, mağaza |
| Müşteri | musteri@test.com | musteri123 | Alışveriş, sepet, favoriler, siparişler |

## 💳 Ödeme Sistemi

Şu anda **Havale/EFT** ile ödeme kabul edilmektedir:
- Banka: Türkiye İş Bankası
- IBAN: TR12 0006 4000 0011 2345 6789 01
- Hesap Sahibi: EsnappGO Teknoloji A.Ş.
- Dekont yükleme zorunludur

## 🏗️ Proje Yapısı

```
esnappgo-php/
├── php-backend/           # Backend API dosyaları
│   ├── config/           # Konfigürasyon dosyaları
│   ├── includes/         # Yardımcı sınıflar
│   └── api/             # API endpoint'leri
├── pages/               # Frontend sayfaları
├── components/          # Yeniden kullanılabilir bileşenler
├── media/              # Yüklenen dosyalar
├── index.php           # Ana giriş dosyası
├── setup-database.php  # Veritabanı kurulum scripti
└── start-esnappgo.bat  # Hızlı başlatma dosyası
```

## 🔧 API Endpoints

### Kimlik Doğrulama
- `POST /api/auth/register` - Kullanıcı kaydı
- `POST /api/auth/login` - Giriş yapma
- `POST /api/auth/logout` - Çıkış yapma
- `GET /api/auth/me` - Mevcut kullanıcı bilgileri

### Ürünler
- `GET /api/products` - Ürün listesi
- `GET /api/products/{id}` - Tek ürün detayı
- `POST /api/products` - Yeni ürün oluşturma

### Sepet
- `GET /api/cart` - Sepet içeriği
- `POST /api/cart` - Sepete ürün ekleme
- `DELETE /api/cart/{id}` - Sepetten ürün çıkarma

### Siparişler
- `GET /api/orders` - Sipariş listesi
- `POST /api/orders` - Yeni sipariş oluşturma

## 🎨 Teknolojiler

- **Backend**: PHP 7.4+, SQLite3
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Styling**: Tailwind CSS (CDN)
- **Icons**: Heroicons
- **Database**: SQLite3

## 📱 Sayfalar

### Genel Sayfalar
- Ana Sayfa (`/`)
- Ürünler (`/products`)
- Ürün Detayı (`/products/{id}`)
- Hakkımızda (`/about`)
- İletişim (`/contact`)
- Yardım (`/help`)

### Kullanıcı Sayfaları
- Giriş (`/login`)
- Kayıt (`/register`)
- Dashboard (`/dashboard`)
- Profil (`/profile`)
- Sepet (`/cart`)
- Siparişler (`/orders`)

### Özel Sayfalar
- Anket (`/survey`)
- Mağaza Detayı (`/shops/{id}`)

## 🔐 Güvenlik

- Şifreler bcrypt ile hashlenir
- SQL injection koruması (Prepared statements)
- XSS koruması (HTML escaping)
- CSRF koruması (Session-based)

## 🚀 Dağıtım

### Yerel Sunucu
```bash
php -S localhost:8080
```

### Apache/Nginx
- Proje dosyalarını web sunucusunun root dizinine kopyalayın
- `.htaccess` dosyası oluşturun (Apache için)
- URL rewriting'i etkinleştirin

## 🤝 Katkıda Bulunma

1. Fork yapın
2. Feature branch oluşturun (`git checkout -b feature/AmazingFeature`)
3. Değişikliklerinizi commit edin (`git commit -m 'Add some AmazingFeature'`)
4. Branch'inizi push edin (`git push origin feature/AmazingFeature`)
5. Pull Request oluşturun

## 📄 Lisans

Bu proje MIT lisansı altında lisanslanmıştır. Detaylar için `LICENSE` dosyasına bakın.

## 📞 İletişim

- **E-posta**: info@esnappgo.com
- **Website**: https://esnappgo.com
- **Destek**: help@esnappgo.com

## 🎉 Teşekkürler

EsnappGO'yu tercih ettiğiniz için teşekkürler! Öğrenci destekli e-ticaret devrimi için birlikte çalışıyoruz.

---

**EsnappGO** - Alışveriş yap, değer yarat, geleceği şekillendir! 🛒✨