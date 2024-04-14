<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Mortgage Product</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="home-page-prospective.html">Home</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="create-account.php">Create an Account</a></li>
                <li><a href="broker-login.php">Broker Login</a></li>
                <li><a href="mortgage-product.php">Mortgage Product</a></li>
            </ul>
        </nav>
    </header>

    <div class="left-background"></div> 
    <div class="right-background"></div> 

    <div class="title-container">
        <h1>Create Mortgage Product</h1>
        <h2 style="text-align: center;">Create Minimum Criteria for Product</h2>
    </div>

    <div class="container">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $productName = $_POST['product_name'];
            $interestRate = $_POST['interest_rate'];
            $loanTerm = $_POST['loan_term'];
            $maximumLoanAmount = $_POST['maximum_loan_amount'];
            $minimumDownPayment = $_POST['minimum_down_payment'];


            if (!is_numeric($interestRate) || !is_numeric($maximumLoanAmount) || !ctype_digit($loanTerm) || !is_numeric($minimumDownPayment)) {
                echo "Invalid input. Please enter valid numeric values for interest rate, maximum loan amount, loan term (a positive integer), and minimum down payment.";
            } else if (!ctype_alpha(str_replace(' ', '', $productName))) {
                echo "Invalid product name. Product name should only contain letters and spaces.";
            } else {
                $db = new PDO("sqlite:C:/xampp/htdocs/Stage-3-1/Isaac Database.db");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = "INSERT INTO mortgage_product (product_name, interest_rate, loan_term, maximum_loan_amount, minimum_down_payment) VALUES (:product_name, :interest_rate, :loan_term, :maximum_loan_amount, :minimum_down_payment)";

                $stmt = $db->prepare($sql);

                $stmt->bindParam(':product_name', $productName);
                $stmt->bindParam(':interest_rate', $interestRate);
                $stmt->bindParam(':loan_term', $loanTerm);
                $stmt->bindParam(':maximum_loan_amount', $maximumLoanAmount);
                $stmt->bindParam(':minimum_down_payment', $minimumDownPayment);

                if ($stmt->execute()) {
                    echo "Mortgage product created successfully!";
                } else {
                    echo "Error creating mortgage product. Please try again.";
                }
            }
        }
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="product_name">Product Name:</label>
                <input type="text" id="product_name" name="product_name" placeholder="Enter Product Name" required>
            </div>
            
            <div class="form-group">
                <label for="interest_rate">Interest Rate:</label>
                <input type="text" id="interest_rate" name="interest_rate" placeholder="Enter Interest Rate" required>
            </div>
            
            <div style="margin-top: 20px; margin-bottom: 20px;"> 
                <label for="loan_term">Loan Term (months):</label>
                <input type="number" id="loan_term" name="loan_term" placeholder="Enter Loan Term" required>
            </div>
            
            <div class="form-group">
                <label for="maximum_loan_amount">Maximum Loan Amount:</label>
                <input type="text" id="maximum_loan_amount" name="maximum_loan_amount" placeholder="Enter Maximum Loan Amount" required>
            </div>
            
            <div class="form-group">
                <label for="minimum_down_payment">Minimum Down Payment:</label>
                <input type="text" id="minimum_down_payment" name="minimum_down_payment" placeholder="Enter Minimum Down Payment" required>
            </div>

            <div class="create-button">
                <button type="submit" name="submit_form">Create Mortgage Product</button>
            </div>
