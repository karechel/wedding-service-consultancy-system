document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById("editModal");
    const span = document.getElementsByClassName("close")[0];

    document.querySelectorAll('.edit').forEach(button => {
        button.addEventListener('click', function () {
            const bookingId = this.closest('tr').dataset.bookingId;
            const status = this.closest('tr').querySelector('td:nth-child(7)').innerText;

            document.getElementById('editBookingId').value = bookingId;
            document.getElementById('editStatus').value = status;

            modal.style.display = "block";
        });
    });

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    document.getElementById('editForm').addEventListener('submit', function (event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch('updateCbooking.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const bookingId = formData.get('booking_id');
                const status = formData.get('status');

                const row = document.querySelector(`tr[data-booking-id='${bookingId}']`);
                row.querySelector('td:nth-child(7)').innerText = status;

                modal.style.display = "none";
            } else {
                alert('Error updating booking: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });
});
