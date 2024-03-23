document.getElementById('login-form').addEventListener('submit', function(event) {
    // Prevent the form from submitting
    event.preventDefault();

    // Get form input values
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;

    // Validate username
    if (username.trim() === '') {
        document.getElementById('usernameError').textContent = 'Username is required';
        return false;
    } else {
        document.getElementById('usernameError').textContent = '';
    }

    // Validate password
    if (password.trim() === '') {
        document.getElementById('passwordError').textContent = 'Password is required';
        return false;
    } else {
        document.getElementById('passwordError').textContent = '';
    }

    // If all validations pass, submit the form
    this.submit();
});