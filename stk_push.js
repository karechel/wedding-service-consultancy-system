document.getElementById('payForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting normally

    // Get the values from the form
    var contactNumber = document.getElementById('contactNumber').value;
    var amount = document.getElementById('amount').value;
    var bookingId = document.getElementById('booking_id').value; // Get booking_id

    // Create a FormData object to send the data via POST
    var formData = new FormData();
    formData.append('contactNumber', contactNumber);
    formData.append('amount', amount);
    formData.append('booking_id', bookingId); // Append booking_id to FormData

    // Make an AJAX request to stk_push.php
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'stk_push.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            console.log(xhr.responseText); // Optional: handle response from stk_push.php
        } else {
            console.error('Error:', xhr.status);
        }
    };
    xhr.onerror = function() {
        console.error('Request failed.');
    };
    xhr.send(formData);
});
