//donut graph
const canvas = document.getElementById('pieChart');
const ctx = canvas.getContext('2d');
const legendContainer = document.getElementById('legend');

// Sample data for bookings
const bookingData = {
    thisWeek: {
        confirmed: 50,
        pending: 30,
        cancelled: 20,
    },
    lastWeek: {
        confirmed: 40,
        pending: 25,
        cancelled: 35,
    }
};

const colors = {
    confirmed: '#97a0a9', // Green
    pending: '#cae3fe', // Yellow
    cancelled: '#abbbce' // Red
};

// Function to draw the donut chart
function drawDonutChart(data) {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    
    const total = Object.values(data).reduce((acc, value) => acc + value, 0);
    let startAngle = 0;
    const donutHoleSize = 0.5; // Proportion of the donut hole

    Object.entries(data).forEach(([status, value]) => {
        const sliceAngle = (value / total) * 2 * Math.PI;
        const endAngle = startAngle + sliceAngle;

        ctx.fillStyle = colors[status];
        ctx.beginPath();
        ctx.moveTo(canvas.width / 2, canvas.height / 2);
        ctx.arc(canvas.width / 2, canvas.height / 2, canvas.width / 2, startAngle, endAngle);
        ctx.arc(canvas.width / 2, canvas.height / 2, canvas.width / 2 * donutHoleSize, endAngle, startAngle, true);
        ctx.closePath();
        ctx.fill();

        startAngle = endAngle;
    });
}

// Function to generate the legend
function generateLegend(data) {
    legendContainer.innerHTML = ''; // Clear the existing legend

    Object.keys(data).forEach(status => {
        const legendItem = document.createElement('div');
        legendItem.classList.add('legend-item');
        
        const colorBox = document.createElement('div');
        colorBox.classList.add('legend-color');
        colorBox.style.backgroundColor = colors[status];
        
        const text = document.createTextNode(`${status.charAt(0).toUpperCase() + status.slice(1)} (${data[status]})`);
        
        legendItem.appendChild(colorBox);
        legendItem.appendChild(text);
        legendContainer.appendChild(legendItem);
    });
}

// Function to filter data based on the selected week
function filterData(week) {
    const data = bookingData[week];
    drawDonutChart(data);
    generateLegend(data);
    if (week === 'thisWeek') {
        thisWeekButton.classList.add('active');
        lastWeekButton.classList.remove('active');
    } else {
        thisWeekButton.classList.remove('active');
        lastWeekButton.classList.add('active');
    }
}

// Initial rendering for this week's data
filterData('thisWeek');
function toggleOptions(event) {
    const icon = event.currentTarget;
    const options = icon.nextElementSibling;
    const isVisible = options.style.display === 'block';
    document.querySelectorAll('.options').forEach(opt => opt.style.display = 'none');
    options.style.display = isVisible ? 'none' : 'block';
}

document.addEventListener('click', (event) => {
    if (!event.target.matches('.bx-dots-vertical-rounded')) {
        document.querySelectorAll('.options').forEach(opt => opt.style.display = 'none');
    }
});