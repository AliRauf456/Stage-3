<?php
// Start session (if not already started)
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}

// Retrieve user ID from session
$userId = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Details Form</title>
</head>
<body>
    <h1>Financial Details Form</h1>
    <form action="save_financial_details.php" method="post">
        <!-- Use hidden input field to include user ID -->
        <input type="hidden" name="userId" value="<?php echo $userId; ?>">

        <label for="annualIncome">Annual Income:</label>
        <input type="number" id="annualIncome" name="annualIncome" step="0.01" required><br><br>

        <label for="savings">Savings:</label>
        <input type="number" id="savings" name="savings" step="0.01" required><br><br>

        <label for="debts">Debts:</label>
        <input type="number" id="debts" name="debts" step="0.01" required><br><br>

        <label for="creditScore">Credit Score:</label>
        <input type="number" id="creditScore" name="creditScore"><br><br>

        <input type="submit" value="Save">
    </form>
</body>
</html>
