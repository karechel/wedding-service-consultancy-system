document.getElementById('confirmedStatus').addEventListener('click', function() {
    filterTable('Confirmed');
});

document.getElementById('pendingStatus').addEventListener('click', function() {
    filterTable('Pending');
});

document.getElementById('cancelledStatus').addEventListener('click', function() {
    filterTable('Cancelled');
});
document.getElementById('AllStatus').addEventListener('click', function() {
    filterTable('all');
});


function filterTable(status) {
    const rows = document.getElementById('bookingsTable').getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const bookingStatus = row.getAttribute('data-status');
        if (status === 'all' || bookingStatus === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }
}

// Optional: Filter by confirmed bookings by default when the page loads
window.onload = function() {
    filterTable('all');
};