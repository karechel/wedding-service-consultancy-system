const canvas = document.getElementById('pieChart');
const ctx = canvas.getContext('2d');
const legendContainer = document.getElementById('legend');

const colors = {
    Confirmed: '#97a0a9', // Gray
    Pending: '#cae3fe', // Light Blue
    Cancelled: '#abbbce' // Light Gray
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
    // Make AJAX request to the server
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                const response = xhr.responseText.trim().split('\n');
                const chartDataString = response[response.length - 1].trim(); // Get the last line and trim it
               
                try {
                    const chartDataArray = JSON.parse(chartDataString);
                    const chartData = chartDataArray[0]; // Since the response is in an array
                    const newBookings= chartDataArray[1];
                    const CompletedBookings= chartDataArray[2];

                    drawDonutChart(chartData);
                    generateLegend(chartData);

                    // Update the cards
                   

                    // Update the button states
                    if (week === 'thisWeek') {
                        document.getElementById('thisWeekButton').classList.add('active');
                        document.getElementById('lastWeekButton').classList.remove('active');
                    } else {
                        document.getElementById('thisWeekButton').classList.remove('active');
                        document.getElementById('lastWeekButton').classList.add('active');
                    }
                    
                    document.getElementById('totalNewBookings').textContent = newBookings;
                    document.getElementById('totalCompletedBookings').textContent = CompletedBookings;
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                }
            } else {
                console.error('Error:', xhr.statusText);
            }
        }
    };

    xhr.open('GET', 'filterbookings.php?week=' + week, true);
    xhr.send();
}

// Initial rendering for this week's data
document.addEventListener('DOMContentLoaded', function() {
    filterData('thisWeek');
});

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
