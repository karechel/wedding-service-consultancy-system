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
