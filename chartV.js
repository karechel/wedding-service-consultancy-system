// Function to fetch data from PHP backend via AJAX
function fetchDataFromBackend(period) {
    fetch('financeV.php?period=' + period)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Assuming data is received as JSON with 'label' and 'amount' fields
            updateLineChart(data);
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}

// Function to update the line chart with fetched data
function updateLineChart(data) {
    // Assuming data structure matches the expected format: [{ label: '...', amount: ... }, ...]
    const labels = data.map(item => item.label);
    const amounts = data.map(item => item.amount);

    // Update lineRevenueData with fetched data
    lineRevenueData[getCurrentPeriod()].labels = labels;
    lineRevenueData[getCurrentPeriod()].data = amounts;

    // Redraw the chart with updated data
    drawLineChartRevenue(lineRevenueData[getCurrentPeriod()]);
}

// Helper function to get the current period ('monthly', 'quarterly', 'yearly')
function getCurrentPeriod() {
    if (document.getElementById('monthlyButtonRevenue').classList.contains('active')) {
        return 'monthly';
    } else if (document.getElementById('quarterlyButtonRevenue').classList.contains('active')) {
        return 'quarterly';
    } else if (document.getElementById('yearlyButtonRevenue').classList.contains('active')) {
        return 'yearly';
    }
    return 'monthly'; // Default to monthly if none is active (initial state)
}

// Event listeners for button clicks to fetch data
document.getElementById('monthlyButtonRevenue').addEventListener('click', function() {
    filterLineGraphDataRevenue('monthly');
    fetchDataFromBackend('monthly');
});

document.getElementById('quarterlyButtonRevenue').addEventListener('click', function() {
    filterLineGraphDataRevenue('quarterly');
    fetchDataFromBackend('quarterly');
});

document.getElementById('yearlyButtonRevenue').addEventListener('click', function() {
    filterLineGraphDataRevenue('yearly');
    fetchDataFromBackend('yearly');
});

// Initial rendering for monthly data
fetchDataFromBackend('monthly');
