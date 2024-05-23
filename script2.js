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
