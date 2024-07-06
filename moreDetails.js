        function showTab(tabId) {
            // Hide all tab content
            var tabs = document.getElementsByClassName('tab-content');
            for (var i = 0; i < tabs.length; i++) {
                tabs[i].style.display = 'none';
            }

            // Remove active class from all buttons
            var buttons = document.getElementsByClassName('tab-button');
            for (var i = 0; i < buttons.length; i++) {
                buttons[i].classList.remove('active');
            }

            // Show the selected tab content
            document.getElementById(tabId).style.display = 'block';

            // Add active class to the clicked button
            event.currentTarget.classList.add('active');
        }

        // Show the description tab by default
        document.addEventListener('DOMContentLoaded', function() {
            showTab('description');
            document.querySelector('.tab-button').classList.add('active');
        });
