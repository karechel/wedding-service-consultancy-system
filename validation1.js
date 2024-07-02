const userOptions = document.getElementsByName('role');
const logregBox = document.querySelector('.logreg-box');
document.getElementById('login-form').addEventListener('submit', function(event) {
   
    let isValid = true;

    // Username validation
    const username = document.getElementById('username').value;
    const usernameError = document.getElementById('usernameError');
    if (username === '') {
        usernameError.textContent = 'Username is required.';
        isValid = false;
    } else {
        usernameError.textContent = '';
    }

    // Password validation
    const password = document.getElementById('password').value;
    var hasNumber=/\d/.test(password);
    const passwordError = document.getElementById('passwordError');
    if (password === '') {
        passwordError.textContent = 'Password is required.';
        isValid = false;
    } 
    else if(password.length<8 || !hasNumber){
         passwordError.textContent ='Incorrect password format';
    }
    else {
        passwordError.textContent = '';
    }

    
    if (isValid) {
       
        
    }
});

document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordInput = document.getElementById('password');
    const togglePasswordIcon = this.querySelector('i');
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        togglePasswordIcon.classList.remove('bxs-show');
        togglePasswordIcon.classList.add('bxs-hide');
    } else {
        passwordInput.type = 'password';
        togglePasswordIcon.classList.remove('bxs-hide');
        togglePasswordIcon.classList.add('bxs-show');
    }
});

//register form validation
document.getElementById('registerform').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission
    const userOptions = document.getElementsByName('role');
const logregBox = document.querySelector('.logreg-box');
    let isValid = true;

    const username = document.getElementById('rUsername').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('rPassword').value.trim();
    const confirmPassword = document.getElementById('confirmPassword').value.trim();
    // const agreeTerms = document.getElementById('agreeTerms').checked;

    const usernameError = document.getElementById('rusernameError');
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('rPasswordError');
    const confirmPasswordError = document.getElementById('confirmPasswordError');

    // Clear previous error messages
    usernameError.textContent = '';
    emailError.textContent = '';
    passwordError.textContent = '';
    confirmPasswordError.textContent = '';

    // Validate username
    if (username === '') {
        usernameError.textContent = 'Username is required.';
        isValid = false;
    }

    // Validate email
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (email === '') {
        emailError.textContent = 'Email is required.';
        isValid = false;
    } else if (!emailPattern.test(email)) {
        emailError.textContent = 'Please enter a valid email address.';
        isValid = false;
    }

    // Validate password
    if (password === '') {
        passwordError.textContent = 'Password is required.';
        isValid = false;
    } else if (password.length < 8 || !/\d/.test(password)) {
        passwordError.textContent = 'Password must contain at least one number and be at least 8 characters long.';
        isValid = false;
    }

    // Validate confirm password
    if (confirmPassword === '') {
        confirmPasswordError.textContent = 'Confirm Password is required.';
        isValid = false;
    } else if (password !== confirmPassword) {
        confirmPasswordError.textContent = 'Passwords do not match.';
        isValid = false;
    }

    // Validate agree to terms
    // if (!agreeTerms) {
    //     alert('Please agree to the terms & conditions.');
    //     isValid = false;
    // }

    // If the form is valid, submit it
    if (isValid) {
        const formData = new FormData(document.getElementById('registerform'));
        formData.append('register_user_form', '1');

        fetch('insert.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => console.log(data))
        .catch((error) => {
            console.error('Error:', error);
        });
    }
    if (logregBox) {
        for (let i = 0; i < userOptions.length; i++) {
            if (userOptions[i].checked) {
                if (userOptions[i].value === 'Client') {
                    logregBox.classList.add('setup-client-active');
                    logregBox.classList.remove('setup-vendor-active');
                } else if (userOptions[i].value === 'Vendor') {
                    logregBox.classList.add('setup-vendor-active');
                    logregBox.classList.remove('setup-client-active');
                }
                break;
            }
        }
    }
});

document.getElementById('rtogglePassword').addEventListener('click', function() {
    const passwordInput = document.getElementById('rPassword');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    const togglePasswordIcon = this.querySelector('i');
    if (passwordInput.type === 'password' || confirmPasswordInput.type === 'password') {
        passwordInput.type = 'text';
        confirmPasswordInput.type = 'text';
        togglePasswordIcon.classList.remove('bxs-show');
        togglePasswordIcon.classList.add('bxs-hide');
    } else {
        passwordInput.type = 'password';
        confirmPasswordInput.type = 'password';
        togglePasswordIcon.classList.remove('bxs-hide');
        togglePasswordIcon.classList.add('bxs-show');
    }
});

//validation for client setup
document.getElementById('setupclientForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission

    let isValid = true;

    const fname = document.getElementById('fname').value.trim();
    const lname = document.getElementById('lname').value.trim();
    const contact_number = document.getElementById('contact_number').value.trim();
    const location = document.getElementById('location').value.trim();
    const wedding_date = document.getElementById('wedding_date').value.trim();

    const fnameError = document.getElementById('fnameError');
    const lnameError = document.getElementById('lnameError');
    const contactError = document.getElementById('contactError');
    const locationError = document.getElementById('locationError');
    const weddingDateError = document.getElementById('weddingDateError');

    // Clear previous error messages
    fnameError.textContent = '';
    lnameError.textContent = '';
    contactError.textContent = '';
    locationError.textContent = '';
    weddingDateError.textContent = '';

    // Validate fields
    if (fname === '') {
        fnameError.textContent = 'First name is required.';
        isValid = false;
    }
    if (lname === '') {
        lnameError.textContent = 'Last name is required.';
        isValid = false;
    }
    if (contact_number === '') {
        contactError.textContent = 'Contact number is required.';
        isValid = false;
    } else if (isNaN(contact_number)) {
        contactError.textContent = 'Contact number should be a numeric value only.';
        isValid = false;
    }
    if (location === '') {
        locationError.textContent = 'Location is required.';
        isValid = false;
    }
    if (wedding_date === '') {
        weddingDateError.textContent = 'Wedding date is required.';
        isValid = false;
    }

    // If the form is valid, submit it
    if (isValid) {
        const formData = new FormData(document.getElementById('setupvendorForm'));
        fetch('insert.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
           alert("Your account has been registered successfully. You can now Login");
           window.location.href = 'index.html';
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    }
    else{
        alert("There was an error processing your request. Please try again.")
    }
});

//validation for vendor setup
document.getElementById('setupvendorForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission

    let isValid = true;

    const vendor_name = document.getElementById('vendor_name').value.trim();
    const category = document.getElementById('category').value.trim();
    const location = document.getElementById('rlocation').value.trim();
    const description = document.getElementById('description').value.trim();

    const vendorNameError = document.getElementById('vendorNameError');
    const categoryError = document.getElementById('categoryError');
    const locationError = document.getElementById('rlocationError');
    const descriptionError = document.getElementById('descriptionError');

    // Clear previous error messages
    vendorNameError.textContent = '';
    categoryError.textContent = '';
    locationError.textContent = '';
    descriptionError.textContent = '';

    // Validate fields
    if (vendor_name === '') {
        vendorNameError.textContent = 'Business name is required.';
        isValid = false;
    }
    if (category === '') {
        categoryError.textContent = 'Category/services are required.';
        isValid = false;
    }
    if (location === '') {
        locationError.textContent = 'Location is required.';
        isValid = false;
    }
    if (description === '') {
        descriptionError.textContent = 'Description is required.';
        isValid = false;
    }

    // If the form is valid, submit it
    if (isValid) {
        // Submit the form data via fetch API
        const formData = new FormData(document.getElementById('setupvendorForm'));
        fetch('insert.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
           alert("Your account has been registered successfully");
           window.location.href = 'index.html';
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    }
    else{
        alert("There was an error processing your request. Please try again.")
    }
});
