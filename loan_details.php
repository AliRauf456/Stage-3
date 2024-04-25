<?php

session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}

// Retrieve user ID from session
$user_id = $_SESSION['user_id'];

// Database connection
$dsn = 'sqlite:C:/xampp/htdocs/latest 18/Stage-3/Isaac Database.db';

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Get form data
    $reason_for_mortgage = $_POST['reason_for_mortgage'];
    $estimated_property_value = $_POST['estimated_property_value'];
    $amount_to_borrow = $_POST['amount_to_borrow'];
    $mortgage_term = $_POST['mortgage_term'];

    // Calculate Loan to Value (LTV) ratio
    $loan_to_value = ($amount_to_borrow / $estimated_property_value) * 100;

    try {

        $db = new PDO($dsn);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if user already has loan details in the database
        $sql = "SELECT COUNT(*) FROM loan_details WHERE user_id = :user_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            // Update loan details in the database
            $sql = "UPDATE loan_details SET reason_for_mortgage = :reason_for_mortgage, estimated_property_value = :estimated_property_value, amount_to_borrow = :amount_to_borrow, mortgage_term = :mortgage_term, loan_to_value = :loan_to_value WHERE user_id = :user_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':reason_for_mortgage', $reason_for_mortgage, PDO::PARAM_STR);
            $stmt->bindParam(':estimated_property_value', $estimated_property_value, PDO::PARAM_STR);
            $stmt->bindParam(':amount_to_borrow', $amount_to_borrow, PDO::PARAM_STR);
            $stmt->bindParam(':mortgage_term', $mortgage_term, PDO::PARAM_INT);
            $stmt->bindParam(':loan_to_value', $loan_to_value, PDO::PARAM_STR);
            $stmt->execute();
            echo "<p>Loan details updated successfully!</p>";
        } else {
            // Insert loan details into the database
            $sql = "INSERT INTO loan_details (user_id, reason_for_mortgage, estimated_property_value, amount_to_borrow, mortgage_term, loan_to_value) VALUES (:user_id, :reason_for_mortgage, :estimated_property_value, :amount_to_borrow, :mortgage_term, :loan_to_value)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':reason_for_mortgage', $reason_for_mortgage, PDO::PARAM_STR);
            $stmt->bindParam(':estimated_property_value', $estimated_property_value, PDO::PARAM_STR);
            $stmt->bindParam(':amount_to_borrow', $amount_to_borrow, PDO::PARAM_STR);
            $stmt->bindParam(':mortgage_term', $mortgage_term, PDO::PARAM_INT);
            $stmt->bindParam(':loan_to_value', $loan_to_value, PDO::PARAM_STR);
            $stmt->execute();
            echo "<p>Loan details submitted successfully!</p>";
        }
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        header {
            background-color: #67DC89;
            padding: 30px 0;
        }

        header nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            text-align: center;
        }

        header nav ul li {
            display: inline-block;
        }

        header nav ul li a {
            display: block;
            padding: 10px 20px;
            text-decoration: none;
            color: #333;
        }

        header nav ul li a:hover {
            background-color: #2db734;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left; /* Align text to left */
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            background-color: #67DC89;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #1ea537;
        }

        .left-background {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: 10%; /* Adjust width as needed */
            background-color: #4CAF50; /* Green color */
            z-index: -1; /* Move behind other content */
        }

        .right-background {
            position: fixed;
            top: 0;
            bottom: 0;
            right: 0;
            width: 10%; /* Adjust width as needed */
            background-color: #4CAF50; /* Green color */
            z-index: -1; /* Move behind other content */
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
    <li><a href="quotes2.php">financial details</a></li>
    <li><a href="loan_details.php">Loan values</a></li>
    <li><a href="mortgage-quote-generator.php"> calculator</a></li>
    <li><a href="view_mortgage-product.php"> sorting</a></li>
    <li><a href="mortgage-product-table.php"> product selection</a></li>
    <li><a href="log-out.html"> sign out</a></li>
            </ul>
        </nav>
    </header>
    <h1>Loan Details Form</h1>
    
    <div class="left-background"></div> 
    <div class="right-background"></div> 
    
    <div class="container">
        <label for="reason_for_mortgage">Reason for Mortgage:</label>  <div class="form-group">
        <select id="reason_for_mortgage" name="reason_for_mortgage" required>  
            <option value="buying_first_home">Buying Your First Home</option>
            <option value="remortgage">Remortgage</option>
            <option value="moving_house">Moving House</option>
        </select><br>

        <label for="estimated_property_value">Estimated Property Value (£):</label>  <div class="form-group">
        <input type="number" id="estimated_property_value" name="estimated_property_value" step="0.01" required><br>

        <label for="amount_to_borrow">Amount to Borrow (£):</label>  <div class="form-group">
        <input type="number" id="amount_to_borrow" name="amount_to_borrow" step="0.01" required><br>

        <label for="mortgage_term">Mortgage Term (months):</label>  <div class="form-group">
        <input type="number" id="mortgage_term" name="mortgage_term" required><br>

        <!-- Loan to Value (LTV) ratio will be calculated automatically -->
        <label for="loan_to_value">Loan to Value (%):</label>
        <input type="text" id="loan_to_value" name="loan_to_value" readonly><br>

        <button type="submit" name="submit">Submit</button>
    </form>
</body>
</html>
