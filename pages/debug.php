<?php
// Admin kontrolü
if (!$current_user || $current_user['role'] !== 'admin') {
    header('Location: /login');
    exit;
}
?>

<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Debug Bilgileri</h1>
            <p class="text-gray-600">Sistem durumu ve debug bilgileri</p>
        </div>
        
        <!-- System Info -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- PHP Info -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">PHP Bilgileri</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">PHP Sürümü:</span>
                        <span class="font-medium"><?php echo phpversion(); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Memory Limit:</span>
                        <span class="font-medium"><?php echo ini_get('memory_limit'); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Max Upload Size:</span>
                        <span class="font-medium"><?php echo ini_get('upload_max_filesize'); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Session Status:</span>
                        <span class="font-medium"><?php echo session_status() === PHP_SESSION_ACTIVE ? 'Aktif' : 'Pasif'; ?></span>
                    </div>
                </div>
            </div>
            
            <!-- Database Info -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Veritabanı Bilgileri</h3>
                <div id="db-info" class="space-y-3">
                    <div class="animate-pulse">
                        <div class="h-4 bg-gray-200 rounded mb-2"></div>
                        <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- API Tests -->
        <div class="mt-8 bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">API Testleri</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <button onclick="testAPI('health')" class="btn btn-outline">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Health Check
                </button>
                
                <button onclick="testAPI('products')" class="btn btn-outline">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Products API
                </button>
                
                <button onclick="testAPI('auth/me')" class="btn btn-outline">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Auth Check
                </button>
            </div>
            
            <!-- Test Results -->
            <div id="test-results" class="mt-6 space-y-4"></div>
        </div>
        
        <!-- Session Info -->
        <div class="mt-8 bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Session Bilgileri</h3>
            <div class="bg-gray-50 rounded-lg p-4">
                <pre class="text-sm text-gray-700 overflow-auto">
<?php 
echo "Session ID: " . session_id() . "\n";
echo "Session Data:\n";
print_r($_SESSION ?? []);
?>
                </pre>
            </div>
        </div>
        
        <!-- Current User -->
        <div class="mt-8 bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Mevcut Kullanıcı</h3>
            <div class="bg-gray-50 rounded-lg p-4">
                <pre class="text-sm text-gray-700 overflow-auto">
<?php 
print_r($current_user ?? ['message' => 'Kullanıcı giriş yapmamış']);
?>
                </pre>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadDatabaseInfo();
});

async function loadDatabaseInfo() {
    try {
        const response = await apiCall('health');
        const dbInfo = document.getElementById('db-info');
        
        if (response.status === 'healthy') {
            dbInfo.innerHTML = `
                <div class="flex justify-between">
                    <span class="text-gray-600">Durum:</span>
                    <span class="font-medium text-green-600">Sağlıklı</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Timestamp:</span>
                    <span class="font-medium">${response.timestamp}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Database:</span>
                    <span class="font-medium">SQLite</span>
                </div>
            `;
        } else {
            dbInfo.innerHTML = '<div class="text-red-600">Veritabanı bağlantısı başarısız</div>';
        }
        
    } catch (error) {
        console.error('Error loading database info:', error);
        const dbInfo = document.getElementById('db-info');
        dbInfo.innerHTML = '<div class="text-red-600">Veritabanı bilgileri alınamadı</div>';
    }
}

async function testAPI(endpoint) {
    const resultsContainer = document.getElementById('test-results');
    
    // Add loading indicator
    const testResult = document.createElement('div');
    testResult.className = 'border rounded-lg p-4';
    testResult.innerHTML = `
        <div class="flex items-center justify-between">
            <span class="font-medium">Testing ${endpoint}...</span>
            <div class="loading-spinner w-4 h-4"></div>
        </div>
    `;
    resultsContainer.appendChild(testResult);
    
    try {
        const response = await apiCall(endpoint);
        
        testResult.innerHTML = `
            <div class="flex items-center justify-between mb-2">
                <span class="font-medium text-green-600">✓ ${endpoint}</span>
                <span class="text-xs text-gray-500">${new Date().toLocaleTimeString()}</span>
            </div>
            <div class="bg-gray-50 rounded p-2">
                <pre class="text-xs text-gray-700 overflow-auto">${JSON.stringify(response, null, 2)}</pre>
            </div>
        `;
        
    } catch (error) {
        testResult.innerHTML = `
            <div class="flex items-center justify-between mb-2">
                <span class="font-medium text-red-600">✗ ${endpoint}</span>
                <span class="text-xs text-gray-500">${new Date().toLocaleTimeString()}</span>
            </div>
            <div class="bg-red-50 rounded p-2">
                <pre class="text-xs text-red-700 overflow-auto">${error.message}</pre>
            </div>
        `;
    }
}
</script>
