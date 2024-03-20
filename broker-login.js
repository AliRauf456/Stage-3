document.querySelector('form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission

    // Get form data
    var employeeID = document.getElementById('employeeID').value;
    var password = document.getElementById('password').value;

  
    fetch('login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'employeeID=' + encodeURIComponent(employeeID) + '&password=' + encodeURIComponent(password)
    })
    .then(response => response.json()) 
    .then(data => {
        if (data.success) {
            alert('Login successful!');
            // Redirect or perform other actions on successful login
        } else {
            // Display error message
            document.getElementById('errorMessage').innerText = 'Invalid details';
            document.getElementById('errorMessage').style.color = 'red';
        }
    })
    .catch(error => {
        console.error('Request failed:', error);
        alert('Failed to process login. Please try again (Placeholder message: Youll find this part of the code in broker-login.js ');
    });
});
