<?php

session_start();

// Get user ID from session
$userId = $_SESSION['user_id'];


$dsn = 'sqlite:C:/xampp/htdocs/latest 18/Stage-3/Isaac Database.db';

try {
    // Connect to the database using the new DSN
    $db = new PDO($dsn);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if user is logged in or not
    if (!isset($_SESSION['user_id'])) {
        // Redirect to login page or handle unauthorized access
        header("Location: login.php");
        exit();
    }
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fixed Rate Mortgage Calculator</title>
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

        h2 {
            text-align: center;
            margin-top: 20px;
        }

        form {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            text-align: center;
        }

        form label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        form input[type="number"] {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin-bottom: 10px;
        }

        form button[type="submit"] {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            background-color: #67DC89;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }

        table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<header>
    <nav>
        <ul>
            <li><a href="quotes2.php">Financial Details</a></li>
            <li><a href="loan_details.php">Loan Values</a></li>
            <li><a href="mortgage-quote-generator.php">Calculator</a></li>
            <li><a href="view_mortgage-product.php">Sorting</a></li>
            <li><a href="mortgage-product-table.php">Product Selection</a></li>
            <li><a href="log-out.html">Sign Out</a></li>
        </ul>
    </nav>
</header>

<h2>Fixed Rate Mortgage Calculator</h2>

<form method="post">
    <label for="selected_product">Select a Mortgage Product:</label>
    <select id="selected_product" name="selected_product">
        <?php
        // Fetch mortgage products from the database
        $sql = "SELECT mortgage_product_id, product_name FROM mortgage_product";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Display dropdown menu to select a mortgage product
        foreach ($products as $product) {
            echo "<option value='{$product['mortgage_product_id']}'>{$product['product_name']}</option>";
        }
        ?>
    </select><br>

    <label for="principal">Principal (£):</label>
    <input type="number" id="principal" name="principal" value="150000"><br>

    <button type="submit">Calculate</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get selected mortgage product ID
    $selectedProductId = $_POST['selected_product'];

    // Fetch mortgage product details from the database
    $sql = "SELECT interest_rate, secondary_interest_rate, loan_term, secondary_loan_term FROM mortgage_product WHERE mortgage_product_id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $selectedProductId, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Loan details from form inputs
    $principal = $_POST['principal']; // Principal amount
    $annualInterestRate = $product['interest_rate'] / 100; // Initial annual interest rate
    $monthlyInterestRate = $annualInterestRate / 12; // Initial monthly interest rate
    $primaryLoanTerm = $product['loan_term']; // Primary loan term in months
    $secondaryInterestRate = $product['secondary_interest_rate'] / 100; // Secondary interest rate
    $secondaryLoanTerm = $product['secondary_loan_term']; // Secondary loan term in months
    $totalLoanTerm = $primaryLoanTerm + $secondaryLoanTerm; // Total loan term

    // Initialize arrays to store results
    $paymentAmounts = array(); // Payment amounts
    $interestAmounts = array(); // Interest amounts
    $remainingBalances = array(); // Remaining loan balances

    // Calculate monthly payment using total loan term
    $monthlyPayment = $principal * ($monthlyInterestRate * pow(1 + $monthlyInterestRate, $totalLoanTerm)) / (pow(1 + $monthlyInterestRate, $totalLoanTerm) - 1);

    // Loop through each month
    for ($i = 1; $i <= $totalLoanTerm; $i++) {
        // Check if interest rate needs to be updated after the primary loan term
        if ($i > $primaryLoanTerm) {
            $annualInterestRate = $secondaryInterestRate; // Update to secondary interest rate
            $monthlyInterestRate = $annualInterestRate / 12; // Update monthly interest rate
            
            // Recalculate monthly payment with new interest rate
            $monthlyPayment = $principal * ($monthlyInterestRate * pow(1 + $monthlyInterestRate, $totalLoanTerm - $i + 1)) / (pow(1 + $monthlyInterestRate, $totalLoanTerm - $i + 1) - 1);
        }

        // Calculate interest for the current month
        $interest = $principal * $monthlyInterestRate;

        // Calculate principal for the current month
        $principalPayment = $monthlyPayment - $interest;

        // Update remaining loan balance after payment
        $principal -= $principalPayment;

        // Store payment amount, interest amount, and remaining balance for the current month
        $paymentAmounts[$i] = $monthlyPayment;
        $interestAmounts[$i] = $interest;
        $remainingBalances[$i] = $principal;
    }

    // Output results
    echo "<h3>detailed view</h3>";
    echo "<table><tr><th>Month</th><th>Payment Amount</th><th>Interest Amount</th><th>Principal Payment</th><th>Remaining Balance</th></tr>";
    for ($i = 1; $i <= $totalLoanTerm; $i++) {
        echo "<tr>";
        echo "<td>$i</td>";
        echo "<td>£" . number_format($paymentAmounts[$i], 2) . "</td>";
        echo "<td>£" . number_format($interestAmounts[$i], 2) . "</td>";
        echo "<td>£" . number_format($paymentAmounts[$i] - $interestAmounts[$i], 2) . "</td>";
        echo "<td>£" . number_format($remainingBalances[$i], 2) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>
</body>
</html>
