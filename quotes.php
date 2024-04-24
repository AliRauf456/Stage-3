<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fixed Rate Mortgage Calculator</title>
</head>
<body>
    <h2>Fixed Rate Mortgage Calculator</h2>

    <form method="post">
        <label for="selected_product">Select a Mortgage Product:</label>
        <select id="selected_product" name="selected_product">
            <?php
            // Connect to the database
            $db = new PDO('sqlite:C:/xampp/htdocs/latest 18/Stage-3/Isaac Database.db');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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

        // Calculate monthly payment for the first term
        $monthlyPayment1 = $principal * ($monthlyInterestRate * pow(1 + $monthlyInterestRate, $totalLoanTerm)) / (pow(1 + $monthlyInterestRate, $totalLoanTerm) - 1);

        // Calculate remaining principal after the first term
        $remainingPrincipal = $principal;
        for ($i = 1; $i <= $primaryLoanTerm; $i++) {
            $remainingPrincipal -= $monthlyPayment1 - $remainingPrincipal * $monthlyInterestRate;
        }

        // Calculate monthly payment for the second term based on the remaining principal
        $monthlyPayment2 = $remainingPrincipal * ($secondaryInterestRate * pow(1 + $secondaryInterestRate, $secondaryLoanTerm)) / (pow(1 + $secondaryInterestRate, $secondaryLoanTerm) - 1);

        // Output results
        echo "<h3>Payment Amounts</h3>";
        echo "<table border='1'><tr><th>Term</th><th>Payment Amount</th></tr>";
        echo "<tr><td>1st Term</td><td>£" . number_format($monthlyPayment1, 2) . "</td></tr>";
        echo "<tr><td>After Interest Rate Change</td><td>£" . number_format($monthlyPayment2, 2) . "</td></tr>";
        echo "</table>";
    }
    ?>
</body>
</html>

