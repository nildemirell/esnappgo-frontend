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
        <div class="flex items-center justify-between mb-8">
            <div>
                <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-2">
                    <a href="/admin" class="hover:text-gray-700">Admin</a>
                    <span>/</span>
                    <span class="text-gray-900">Kullanıcılar</span>
                </nav>
                <h1 class="text-3xl font-bold text-gray-900">Kullanıcı Yönetimi</h1>
            </div>
        </div>
        
        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                        Ara
                    </label>
                    <input
                        type="text"
                        id="search"
                        placeholder="Ad, email ara..."
                        class="w-full"
                        onkeyup="filterUsers()"
                    />
                </div>
                
                <div>
                    <label for="role-filter" class="block text-sm font-medium text-gray-700 mb-2">
                        Rol
                    </label>
                    <select id="role-filter" class="w-full" onchange="filterUsers()">
                        <option value="">Tüm Roller</option>
                        <option value="customer">Müşteri</option>
                        <option value="student">Öğrenci</option>
                        <option value="merchant">Esnaf</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                
                <div>
                    <label for="status-filter" class="block text-sm font-medium text-gray-700 mb-2">
                        Durum
                    </label>
                    <select id="status-filter" class="w-full" onchange="filterUsers()">
                        <option value="">Tüm Durumlar</option>
                        <option value="active">Aktif</option>
                        <option value="inactive">Pasif</option>
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button onclick="exportUsers()" class="btn btn-outline w-full">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Dışa Aktar
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Users Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kullanıcı
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Rol
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Durum
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kayıt Tarihi
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                İşlemler
                            </th>
                        </tr>
                    </thead>
                    <tbody id="users-table-body" class="bg-white divide-y divide-gray-200">
                        <!-- Loading rows -->
                        <?php for ($i = 0; $i < 5; $i++): ?>
                        <tr class="animate-pulse">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gray-200 rounded-full"></div>
                                    <div class="ml-4">
                                        <div class="h-4 bg-gray-200 rounded mb-1"></div>
                                        <div class="h-3 bg-gray-200 rounded w-3/4"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4"><div class="h-4 bg-gray-200 rounded w-16"></div></td>
                            <td class="px-6 py-4"><div class="h-4 bg-gray-200 rounded w-16"></div></td>
                            <td class="px-6 py-4"><div class="h-4 bg-gray-200 rounded w-20"></div></td>
                            <td class="px-6 py-4"><div class="h-4 bg-gray-200 rounded w-16"></div></td>
                        </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
let allUsers = [];
let filteredUsers = [];

document.addEventListener('DOMContentLoaded', function() {
    loadUsers();
});

async function loadUsers() {
    try {
        const response = await apiCall('admin/users');
        
        if (response.success) {
            allUsers = response.data;
            filteredUsers = [...allUsers];
            displayUsers();
        } else {
            throw new Error(response.message || 'Kullanıcılar yüklenemedi');
        }
        
    } catch (error) {
        console.error('Error loading users:', error);
        showToast('Kullanıcılar yüklenirken hata oluştu: ' + error.message, 'error');
        
        // Fallback: empty state
        allUsers = [];
        filteredUsers = [];
        document.getElementById('users-table-body').innerHTML = '<tr><td colspan="5" class="text-center py-8 text-gray-500">Kullanıcı bulunamadı</td></tr>';
    }
}

function displayUsers() {
    const tbody = document.getElementById('users-table-body');
    
    tbody.innerHTML = filteredUsers.map(user => `
        <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-sm font-medium text-blue-600">${user.full_name.charAt(0)}</span>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">${escapeHtml(user.full_name)}</div>
                        <div class="text-sm text-gray-500">${escapeHtml(user.email)}</div>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="badge badge-${getRoleBadgeClass(user.role)}">
                    ${getRoleName(user.role)}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="badge badge-${user.is_active ? 'success' : 'error'}">
                    ${user.is_active ? 'Aktif' : 'Pasif'}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                ${formatDate(user.created_at)}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <div class="flex space-x-2">
                    <button onclick="editUser(${user.id})" class="text-blue-600 hover:text-blue-900">
                        Düzenle
                    </button>
                    <button onclick="toggleUserStatus(${user.id})" class="text-${user.is_active ? 'red' : 'green'}-600 hover:text-${user.is_active ? 'red' : 'green'}-900">
                        ${user.is_active ? 'Pasifleştir' : 'Aktifleştir'}
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

function filterUsers() {
    const search = document.getElementById('search').value.toLowerCase();
    const roleFilter = document.getElementById('role-filter').value;
    const statusFilter = document.getElementById('status-filter').value;
    
    filteredUsers = allUsers.filter(user => {
        const matchesSearch = !search || 
            user.full_name.toLowerCase().includes(search) || 
            user.email.toLowerCase().includes(search);
        
        const matchesRole = !roleFilter || user.role === roleFilter;
        
        const matchesStatus = !statusFilter || 
            (statusFilter === 'active' && user.is_active) ||
            (statusFilter === 'inactive' && !user.is_active);
        
        return matchesSearch && matchesRole && matchesStatus;
    });
    
    displayUsers();
}

async function toggleUserStatus(userId) {
    const user = allUsers.find(u => u.id === userId);
    if (!user) return;
    
    const action = user.is_active ? 'pasifleştirmek' : 'aktifleştirmek';
    
    if (!confirm(`${user.full_name} kullanıcısını ${action} istediğinizden emin misiniz?`)) {
        return;
    }
    
    try {
        // API endpoint eklenecek
        user.is_active = !user.is_active;
        
        filterUsers();
        showToast(`Kullanıcı ${user.is_active ? 'aktifleştirildi' : 'pasifleştirildi'}`, 'success');
        
    } catch (error) {
        showToast('Kullanıcı durumu güncellenirken hata oluştu', 'error');
    }
}

function editUser(userId) {
    showToast('Kullanıcı düzenleme özelliği yakında eklenecek', 'info');
}

function exportUsers() {
    // Simple CSV export
    const csvContent = "data:text/csv;charset=utf-8," + 
        "Ad Soyad,Email,Rol,Durum,Kayıt Tarihi\n" +
        filteredUsers.map(user => 
            `"${user.full_name}","${user.email}","${getRoleName(user.role)}","${user.is_active ? 'Aktif' : 'Pasif'}","${user.created_at}"`
        ).join("\n");
    
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "kullanicilar.csv");
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    showToast('Kullanıcı listesi indirildi', 'success');
}

function getRoleName(role) {
    const roleNames = {
        customer: 'Müşteri',
        student: 'Öğrenci',
        merchant: 'Esnaf',
        admin: 'Admin'
    };
    return roleNames[role] || role;
}

function getRoleBadgeClass(role) {
    const badgeClasses = {
        customer: 'primary',
        student: 'success',
        merchant: 'warning',
        admin: 'error'
    };
    return badgeClasses[role] || 'gray';
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('tr-TR', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
</script>
