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

// Database connection
$dsn = 'sqlite:C:/xampp\htdocs\latest 18\Stage-3\Isaac Database.db';

// Initialize variables
$error = '';
$success = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $annualIncome = $_POST['annualIncome'];
    $savings = $_POST['savings'];
    $debts = $_POST['debts'];
    $creditScore = $_POST['creditScore'];

    try {
        // Create a new PDO instance
        $db = new PDO($dsn);
        
        // Set PDO error mode to exception
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if the user ID exists in the financial details table
        $stmt_check = $db->prepare("SELECT user_id FROM financial_details WHERE user_id = :user_id");
        $stmt_check->bindParam(':user_id', $userId);
        $stmt_check->execute();
        $row = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // If the user ID exists, perform a replacement
            $stmt = $db->prepare("UPDATE financial_details SET annual_income = :annual_income, savings = :savings, debts = :debts, credit_score = :credit_score WHERE user_id = :user_id");
        } else {
            // If the user ID doesn't exist, perform an insertion
            $stmt = $db->prepare("INSERT INTO financial_details (user_id, annual_income, savings, debts, credit_score) VALUES (:user_id, :annual_income, :savings, :debts, :credit_score)");
        }

        // Bind parameters
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':annual_income', $annualIncome);
        $stmt->bindParam(':savings', $savings);
        $stmt->bindParam(':debts', $debts);
        $stmt->bindParam(':credit_score', $creditScore);

        // Execute the statement
        $stmt->execute();

        // Set success message
        $success = "Financial details saved successfully!";
    } catch (PDOException $e) {
        // Set error message
        $error = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Details Form</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
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

        .error-message, .success-message {
            width: 100%;
            margin-bottom: 20px;
            padding: 10px;
            box-sizing: border-box;
            border-radius: 5px;
        }

        .error-message {
            background-color: #f44336;
            color: white;
        }

        .success-message {
            background-color: #4CAF50;
            color: white;
        }
    </style>   

    <li><a href="quotes2.php">financial details</a></li>
    <li><a href="loan_details.php">Loan values</a></li>
    <li><a href="mortgage-quote-generator.php"> calculator</a></li>
    <li><a href="view_mortgage-product.php"> sorting</a></li>
    <li><a href="mortgage-product-table.php"> product selection</a></li>
    <li><a href="log-out.html"> sign out</a></li>
            </ul>
        </nav>
    </header>

    <div class="left-background"></div> 
    <div class="right-background"></div> 
    
    <div class="container">
        <h1>Financial Details Form</h1>
        <?php if ($error): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success-message"><?php echo $success; ?></div>
        <?php endif; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="userId" value="<?php echo $userId; ?>">
            <div class="form-group">
                <label for="annualIncome">Annual Income:</label>
                <input type="number" id="annualIncome" name="annualIncome" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="savings">Savings:</label>
                <input type="number" id="savings" name="savings" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="debts">Debts:</label>
                <input type="number" id="debts" name="debts" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="creditScore">Credit Score:</label>
                <input type="number" id="creditScore" name="creditScore">
            </div>
            <input type="submit" value="Save">
        </form>
    </div>
</body>
</html>
