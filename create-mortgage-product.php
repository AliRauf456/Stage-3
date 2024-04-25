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
                <li><a href="mortgage-product.php">Home</a></li>
                <li><a href="broker-log-out.html">Sign Out</a></li>
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
        $dsn = 'sqlite:C:/xampp/htdocs/latest 18/Stage-3/Isaac Database.db';

        try {
            // Create a new PDO instance
            $db = new PDO($dsn);
            
            // Set PDO error mode to exception
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Display a success message if connected successfully
            echo "Connected to the database successfully";
        } catch(PDOException $e) {
            // Display an error message if connection fails
            echo "Connection failed: " . $e->getMessage();
        }
        

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve form data
            $productName = $_POST['product_name'];
            $interestRate = $_POST['interest_rate'];
            $secondaryInterestRate = $_POST['secondary_interest_rate'];
            $loanTerm = $_POST['loan_term'];
            $secondaryLoanTerm = $_POST['secondary_loan_term'];
            $maximumLoanAmount = $_POST['maximum_loan_amount'];
            $minimumDownPayment = $_POST['minimum_down_payment'];
            $creditScore = $_POST['credit_score'];
            $mortgageType = $_POST['mortgage_type'];

            try {
                // Prepare an SQL statement to insert data into the database
                $sql = "INSERT INTO mortgage_product (product_name, interest_rate, secondary_interest_rate, loan_term, secondary_loan_term, maximum_loan_amount, minimum_down_payment, credit_score, mortgage_type)
                        VALUES (:product_name, :interest_rate, :secondary_interest_rate, :loan_term, :secondary_loan_term, :maximum_loan_amount, :minimum_down_payment, :credit_score, :mortgage_type)";
                
                // Prepare the statement
                $stmt = $db->prepare($sql);
                
                // Bind parameters to the prepared statement
                $stmt->bindParam(':product_name', $productName);
                $stmt->bindParam(':interest_rate', $interestRate);
                $stmt->bindParam(':secondary_interest_rate', $secondaryInterestRate);
                $stmt->bindParam(':loan_term', $loanTerm);
                $stmt->bindParam(':secondary_loan_term', $secondaryLoanTerm);
                $stmt->bindParam(':maximum_loan_amount', $maximumLoanAmount);
                $stmt->bindParam(':minimum_down_payment', $minimumDownPayment);
                $stmt->bindParam(':credit_score', $creditScore);
                $stmt->bindParam(':mortgage_type', $mortgageType);
                
                // Execute the statement
                $stmt->execute();
                
                echo "Mortgage product created successfully!";
            } catch (PDOException $e) {
                echo "Error creating mortgage product: " . $e->getMessage();
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

            <div class="form-group">
                <label for="secondary_interest_rate">Secondary Interest Rate:</label>
                <input type="text" id="secondary_interest_rate" name="secondary_interest_rate" placeholder="Enter Secondary Interest Rate" required>
            </div>
            
            <div style="margin-top: 20px; margin-bottom: 20px;"> 
                <label for="loan_term">Loan Term (months):</label>
                <input type="number" id="loan_term" name="loan_term" placeholder="Enter Loan Term" required>
            </div>
            
            <div class="form-group">
                <label for="secondary_loan_term">Secondary Loan Term (months):</label>
                <input type="number" id="secondary_loan_term" name="secondary_loan_term" placeholder="Enter Secondary Loan Term" required>
            </div>
            
            <div class="form-group">
                <label for="maximum_loan_amount">Maximum Loan Amount:</label>
                <input type="text" id="maximum_loan_amount" name="maximum_loan_amount" placeholder="Enter Maximum Loan Amount" required>
            </div>
            
            <div class="form-group">
                <label for="minimum_down_payment">Minimum Down Payment:</label>
                <input type="text" id="minimum_down_payment" name="minimum_down_payment" placeholder="Enter Minimum Down Payment" required>
            </div>

            <div class="form-group">
                <label for="credit_score">Minimum Credit Score Required:</label>
                <input type="text" id="credit_score" name="credit_score" placeholder="Enter Minimum Credit Score" required>
            </div>

            <div class="form-group">
                <label for="mortgage_type">Mortgage Type:</label>
                <select id="mortgage_type" name="mortgage_type" required>
                    <option value="Fixed">Fixed</option>
                    <option value="Variable">Variable</option>
                    <option value="Tracker">Tracker</option>
                </select>
            </div>

            <div class="create-button">
                <button type="submit" name="submit_form">Create Mortgage Product</button>
            </div>
        </form>
    </div>
</body>
</html>