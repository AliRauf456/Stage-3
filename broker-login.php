<?php
// Ali, replace tthe values with your actual database credentials
$servername = "localhost";
$username = "username";
$password = "password";
$database = "your_database";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data
$brokerID = $_POST['brokerID']; // not sure what the ID in the database looks like. could you change it if its necessary Ali
$password = $_POST['password'];

$sql = "SELECT * FROM broker WHERE broker_id = '$brokerID'";
$result = $conn->query($sql);

// Check if broker exists
if ($result->num_rows > 0) {
    // Broker exists
    $row = $result->fetch_assoc();
    
    // Verify password
    if (password_verify($password, $row['password'])) {
        // Successful login
        // You can probably add additional broker details 
        echo json_encode(array('success' => true, 'broker' => $row));
    } else {
        // login didn't work (invalid password)
        echo json_encode(array('success' => false, 'message' => 'Invalid password.'));
    }
} else {
    // broker not found
    echo json_encode(array('success' => false, 'message' => 'Broker not found.'));
}

$conn->close();
?>
