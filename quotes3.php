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
        <label for="principal">Principal (£):</label>
        <input type="number" id="principal" name="principal" value="150000"><br>

        <label for="annual_interest_rate">Annual Interest Rate (APR):</label>
        <input type="number" id="annual_interest_rate" name="annual_interest_rate" step="0.01" value="0.025"><br>

        <label for="term">Loan Term (months):</label>
        <input type="number" id="term" name="term" value="360"><br>

        <label for="change_term">Change Interest Rate After (months):</label>
        <input type="number" id="change_term" name="change_term" value="60"><br>

        <label for="new_interest_rate">New Interest Rate (APR):</label>
        <input type="number" id="new_interest_rate" name="new_interest_rate" step="0.01" value="0.04"><br>

        <button type="submit">Calculate</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Loan details from form inputs
        $principal = $_POST['principal']; // Principal amount
        $annualInterestRate = $_POST['annual_interest_rate']; // Initial annual interest rate
        $monthlyInterestRate = $annualInterestRate / 12; // Initial monthly interest rate
        $numberOfPayments = $_POST['term']; // Number of payments (months)
        $changeTerm = $_POST['change_term']; // Month when interest rate changes
        $newInterestRate = $_POST['new_interest_rate']; // New annual interest rate after change
        $newMonthlyInterestRate = $newInterestRate / 12; // New monthly interest rate after change

        // Initialize arrays to store results
        $paymentAmounts = array(); // Payment amounts
        $interestAmounts = array(); // Interest amounts
        $remainingBalances = array(); // Remaining loan balances

        // Calculate monthly payment using initial interest rate
        $monthlyPayment = $principal * ($monthlyInterestRate * pow(1 + $monthlyInterestRate, $numberOfPayments)) / (pow(1 + $monthlyInterestRate, $numberOfPayments) - 1);

        // Loop through each month
        for ($i = 1; $i <= $numberOfPayments; $i++) {
            // Check if interest rate needs to be updated
            if ($i == $changeTerm) {
                $monthlyInterestRate = $newMonthlyInterestRate; // Update monthly interest rate
                // Recalculate monthly payment with new interest rate
                $monthlyPayment = $principal * ($monthlyInterestRate * pow(1 + $monthlyInterestRate, $numberOfPayments - $i + 1)) / (pow(1 + $monthlyInterestRate, $numberOfPayments - $i + 1) - 1);
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
        echo "<h3>Amortization Schedule</h3>";
        echo "<table border='1'><tr><th>Month</th><th>Payment Amount</th><th>Interest Amount</th><th>Principal Payment</th><th>Remaining Balance</th></tr>";
        for ($i = 1; $i <= $numberOfPayments; $i++) {
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
