document.getElementById('confirmedStatus').addEventListener('click', function() {
    filterTable('Confirmed');
});

document.getElementById('pendingStatus').addEventListener('click', function() {
    filterTable('Pending');
});

document.getElementById('cancelledStatus').addEventListener('click', function() {
    filterTable('Cancelled');
});

document.getElementById('completedStatus').addEventListener('click', function() {
    filterTable('Completed');
});

document.getElementById('AllStatus').addEventListener('click', function() {
    filterTable('all');
});

function filterTable(status) {
    const rows = document.getElementById('bookingsTable').getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const bookingStatus = row.getAttribute('data-status');
        if (status === 'all' || bookingStatus === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }
}

// Optional: Filter by all bookings by default when the page loads
window.onload = function() {
    filterTable('all');
};


//Payment button
document.addEventListener('DOMContentLoaded', function() {
    // Function to handle the Pay button click
    function handlePayButtonClick(bookingId) {
        // Handle the Pay button click, e.g., redirect to payment page
        console.log(`Pay button clicked for booking ID: ${bookingId}`);
        // Add your payment handling logic here
    }

    // Adding event listeners to the Pay buttons
    document.querySelectorAll('.pay-button').forEach(button => {
        button.addEventListener('click', function() {
            const bookingId = this.closest('tr').dataset.bookingId;
            handlePayButtonClick(bookingId);
        });
    });
});

//payment modal
document.addEventListener('DOMContentLoaded', function() {
    // Get the modal
    var modalPayment = document.getElementById('payModal');

    // Get the button that opens the modal
    var payButtons = document.querySelectorAll('.pay-button');

    // Get the <span> element that closes the modal
    var spanPayment = document.getElementsByClassName('close-payment')[0];

    // When the user clicks the button, open the modal 
    payButtons.forEach(function(button) {
        button.onclick = function() {
            modalPayment.style.display = 'block';
        };
    });

    // When the user clicks on <span> (x), close the modal
    spanPayment.onclick = function() {
        modalPayment.style.display = 'none';
    };

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modalPayment) {
            modalPayment.style.display = 'none';
        }
    };
});
