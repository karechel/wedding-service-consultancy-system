function filterLineGraphDataRevenue(filter) {
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                const responseText = xhr.responseText;

                // Extract numeric values from responseText
                const numericValues = [];
                const matches = responseText.match(/\d+/g); // Match all numeric values

                if (matches) {
                    for (let i = 0; i < matches.length; i++) {
                        numericValues.push(Number(matches[i]));
                    }

                    console.log(responseText); // Log the extracted numeric values to check

                    // Set labels based on filter
                    let labels;
                    if (filter === 'monthly') {
                        labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    } else if (filter === 'quarterly') {
                        labels = ['Q1', 'Q2', 'Q3', 'Q4'];
                    } else if (filter === 'yearly') {
                        labels = ['2020', '2021', '2022', '2023', '2024'];
                    }

                    // Pass labels and numericValues to drawLineChart function
                    drawLineChart(labels, numericValues);
                } else {
                    console.error('No numeric values found in response');
                }
            } else {
                console.error('Error:', xhr.statusText);
                // Handle error here, e.g., display an error message on the page
            }
        }
    };

    xhr.open('GET', 'financeV.php?filter=' + filter, true);
    xhr.send();
}

function drawLineChart(labels, data) {
    const canvas = document.getElementById('lineChartRevenue');
    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    const maxValue = Math.max(...data);

    // Calculate canvas width based on labels length
    const labelWidth = 30;
    const minimumCanvasWidth = 400;
    const canvasWidth = Math.max(minimumCanvasWidth, labels.length * labelWidth);
    const canvasHeight = 400;

    canvas.width = canvasWidth;
    canvas.height = canvasHeight;

    const scaleY = canvas.height / (maxValue + 50);

    // Draw X and Y axis
    ctx.beginPath();
    ctx.moveTo(30, 10);
    ctx.lineTo(30, canvas.height - 30);
    ctx.lineTo(canvas.width - 10, canvas.height - 30);
    ctx.stroke();

    // Draw data points and lines
    ctx.beginPath();
    ctx.moveTo(30, canvas.height - 30 - data[0] * scaleY);

    for (let i = 1; i < data.length; i++) {
        const x = 30 + i * labelWidth;
        const y = canvas.height - 30 - data[i] * scaleY;
        ctx.lineTo(x, y);
    }

    ctx.strokeStyle = '#3e95cd';
    ctx.stroke();

    // Draw X axis labels
    ctx.font = '12px Arial';
    ctx.fillStyle = '#000';
    for (let i = 0; i < labels.length; i++) {
        const x = 25 + i * labelWidth;
        ctx.fillText(labels[i], x, canvas.height - 10);
    }

    // Draw Y axis labels
    ctx.textAlign = 'right';
    ctx.fillText(maxValue, 20, 20);
    ctx.fillText('0', 20, canvas.height - 20);

    // Draw title
    ctx.textAlign = 'center';
    ctx.font = '14px Arial';
    ctx.fillText('Revenue', canvas.width / 2, 20);
}


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
    
