// Get the modal
var modal = document.getElementById('messagesModal');

// Get the button that opens the modal
var btn = document.getElementById("openMessagesBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal and fetch messages
btn.onclick = function() {
  modal.style.display = "block";
  fetchMessages(); // Fetch messages when modal opens
};

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
};

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};

// Function to fetch messages via AJAX
function fetchMessages() {
  // Handle AJAX request to fetch messages
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "fetch_messages.php", true);
  xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        var messages = xhr.responseText.split("\n"); // Split response into individual messages
console.log(messages);
var messagesnew=messages[10];
        // Display messages in modal
        var messagesContainer = document.getElementById('messagesContainer');
        messagesContainer.innerHTML = ''; // Clear previous messages

        messagesnew.forEach(function(message) {
          var messageElement = document.createElement('div');
          messageElement.textContent = message.replace(/["\[\]]/g, '').trim(); // Trim and remove quotes
          messagesContainer.appendChild(messageElement);
        });

      } else {
        console.error("Error fetching messages:", xhr.status);
      }
    }
  };
  xhr.send();
}
