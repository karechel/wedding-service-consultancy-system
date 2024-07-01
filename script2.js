//revenue line graph
const lineCanvasRevenue = document.getElementById('lineChartRevenue');
const lineCtxRevenue = lineCanvasRevenue.getContext('2d');

const lineRevenueData = {
    monthly: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        data: [1200, 1900, 3000, 5000, 2400, 3500, 4500, 3200, 4300, 5100, 6300, 7000]
    },
    quarterly: {
        labels: ['Q1', 'Q2', 'Q3', 'Q4'],
        data: [6100, 10900, 12000, 18400]
    },
    yearly: {
        labels: ['2019', '2020', '2021', '2022', '2023'],
        data: [50000, 75000, 85000, 92000, 110000]
    }
};

let currentLineDataRevenue = lineRevenueData.monthly;

function drawLineChartRevenue(data) {
    const maxValue = Math.max(...data.data);
    const minValue = Math.min(...data.data);
    const padding = 50;
    const xStep = (lineCanvasRevenue.width - 2 * padding) / (data.labels.length - 1);
    const yStep = (lineCanvasRevenue.height - 2 * padding) / (maxValue - minValue);

    lineCtxRevenue.clearRect(0, 0, lineCanvasRevenue.width, lineCanvasRevenue.height);
    lineCtxRevenue.beginPath();
    lineCtxRevenue.moveTo(padding, lineCanvasRevenue.height - padding - (data.data[0] - minValue) * yStep);

    data.data.forEach((point, index) => {
        const x = padding + index * xStep;
        const y = lineCanvasRevenue.height - padding - (point - minValue) * yStep;
        lineCtxRevenue.lineTo(x, y);
    });

    lineCtxRevenue.strokeStyle = 'rgba(75, 192, 192, 1)';
    lineCtxRevenue.lineWidth = 2;
    lineCtxRevenue.stroke();
    lineCtxRevenue.closePath();

    lineCtxRevenue.fillStyle = '#000';
    lineCtxRevenue.font = '12px Arial';
    lineCtxRevenue.textAlign = 'center';

    const yInterval = Math.ceil((maxValue - minValue) / 5);
    for (let i = minValue; i <= maxValue; i += yInterval) {
        const y = lineCanvasRevenue.height - padding - (i - minValue) * yStep;
        lineCtxRevenue.fillText(i.toString(), padding - 30, y);
    }

    data.labels.forEach((label, index) => {
        const x = padding + index * xStep;
        const y = lineCanvasRevenue.height - padding;
        lineCtxRevenue.fillText(label, x, y + 20);
    });
}

function filterLineGraphDataRevenue(period) {
    if (period === 'monthly') {
        currentLineDataRevenue = lineRevenueData.monthly;
        document.getElementById('monthlyButtonRevenue').classList.add('active');
        document.getElementById('quarterlyButtonRevenue').classList.remove('active');
        document.getElementById('yearlyButtonRevenue').classList.remove('active');
    } else if (period === 'quarterly') {
        currentLineDataRevenue = lineRevenueData.quarterly;
        document.getElementById('monthlyButtonRevenue').classList.remove('active');
        document.getElementById('quarterlyButtonRevenue').classList.add('active');
        document.getElementById('yearlyButtonRevenue').classList.remove('active');
    } else if (period === 'yearly') {
        currentLineDataRevenue = lineRevenueData.yearly;
        document.getElementById('monthlyButtonRevenue').classList.remove('active');
        document.getElementById('quarterlyButtonRevenue').classList.remove('active');
        document.getElementById('yearlyButtonRevenue').classList.add('active');
    }
    drawLineChartRevenue(currentLineDataRevenue);
}

// Initial rendering for monthly data
filterLineGraphDataRevenue('monthly');




//expense line graph
const lineCanvasExpenses = document.getElementById('lineChartExpenses');
const lineCtxExpenses = lineCanvasExpenses.getContext('2d');

const lineExpensesData = {
    monthly: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        data: [1100, 1750, 2900, 4700, 2300, 3400, 4300, 3100, 4200, 5000, 6200, 6800]
    },
    quarterly: {
        labels: ['Q1', 'Q2', 'Q3', 'Q4'],
        data: [5750, 10400, 11600, 17500]
    },
    yearly: {
        labels: ['2019', '2020', '2021', '2022', '2023'],
        data: [48000, 71000, 80000, 88000, 105000]
    }
};

let currentLineDataExpenses = lineExpensesData.monthly;

function drawLineChartExpenses(data) {
    const maxValue = Math.max(...data.data);
    const minValue = Math.min(...data.data);
    const padding = 50;
    const xStep = (lineCanvasExpenses.width - 2 * padding) / (data.labels.length - 1);
    const yStep = (lineCanvasExpenses.height - 2 * padding) / (maxValue - minValue);

    lineCtxExpenses.clearRect(0, 0, lineCanvasExpenses.width, lineCanvasExpenses.height);
    lineCtxExpenses.beginPath();
    lineCtxExpenses.moveTo(padding, lineCanvasExpenses.height - padding - (data.data[0] - minValue) * yStep);

    data.data.forEach((point, index) => {
        const x = padding + index * xStep;
        const y = lineCanvasExpenses.height - padding - (point - minValue) * yStep;
        lineCtxExpenses.lineTo(x, y);
    });

    lineCtxExpenses.strokeStyle = 'rgba(255, 99, 132, 1)';
    lineCtxExpenses.lineWidth = 2;
    lineCtxExpenses.stroke();
    lineCtxExpenses.closePath();

    lineCtxExpenses.fillStyle = '#000';
    lineCtxExpenses.font = '12px Arial';
    lineCtxExpenses.textAlign = 'center';

    const yInterval = Math.ceil((maxValue - minValue) / 5);
    for (let i = minValue; i <= maxValue; i += yInterval) {
        const y = lineCanvasExpenses.height - padding - (i - minValue) * yStep;
        lineCtxExpenses.fillText(i.toString(), padding - 30, y);
    }

    data.labels.forEach((label, index) => {
        const x = padding + index * xStep;
        const y = lineCanvasExpenses.height - padding;
        lineCtxExpenses.fillText(label, x, y + 20);
    });
}

function filterLineGraphDataExpenses(period) {
    if (period === 'monthly') {
        currentLineDataExpenses = lineExpensesData.monthly;
        document.getElementById('monthlyButtonExpenses').classList.add('active');
        document.getElementById('quarterlyButtonExpenses').classList.remove('active');
        document.getElementById('yearlyButtonExpenses').classList.remove('active');
    } else if (period === 'quarterly') {
        currentLineDataExpenses = lineExpensesData.quarterly;
        document.getElementById('monthlyButtonExpenses').classList.remove('active');
        document.getElementById('quarterlyButtonExpenses').classList.add('active');
        document.getElementById('yearlyButtonExpenses').classList.remove('active');
    } else if (period === 'yearly') {
        currentLineDataExpenses = lineExpensesData.yearly;
        document.getElementById('monthlyButtonExpenses').classList.remove('active');
        document.getElementById('quarterlyButtonExpenses').classList.remove('active');
        document.getElementById('yearlyButtonExpenses').classList.add('active');
    }
    drawLineChartExpenses(currentLineDataExpenses);
}

// Initial rendering for monthly data
filterLineGraphDataExpenses('monthly');


 function toggleOptions(event) {
        event.stopPropagation();
        const options = event.target.nextElementSibling;
        document.querySelectorAll('.options').forEach(opt => {
            if (opt !== options) opt.style.display = 'none';
        });
        options.style.display = options.style.display === 'block' ? 'none' : 'block';
    }

    // function filterData(event, type, days) {
    //     event.preventDefault();
    //     fetch(`filterData.php?type=${type}&days=${days}`)
    //         .then(response => response.json())
    //         .then(data => {
    //             if (type === 'clients') {
    //                 document.getElementById('clientsCount').innerText = data.count;
    //             } else if (type === 'vendors') {
    //                 document.getElementById('vendorsCount').innerText = data.count;
    //             } else if (type === 'bookings') {
    //                 document.getElementById('bookingsCount').innerText = data.count;
    //             }
    //         });
    // }

    // document.addEventListener('click', () => {
    //     document.querySelectorAll('.options').forEach(opt => opt.style.display = 'none');
    // });
    document.addEventListener('DOMContentLoaded', function() {
        // Make initial AJAX request to fetch data for today
        filterContent(0, 'clients');
        filterContent(0, 'vendors');
        filterContent(0, 'bookings');
    });
    
    function filterContent(option, type) {
        // Make AJAX request to the server
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var responseText = xhr.responseText.split(' ');
                    console.log(responseText);
                    var newCount = responseText[19];
                    var totalCount = responseText[20];
    
                    if (type === 'clients') {
                        document.getElementById('totalClients').textContent = totalCount;
                        document.getElementById('newClients').textContent = newCount;
                    } else if (type === 'vendors') {
                        document.getElementById('totalVendors').textContent = totalCount;
                        document.getElementById('newVendors').textContent = newCount;
                    } else if (type === 'bookings') {
                        document.getElementById('totalBookings').textContent = totalCount;
                        document.getElementById('newBookings').textContent = newCount;
                    }
                } else {
                    console.error('Error:', xhr.statusText);
                }
            }
        };
        xhr.open('GET', 'filterdata.php?option=' + option + '&type=' + type, true);
        xhr.send();
    }
    
