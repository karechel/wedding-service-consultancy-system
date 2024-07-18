
// JavaScript to handle modal and form submission
var modal = document.getElementById("messageModal");
var btnOpenModal = document.getElementById("btnOpenMessageModal");
var vendorIdInput = document.getElementById("vendor_id");
var modalVendorIdInput = document.getElementById("modal_vendor_id");

// When the user clicks on the button, open the modal and set vendor_id
btnOpenModal.onclick = function() {
  modalVendorIdInput.value = vendorIdInput.value;
  openModal();
};

// Function to open modal
function openModal() {
  modal.style.display = "block";
}

// Function to close modal
function closeModal() {
  modal.style.display = "none";
}

// Close modal when clicking on close button
var spanClose = document.getElementsByClassName("close")[0];
spanClose.onclick = function() {
  closeModal();
};

// Close modal when clicking outside modal
window.onclick = function(event) {
  if (event.target == modal) {
    closeModal();
  }
};

// Handle form submission
var messageForm = document.getElementById("messageForm");
messageForm.addEventListener("submit", function(event) {
  event.preventDefault();
  var formData = new FormData(this);

  // AJAX request to insert_conversation.php or handle form submission
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "insert_conversation.php", true);
  xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        // Success handling (optional)
        console.log("Message sent successfully");
        closeModal(); // Close modal after message is sent
      } else {
        // Error handling (optional)
        console.error("Error sending message:", xhr.status);
      }
    }
  };
  xhr.send(formData);
});
