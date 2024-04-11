<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_form'])) {
    // Retrieve form data
    $productName = $_POST['product_name'];
    $interestRate = $_POST['interest_rate'];
    $loanTerm = $_POST['loan_term'];
    $maxLoanAmount = $_POST['maximum_loan_amount'];
    $minDownPayment = $_POST['minimum_down_payment'];

    // Validate and sanitize form data (you can add more validation as needed)

    // Adjust the path to your SQLite database file
    $db_path = "C:/Users/gsyki/Database SQL stuff/Mortgage Database.db";

    // Connect to SQLite database
    $db = new SQLite3($db_path);

    // Check if connection is successful
    if (!$db) {
        die("Error: Unable to connect to database");
    }

    // Prepare SQL statement
    $sql = "INSERT INTO mortgage_products (product_name, interest_rate, loan_term, maximum_loan_amount, minimum_down_payment) 
            VALUES (:productName, :interestRate, :loanTerm, :maxLoanAmount, :minDownPayment)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':productName', $productName, SQLITE3_TEXT);
    $stmt->bindValue(':interestRate', $interestRate, SQLITE3_FLOAT);
    $stmt->bindValue(':loanTerm', $loanTerm, SQLITE3_INTEGER);
    $stmt->bindValue(':maxLoanAmount', $maxLoanAmount, SQLITE3_FLOAT);
    $stmt->bindValue(':minDownPayment', $minDownPayment, SQLITE3_FLOAT);

    // Execute SQL statement
    $result = $stmt->execute();

    // Check if insertion was successful
    if ($result) {
       

        // Redirect back to the previous page
        header("Location: create-mortgage-product.html");
        exit;
    } else {
        echo "Error: Unable to execute SQL statement";
    }
}
?>
