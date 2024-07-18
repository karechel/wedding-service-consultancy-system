document.addEventListener('DOMContentLoaded', function() {
    // Get all the nav links
    var navLinks = document.querySelectorAll('.navbar a');

    // Get the current URL path
    var currentPath = window.location.pathname.split('/').pop();

    // Loop through the links and add the "active" class to the one that matches the current path
    navLinks.forEach(function(link) {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');
        }
    });
});
