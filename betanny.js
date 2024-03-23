document.addEventListener('DOMContentLoaded', () => {
    const logregBox = document.querySelector('.logreg-box');
    const userOptions = document.getElementsByName('role');
    const registerForm = document.querySelector('.form-box.register');

    // Function to perform custom actions
    function performCustomFunction() {
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

    // Add event listener to the register form
    if (registerForm) {
        registerForm.addEventListener('submit', (event) => {
            // Execute your custom function
            performCustomFunction();

            // Perform form submission
            event.preventDefault(); // Prevent default form submission
            const formData = new FormData(registerForm);
            fetch('insert.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                console.log(data); // Handle response from server
            })
            .catch(error => {
                console.error('Error:', error); // Handle error
            });
        });
    }
});
