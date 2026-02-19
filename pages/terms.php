<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Kullanım Koşulları</h1>
            <p class="text-lg text-gray-600">
                EsnappGO platformu kullanım koşulları ve kuralları
            </p>
        </div>
        
        <!-- Content -->
        <div class="bg-white rounded-lg shadow-sm p-8 prose prose-lg max-w-none">
            <div id="terms-content">
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
    loadTermsContent();
});

async function loadTermsContent() {
    try {
        const response = await apiCall('pages/terms');
        
        if (response.success) {
            const page = response.data;
            document.getElementById('terms-content').innerHTML = page.content;
            document.getElementById('last-updated').textContent = `Son güncelleme: ${formatDate(page.updated_at)}`;
        } else {
            // Fallback content
            document.getElementById('terms-content').innerHTML = getDefaultTermsContent();
        }
        
    } catch (error) {
        console.error('Error loading terms:', error);
        document.getElementById('terms-content').innerHTML = getDefaultTermsContent();
    }
}

function getDefaultTermsContent() {
    return `
        <h2>EsnappGO Kullanım Koşulları</h2>
        
        <h3>1. Genel Hükümler</h3>
        <p>Bu kullanım koşulları, EsnappGO platformunu kullanan tüm kullanıcılar için geçerlidir. Platformu kullanarak bu koşulları kabul etmiş sayılırsınız.</p>
        
        <h3>2. Kullanıcı Sorumlulukları</h3>
        <p>Kullanıcılar, platform kurallarına uymak ve doğru bilgiler vermekle yükümlüdür. Yanlış veya yanıltıcı bilgi vermek yasaktır.</p>
        
        <h3>3. Ürün Paylaşımı (Öğrenciler İçin)</h3>
        <p>Öğrenciler, paylaştıkları ürün fotoğraflarının gerçek ve güncel olmasından sorumludur. Sahte veya yanıltıcı içerik paylaşmak yasaktır.</p>
        
        <h3>4. Esnaf Sorumlulukları</h3>
        <p>Esnaflar, onayladıkları ürünlerin kalitesi ve fiyat doğruluğundan sorumludur. Müşteri memnuniyeti önceliktir.</p>
        
        <h3>5. Ödeme ve İade</h3>
        <p>Tüm ödemeler güvenli ödeme sistemleri üzerinden yapılır. İade koşulları ürün kategorisine göre değişiklik gösterebilir.</p>
        
        <h3>6. Gizlilik</h3>
        <p>Kullanıcı verileri gizlilik politikamız doğrultusunda korunur. Kişisel veriler üçüncü taraflarla paylaşılmaz.</p>
        
        <h3>7. Hesap İptali</h3>
        <p>EsnappGO, kurallara uymayan kullanıcıların hesaplarını askıya alma veya iptal etme hakkını saklı tutar.</p>
        
        <h3>8. Değişiklikler</h3>
        <p>Bu koşullar zaman zaman güncellenebilir. Önemli değişiklikler kullanıcılara bildirilir.</p>
        
        <h3>9. İletişim</h3>
        <p>Sorularınız için info@esnappgo.com adresinden bizimle iletişime geçebilirsiniz.</p>
    `;
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('tr-TR', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
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
</style>
