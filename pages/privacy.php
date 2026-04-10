<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Gizlilik Politikası</h1>
            <p class="text-lg text-gray-600">
                Kişisel verilerinizin korunması ve işlenmesi hakkında bilgiler
            </p>
        </div>
        
        <!-- Content -->
        <div class="bg-white rounded-lg shadow-sm p-8 prose prose-lg max-w-none">
            <div id="privacy-content">
                <!-- Loading state -->
                <div class="animate-pulse">
                    <div class="h-6 bg-gray-200 rounded mb-4"></div>
                    <div class="h-4 bg-gray-200 rounded mb-2"></div>
                    <div class="h-4 bg-gray-200 rounded mb-2"></div>
                    <div class="h-4 bg-gray-200 rounded w-3/4 mb-6"></div>
                    <div class="h-6 bg-gray-200 rounded mb-4"></div>
                    <div class="h-4 bg-gray-200 rounded mb-2"></div>
                    <div class="h-4 bg-gray-200 rounded mb-2"></div>
                </div>
            </div>
        </div>
        
        <!-- Last Updated -->
        <div class="text-center mt-8">
            <p class="text-sm text-gray-500" id="last-updated">
                Son güncelleme: -
            </p>
        </div>
        
        <!-- Back to Home -->
        <div class="text-center mt-8">
            <a href="/" class="btn btn-outline">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Ana Sayfaya Dön
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
   
    document.getElementById('privacy-content').innerHTML = getDefaultPrivacyContent();
    

    document.getElementById('last-updated').textContent = `Son güncelleme: Nisan 2026`;
});

function getDefaultPrivacyContent() {
    return `
        <h2>EsnappGO Gizlilik Politikası</h2>
        
        <h3>1. Veri Toplama</h3>
        <p>EsnappGO olarak, platformumuzun işleyişi için gerekli olan kişisel verilerinizi topluyoruz. Bu veriler şunları içerir:</p>
        <ul>
            <li>Ad, soyad ve iletişim bilgileri</li>
            <li>E-posta adresi ve telefon numarası</li>
            <li>Adres bilgileri (teslimat için)</li>
            <li>Ödeme bilgileri (güvenli şekilde şifrelenir)</li>
            <li>Platform kullanım verileri</li>
        </ul>
        
        <h3>2. Veri Kullanımı</h3>
        <p>Topladığımız veriler şu amaçlarla kullanılır:</p>
        <ul>
            <li>Hesap oluşturma ve yönetimi</li>
            <li>Sipariş işleme ve teslimat</li>
            <li>Müşteri desteği sağlama</li>
            <li>Platform güvenliğini sağlama</li>
            <li>Yasal yükümlülüklerin yerine getirilmesi</li>
        </ul>
        
        <h3>3. Veri Paylaşımı</h3>
        <p>Kişisel verileriniz aşağıdaki durumlar dışında üçüncü taraflarla paylaşılmaz:</p>
        <ul>
            <li>Yasal zorunluluklar</li>
            <li>Güvenlik ihlalleri</li>
            <li>İş ortaklarımız (sadece gerekli veriler)</li>
        </ul>
        
        <h3>4. Veri Güvenliği</h3>
        <p>Verilerinizin güvenliği için şu önlemleri alıyoruz:</p>
        <ul>
            <li>SSL şifreleme</li>
            <li>Güvenli veri tabanları</li>
            <li>Erişim kontrolü</li>
            <li>Düzenli güvenlik denetimleri</li>
        </ul>
        
        <h3>5. Çerezler (Cookies)</h3>
        <p>Platformumuz, kullanıcı deneyimini iyileştirmek için çerezler kullanır. Çerezleri tarayıcı ayarlarınızdan kontrol edebilirsiniz.</p>
        
        <h3>6. Kullanıcı Hakları</h3>
        <p>KVKK kapsamında sahip olduğunuz haklar:</p>
        <ul>
            <li>Verilerinizi görme hakkı</li>
            <li>Düzeltme hakkı</li>
            <li>Silme hakkı</li>
            <li>İşlemeyi durdurma hakkı</li>
            <li>Veri taşınabilirliği hakkı</li>
        </ul>
        
        <h3>7. İletişim</h3>
        <p>Gizlilik politikası ile ilgili sorularınız için:</p>
        <p><strong>E-posta:</strong> privacy@esnappgo.com</p>
        
        <h3>8. Değişiklikler</h3>
        <p>Bu gizlilik politikası zaman zaman güncellenebilir. Önemli değişiklikler kullanıcılara bildirilir.</p>
    `;
}
</script>

<style>
.prose h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: rgb(17 24 39);
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.prose h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: rgb(55 65 81);
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
}

.prose p {
    margin-bottom: 1rem;
    line-height: 1.7;
    color: rgb(75 85 99);
}

.prose ul {
    list-style-type: disc;
    margin-left: 1.5rem;
    margin-bottom: 1rem;
}

.prose li {
    margin-bottom: 0.5rem;
    color: rgb(75 85 99);
}
</style>
