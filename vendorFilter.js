function toggleOptions(event) {
    event.stopPropagation();
    const options = event.target.nextElementSibling;
    document.querySelectorAll('.options').forEach(opt => {
        if (opt !== options) opt.style.display = 'none';
    });
    options.style.display = options.style.display === 'block' ? 'none' : 'block';
}
document.addEventListener('DOMContentLoaded', function() {
    // Make initial AJAX request to fetch data for today
    filterContent(0, 'bookings');
    filterContent(0, 'payments');
    filterContent(0, 'revenue');
});

function filterContent(option, type) {
    // Make AJAX request to the server
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var responseText = xhr.responseText.split(' ');
                console.log(responseText);
                var totalCount = responseText[20];

                if (type === 'bookings') {
                    document.getElementById('totalBookings').textContent = totalCount;
                }  
                //  else if (type === 'payments') {
                //     document.getElementById('totalPayments').textContent = totalCount;
                   
                // } else if (type === 'revenue') {
                //     document.getElementById('totalrevenue').textContent = totalCount;
                   
                // }
            } else {
                console.error('Error:', xhr.statusText);
            }
        }
    };
    xhr.open('GET', 'filterdata.php?option=' + option + '&type=' + type, true);
    xhr.send();
}