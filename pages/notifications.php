<?php
// Sadece giriş yapmış kullanıcılar görebilir
if (!$current_user) {
    header('Location: /login');
    exit;
}
?>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Bildirimlerim</h1>
            <button onclick="markAllAsRead()" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                Tümünü Okundu İşaretle
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <ul id="notifications-list" class="divide-y divide-gray-100">
                <li class="p-4 animate-pulse flex space-x-4">
                    <div class="rounded-full bg-gray-200 h-10 w-10"></div>
                    <div class="flex-1 space-y-2 py-1">
                        <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                        <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                    </div>
                </li>
            </ul>
        </div>

    </div>
</div>

<script>
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text || '';
        return div.innerHTML;
    }

    function showLocalToast(message, type = 'info') {
        if (typeof showToast === 'function') {
            showToast(message, type);
        } else {
            alert(message);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadNotificationsPage();
    });

    async function loadNotificationsPage() {
        const token = localStorage.getItem('auth_token');

        // EĞER TOKEN HİÇ YOKSA DİREKT LOGİNE AT
        if (!token) {
            window.location.href = '/login';
            return;
        }

        const listContainer = document.getElementById('notifications-list');

        try {
            const res = await fetch(`${API_BASE}/api/Notifications`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token
                }
            });

            // YENİ: EĞER TOKEN SÜRESİ DOLMUŞSA (401) LOGİNE AT
            if (res.status === 401) {
                localStorage.removeItem('auth_token'); // Bozuk tokenı temizle
                window.location.href = '/login';
                return;
            }

            if (!res.ok) {
                throw new Error("Bildirimler çekilemedi");
            }

            const notifications = await res.json();

            if (!notifications || notifications.length === 0) {
                listContainer.innerHTML = `
                    <li class="p-8 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        Henüz hiç bildiriminiz yok.
                    </li>`;
                return;
            }

            let htmlContent = '';
            notifications.forEach(n => {
                const isReadClass = n.isRead ? 'opacity-70' : 'bg-blue-50/30';
                const iconBgClass = n.isRead ? 'bg-gray-100 text-gray-500' : 'bg-blue-100 text-blue-600';
                const textClass = n.isRead ? '' : 'font-semibold';
                const messageText = escapeHtml(n.message || n.content || 'Yeni Bildirim');

                let dateStr = '';
                if (n.createdAt) {
                    const d = new Date(n.createdAt);
                    dateStr = d.toLocaleDateString('tr-TR', { hour: '2-digit', minute: '2-digit' });
                }

                let buttonHtml = '';
                if (!n.isRead) {
                    buttonHtml = '<button onclick="markAsRead(' + n.id + ')" class="text-xs text-blue-600 hover:text-blue-800 mt-2">Okundu İşaretle</button>';
                }

                htmlContent += `
                <li class="p-4 hover:bg-gray-50 transition-colors ${isReadClass}">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full ${iconBgClass} flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-900 ${textClass}">${messageText}</p>
                            <p class="text-xs text-gray-500 mt-1">${dateStr}</p>
                            ${buttonHtml}
                        </div>
                    </div>
                </li>`;
            });

            listContainer.innerHTML = htmlContent;

        } catch (error) {
            console.error(error);
            listContainer.innerHTML = '<li class="p-4 text-center text-red-500">Bildirimler yüklenirken hata oluştu.</li>';
        }
    }

    async function markAsRead(id) {
        const token = localStorage.getItem('auth_token');

        try {
            const res = await fetch(`${API_BASE}/api/Notifications/${id}/read`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token
                }
            });

            if (res.ok) {
                loadNotificationsPage();
                if (typeof loadNotificationCount === 'function') {
                    loadNotificationCount();
                }
            } else if (res.status === 401) {
                window.location.href = '/login'; // Token bitmişse logine at
            } else {
                showLocalToast('İşlem başarısız', 'error');
            }
        } catch (e) {
            console.error(e);
            showLocalToast('Bir hata oluştu', 'error');
        }
    }

    async function markAllAsRead() {
    const token = localStorage.getItem('auth_token');
    // Sayfadaki tüm "Okundu İşaretle" butonlarının ID'lerini topla
    const readButtons = document.querySelectorAll('button[onclick^="markAsRead"]');
    if (readButtons.length === 0) {
        showLocalToast('Okunmamış bildirim yok.', 'info');
        return;
    }

    // Her birini sırayla markAsRead et
    const ids = [];
    readButtons.forEach(btn => {
        const match = btn.getAttribute('onclick').match(/markAsRead\((\d+)\)/);
        if (match) ids.push(parseInt(match[1]));
    });

    showLocalToast('Tüm bildirimler okunuyor...', 'info');

    let successCount = 0;
    for (const id of ids) {
        try {
            const res = await fetch(`${API_BASE}/api/Notifications/${id}/read`, {
                method: 'PUT',
                headers: { 'Authorization': 'Bearer ' + token }
            });
            if (res.ok) successCount++;
        } catch (e) { /* devam et */ }
    }

    showLocalToast(`${successCount} bildirim okundu olarak işaretlendi.`, 'success');
    loadNotificationsPage();
    if (typeof loadNotificationCount === 'function') loadNotificationCount();
}

</script>