// Filter functionality
document.getElementById('AllStatus').addEventListener('click', function() {
    filterTable('all');
});

document.getElementById('completedStatus').addEventListener('click', function() {
    filterTable('Completed');
});

document.getElementById('refundedStatus').addEventListener('click', function() {
    filterTable('Refunded');
});

function filterTable(status) {
    const rows = document.getElementById('transactionsTable').getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const transactionStatus = row.getAttribute('data-status');
        if (status === 'all' || transactionStatus === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }
}

// Optional: Filter by all transactions by default when the page loads
window.onload = function() {
    filterTable('all');
};
