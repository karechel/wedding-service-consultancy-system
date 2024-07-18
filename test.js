document.addEventListener('DOMContentLoaded', function() {
    // Fetch and display total revenue
    fetchTotalRevenue();

    // Fetch and display pending payments
    fetchPendingPayments();

    // Fetch and display recent transactions
    fetchRecentTransactions();

    // Fetch and display transaction history
    fetchTransactionHistory();

    // Fetch and display earnings chart
    fetchEarningsChart();

    // Fetch and display invoice history
    fetchInvoiceHistory();

    // Event listeners for export buttons
    document.getElementById('exportPDF').addEventListener('click', exportToPDF);
    document.getElementById('exportCSV').addEventListener('click', exportToCSV);
    document.getElementById('generateInvoice').addEventListener('click', generateInvoice);
});

function fetchTotalRevenue() {
    // Fetch total revenue from the server and update the DOM
    // Placeholder value
    document.getElementById('totalRevenue').innerText = '5000.00';
}

function fetchPendingPayments() {
    // Fetch pending payments from the server and update the DOM
    // Placeholder value
    document.getElementById('pendingPayments').innerText = '1500.00';
}

function fetchRecentTransactions() {
    // Fetch recent transactions from the server and update the DOM
    // Placeholder values
    const recentTransactions = [
        { date: '2024-07-01', amount: '300.00', status: 'Completed' },
        { date: '2024-07-02', amount: '200.00', status: 'Pending' }
    ];

    const list = document.getElementById('recentTransactions');
    recentTransactions.forEach(transaction => {
        const listItem = document.createElement('li');
        listItem.innerText = `${transaction.date}: $${transaction.amount} (${transaction.status})`;
        list.appendChild(listItem);
    });
}

function fetchTransactionHistory() {
    // Fetch transaction history from the server and update the DOM
    // Placeholder values
    const transactions = [
        { date: '2024-07-01', bookingId: 'B123', clientName: 'John Doe', service: 'Photography', amount: '300.00', status: 'Completed' },
        { date: '2024-07-02', bookingId: 'B124', clientName: 'Jane Smith', service: 'Catering', amount: '500.00', status: 'Pending' }
    ];

    const tbody = document.querySelector('#transactionHistory tbody');
    transactions.forEach(transaction => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${transaction.date}</td>
            <td>${transaction.bookingId}</td>
            <td>${transaction.clientName}</td>
            <td>${transaction.service}</td>
            <td>${transaction.amount}</td>
            <td>${transaction.status}</td>
        `;
        tbody.appendChild(row);
    });
}

function fetchEarningsChart() {
    // Fetch data and render the earnings chart
    // Placeholder implementation
    const chartContainer = document.getElementById('earningsChart');
    chartContainer.innerHTML = '<p>Earnings chart placeholder</p>';
}

function fetchInvoiceHistory() {
    // Fetch invoice history from the server and update the DOM
    // Placeholder values
    const invoices = [
        { invoiceId: 'INV123', bookingId: 'B123', date: '2024-07-01', amount: '300.00', status: 'Paid' },
        { invoiceId: 'INV124', bookingId: 'B124', date: '2024-07-02', amount: '500.00', status: 'Unpaid' }
    ];

    const tbody = document.querySelector('#invoiceHistory tbody');
    invoices.forEach(invoice => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${invoice.invoiceId}</td>
            <td>${invoice.bookingId}</td>
            <td>${invoice.date}</td>
            <td>${invoice.amount}</td>
            <td>${invoice.status}</td>
            <td><button>View</button> <button>Download</button></td>
        `;
        tbody.appendChild(row);
    });
}

function exportToPDF() {
    // Implement export to PDF functionality
    alert('Export to PDF functionality is not yet implemented.');
}

function exportToCSV() {
    // Implement export to CSV functionality
    alert('Export to CSV functionality is not yet implemented.');
}

function generateInvoice() {
    // Implement invoice generation functionality
    alert('Invoice generation functionality is not yet implemented.');
}
