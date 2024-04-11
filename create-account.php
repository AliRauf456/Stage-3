<?php
$database_file = "/Applications/XAMPP/xamppfiles/htdocs/Stage-3/MortgageSystem.sqbpro";
$db = new SQLite3($database_file);
if(!$db) {
    die("Connection failed: " . $db->lastErrorMsg());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $firstname = $_POST['firstName'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($password !== $confirmPassword) {
        echo "Passwords do not match.";
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $db->prepare("INSERT INTO user (firstname, surname, email, password) VALUES (:firstname, :surname, :email, :password)");
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':surname', $surname);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);

    $result = $stmt->execute();

    if ($result) {
        echo "Account created successfully.";
    } else {
        echo "Error creating account.";
    }
}
?>
