<?php
// Öğrenci kontrolü
if (!$current_user || $current_user['role'] !== 'student') {
    header('Location: /dashboard');
    exit;
}
?>

<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Cüzdanım</h1>
            <p class="text-gray-600">Kazançlarınızı yönetin ve para çekme işlemleri yapın</p>
        </div>
        
        <!-- Wallet Balance -->
        <div class="bg-gradient-to-r from-green-600 to-blue-600 rounded-lg p-8 text-white mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="text-3xl font-bold mb-2" id="available-balance">₺0.00</div>
                    <div class="text-green-100">Çekilebilir Bakiye</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold mb-2" id="pending-balance">₺0.00</div>
                    <div class="text-blue-100">Bekleyen Bakiye</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold mb-2" id="total-earned">₺0.00</div>
                    <div class="text-purple-100">Toplam Kazanç</div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Para Çekme</h3>
                <form id="withdrawal-form" class="space-y-4">
                    <div>
                        <label for="withdrawal_amount" class="block text-sm font-medium text-gray-700 mb-2">
                            Çekilecek Tutar
                        </label>
                        <input
                            type="number"
                            id="withdrawal_amount"
                            name="withdrawal_amount"
                            min="10"
                            step="0.01"
                            class="w-full"
                            placeholder="Minimum ₺10"
                            required
                        />
                    </div>
                    
                    <div>
                        <label for="iban" class="block text-sm font-medium text-gray-700 mb-2">
                            IBAN
                        </label>
                        <input
                            type="text"
                            id="iban"
                            name="iban"
                            class="w-full"
                            placeholder="TR00 0000 0000 0000 0000 0000 00"
                            required
                        />
                    </div>
                    
                    <div>
                        <label for="account_holder" class="block text-sm font-medium text-gray-700 mb-2">
                            Hesap Sahibi
                        </label>
                        <input
                            type="text"
                            id="account_holder"
                            name="account_holder"
                            value="<?php echo htmlspecialchars($current_user['full_name']); ?>"
                            class="w-full"
                            required
                        />
                    </div>
                    
                    <button type="submit" class="w-full btn btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Para Çekme Talebi Oluştur
                    </button>
                </form>
            </div>
            
            <!-- Bank Info -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Banka Bilgileri</h3>
                <div class="space-y-4">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Kayıtlı IBAN</h4>
                        <p class="text-sm text-gray-600" id="saved-iban">Henüz IBAN kaydedilmedi</p>
                    </div>
                    
                    <div class="p-4 bg-blue-50 rounded-lg">
                        <h4 class="text-sm font-medium text-blue-900 mb-2">Para Çekme Kuralları</h4>
                        <ul class="text-sm text-blue-800 space-y-1">
                            <li>• Minimum çekim tutarı ₺10</li>
                            <li>• İşlem süresi 1-3 iş günü</li>
                            <li>• Haftalık maksimum ₺1000</li>
                            <li>• İşlem ücreti yoktur</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Transaction History -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">İşlem Geçmişi</h3>
            
            <div id="transactions-container" class="space-y-4">
                <!-- Loading skeleton -->
                <div class="animate-pulse">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gray-200 rounded-lg"></div>
                        <div class="flex-1">
                            <div class="h-4 bg-gray-200 rounded mb-1"></div>
                            <div class="h-3 bg-gray-200 rounded w-3/4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadWalletData();
    loadTransactionHistory();
    
    document.getElementById('withdrawal-form').addEventListener('submit', handleWithdrawal);
});

async function loadWalletData() {
    try {
        // Mock data - API endpoint eklenecek
        const wallet = {
            balance: 125.75,
            pending_balance: 45.50,
            total_earned: 450.25,
            iban: 'TR12 3456 7890 1234 5678 9012 34'
        };
        
        document.getElementById('available-balance').textContent = `₺${wallet.balance.toFixed(2)}`;
        document.getElementById('pending-balance').textContent = `₺${wallet.pending_balance.toFixed(2)}`;
        document.getElementById('total-earned').textContent = `₺${wallet.total_earned.toFixed(2)}`;
        
        if (wallet.iban) {
            document.getElementById('saved-iban').textContent = wallet.iban;
            document.getElementById('iban').value = wallet.iban;
        }
        
    } catch (error) {
        console.error('Error loading wallet data:', error);
    }
}

async function loadTransactionHistory() {
    try {
        // Mock data - API endpoint eklenecek
        const transactions = [
            { id: 1, type: 'earning', amount: 15.50, description: 'Taze Domates satışı', date: '2025-08-20', status: 'completed' },
            { id: 2, type: 'payout', amount: -50.00, description: 'Para çekme', date: '2025-08-19', status: 'completed' },
            { id: 3, type: 'earning', amount: 8.25, description: 'Organik Salatalık satışı', date: '2025-08-19', status: 'completed' },
            { id: 4, type: 'payout', amount: -100.00, description: 'Para çekme', date: '2025-08-18', status: 'processing' }
        ];
        
        const container = document.getElementById('transactions-container');
        
        if (transactions.length === 0) {
            container.innerHTML = '<div class="text-center text-gray-500 py-8">Henüz işlem geçmişi bulunmamaktadır.</div>';
            return;
        }
        
        container.innerHTML = transactions.map(transaction => `
            <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg">
                <div class="w-10 h-10 bg-${transaction.type === 'earning' ? 'green' : 'blue'}-100 rounded-lg flex items-center justify-center">
                    ${transaction.type === 'earning' ? `
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    ` : `
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    `}
                </div>
                
                <div class="flex-1">
                    <div class="flex items-center justify-between">
                        <h4 class="text-sm font-medium text-gray-900">
                            ${transaction.description}
                        </h4>
                        <span class="text-lg font-semibold ${transaction.amount > 0 ? 'text-green-600' : 'text-red-600'}">
                            ${transaction.amount > 0 ? '+' : ''}₺${Math.abs(transaction.amount).toFixed(2)}
                        </span>
                    </div>
                    <div class="flex items-center justify-between mt-1">
                        <p class="text-xs text-gray-500">${formatDate(transaction.date)}</p>
                        <span class="badge badge-${getTransactionStatusBadge(transaction.status)}">
                            ${getTransactionStatusText(transaction.status)}
                        </span>
                    </div>
                </div>
            </div>
        `).join('');
        
    } catch (error) {
        console.error('Error loading transaction history:', error);
    }
}

async function handleWithdrawal(e) {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const amount = parseFloat(formData.get('withdrawal_amount'));
    const iban = formData.get('iban');
    const accountHolder = formData.get('account_holder');
    
    if (amount < 10) {
        showToast('Minimum çekim tutarı ₺10\'dur', 'error');
        return;
    }
    
    try {
        // API endpoint eklenecek
        const data = {
            amount: amount,
            iban: iban,
            account_holder: accountHolder
        };
        
        showToast('Para çekme talebiniz oluşturuldu!', 'success');
        e.target.reset();
        
        // Reload data
        setTimeout(() => {
            loadWalletData();
            loadTransactionHistory();
        }, 1000);
        
    } catch (error) {
        showToast(error.message, 'error');
    }
}

function getTransactionStatusText(status) {
    const statusTexts = {
        completed: 'Tamamlandı',
        processing: 'İşleniyor',
        failed: 'Başarısız',
        pending: 'Beklemede'
    };
    return statusTexts[status] || status;
}

function getTransactionStatusBadge(status) {
    const badgeClasses = {
        completed: 'success',
        processing: 'warning',
        failed: 'error',
        pending: 'gray'
    };
    return badgeClasses[status] || 'gray';
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('tr-TR', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}
</script>
