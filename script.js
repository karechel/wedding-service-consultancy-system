document.addEventListener('DOMContentLoaded', () => {
    const logregBox = document.querySelector('.logreg-box');
    const loginLink = document.querySelector('.login-link');
    const registerLink = document.querySelector('.register-link');
    const signupbtn = document.querySelector('.continue.btn');
    const userOptions = document.getElementsByName('role');
    const registerForm = document.querySelector('.form-box.register form');

    const urlParams = new URLSearchParams(window.location.search);
    const registerParam = urlParams.get('register');

    if (registerParam === 'true') {
        // Open the sign-up form
        if (logregBox) {
            logregBox.classList.add('active');
            logregBox.classList.remove('setup-client-active', 'setup-vendor-active');
        }
    }

    if (registerLink) {
        registerLink.addEventListener('click', (event) => {
            event.preventDefault();
            if (logregBox) {
                logregBox.classList.add('active');
                logregBox.classList.remove('setup-client-active', 'setup-vendor-active');
            }
        });
    }

    if (loginLink) {
        loginLink.addEventListener('click', (event) => {
            event.preventDefault();
            if (logregBox) {
                logregBox.classList.remove('active', 'setup-client-active', 'setup-vendor-active');
            }
        });
    }

    if (registerForm) {
        registerForm.addEventListener('submit', (event) => {
            event.preventDefault();

            // Get form values
            const username = registerForm.elements['Username'].value;
            const email = registerForm.elements['email'].value;
            const password = registerForm.elements['Password'].value;
            const confirmPassword = registerForm.elements['confirmPassword'].value;
            const role = registerForm.elements['role'].value;
            const agreeTerms=registerForm.elements['agreeTerms'].checked;

            if (username.trim() === '' || password.trim() === '' || email.trim() === '' || confirmPassword.trim() === '') {
                alert('Please fill in all fields.');
                return;
            }
            if (password.length < 8 || !/\d/.test(password)) {
                alert('Password must contain at least one number and be at least 8 characters long.');
                return;
            }
            if (password !== confirmPassword) {
                alert('Passwords do not match.');
                return;
            }
            if (email.indexOf('@') === -1 || email.lastIndexOf('.') < email.indexOf('@') + 2 || email.lastIndexOf('.') + 2 >= email.length) {
                alert('Please enter a valid email address.');
                return;
            }
            if(!agreeTerms){
                alert('Please agree to the terms & conditions.')
                return
            }
            // Construct form data including the hidden field
            const formData = new FormData(registerForm);
            formData.append('register_user_form', '1');

            // Submit the form data
            fetch('insert.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => console.log(data))
            .catch((error) => {
                console.error('Error:', error);
            });

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
    }
});

//handle form submissions
function handleFormSubmission(formElement, hiddenFieldName, hiddenFieldValue) {
    if (formElement) {
        formElement.addEventListener('submit', (event) => {
            event.preventDefault();

            // Get form values
            const formData = new FormData(formElement);

            // Append the hidden field data
            formData.append(hiddenFieldName, hiddenFieldValue);

            // Submit the form data
            fetch(formElement.action, {
                method: formElement.method,
                body: formData
            })
            .then(response => response.text())
            .then(data => console.log(data))
            .catch((error) => {
                console.error('Error:', error);
            });
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
   
    const setupAccountForm = document.querySelector('.form-box.setup-client form');
    const vendorForm = document.querySelector('.form-box.setup-vendor form');
    const serviceForm = document.querySelector('.form-box.services form');
    const ManagerForm = document.querySelector('.form-box.manager form');
   
     handleFormSubmission(setupAccountForm, 'client-account', '1');
    handleFormSubmission(vendorForm, 'vendor-account', '1');
    handleFormSubmission(serviceForm, 'services_form', '1');
    handleFormSubmission(serviceForm, 'manager-account', '1');
});





//form validations

function validateLoginForm() {
    // Retrieve input values
    var username = document.loginform.username.value;
    var password = document.loginform.password.value;
    var hasNumber=/\d/.test(password);
    // Perform validation
    if (username == null || username == ''||password==null|| password=='') {
        alert('Please enter both username and password.');
        return false;
    }
    else if(password.length<8 || !hasNumber){
        alert('Password must contain at least one number and must be at least 8 characters long');
        return false;
    }
    
    return true; // Form is valid
}



function validatesetupClientForm() {
    // Retrieve input values
    var fname = document.setupclient.fname.value;
    var lname = document.setupclient.lname.value;
    var contact_number = document.setupclient.contact_number.value;
    var location = document.setupclient.location.value;
    var wedding_date = document.setupclient.wedding_date.value;
   
    // Perform validation
    if (fname == null || fname == '' || lname == null || lname == '' || contact_number == null || contact_number == '' || location == null || location == '' || wedding_date == null || wedding_date == '') {
        alert('Please fill in all fields.');
        return false;
    } else if (isNaN(contact_number)) {
        alert('Contact number should be a numeric value only');
        return false;
    }
    
    
    return true; // Form is valid
}



function validateSetupVendorForm() {
    // Retrieve input values
    var vendor_name = document.setupvendor.vendor_name.value;
    var category = document.setupvendor.category.value;
    var location = document.setupvendor.location.value;
    
   
    // Perform validation
    if (vendor_name == null || vendor_name == '' || category == null || category == '' || location == null || location == '') {
        alert('Please fill in all fields.');
        return false;
    } 
    return true; // Form is valid
}

function toggleHeart(element) {
    if (element.classList.contains('bx-heart')) {
      // If it's the regular heart, change to solid red heart
      element.classList.remove('bx-heart');
      element.classList.add('bxs-heart');
      element.style.color = '#ff0000';
    } else {
      // If it's the solid red heart, change back to regular heart
      element.classList.remove('bxs-heart');
      element.classList.add('bx-heart');
      element.style.color = ''; // Remove the color style
    }
  }
  document.getElementById('weddingServicesLink').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default link behavior

    var dropdown = document.getElementById('servicesDropdown');
    dropdown.classList.toggle('show');

    if (dropdown.classList.contains('show')) {
        loadServices();
    }
});
document.addEventListener('DOMContentLoaded', function() {
    var selectElement = document.getElementById('servicesSelect');

    selectElement.addEventListener('change', function() {
        var serviceCategory = this.value;
        fetch('getServices.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'category=' + encodeURIComponent(serviceCategory)
        })
        .then(response => response.json())
        .then(services => {
            // Process the retrieved services
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});


