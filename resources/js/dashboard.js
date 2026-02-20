
document.getElementById('sidebarToggle').addEventListener('click', function () {
    document.getElementById('sidebar').classList.toggle('active');
    document.getElementById('mainContent').classList.toggle('expanded');
});

document.addEventListener('click', function (event) {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');

    if (window.innerWidth < 768 &&
        !sidebar.contains(event.target) &&
        !sidebarToggle.contains(event.target) &&
        sidebar.classList.contains('active')) {
        sidebar.classList.remove('active');
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const revenueChart = document.getElementById('revenueChart');
    const ordersChart = document.getElementById('ordersChart');

    if (revenueChart) {
        const ctx = revenueChart.getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو'],
                datasets: [{
                    label: 'الإيرادات',
                    data: [12000, 19000, 15000, 25000, 22000, 30000],
                    borderColor: 'rgb(246, 201, 14)',
                    backgroundColor: 'rgba(246, 201, 14, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });
    }
});

function updateOrderStatus(orderId, status) {
    if (confirm('هل أنت متأكد من تغيير حالة الطلب؟')) {
        fetch(`/owner/orders/${orderId}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                status: status
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
    }
}

function markAsRead(notificationId) {
    fetch(`/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });
}
