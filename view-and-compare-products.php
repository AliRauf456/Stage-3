<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mortgage Products</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .mortgage-product {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
        }
        .product-details {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="log-out.html">Sign Out</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <div class="left-background"></div> 
        <div class="right-background"></div> 

        <form method="post">
            <label for="down_payment">Down Payment:</label>
            <input type="number" id="down_payment" name="down_payment" required><br>

            <label for="loan_term">Loan Term (years):</label>
            <input type="number" id="loan_term" name="loan_term" required><br>

            <label for="maximum_loan_amount">Maximum Loan Amount:</label>
            <input type="number" id="maximum_loan_amount" name="maximum_loan_amount" required><br>

            <input type="submit" value="Submit">
        </form>

        <?php
       
        $path = 'C:/xampp/htdocs/Stage-3-1/Isaac Database.db';
        $realPath = realpath($path);

        if ($realPath === false) {
            die("The path '$path' does not exist.");
        }

        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $down_payment = $_POST["down_payment"];
            $loan_term = $_POST["loan_term"];
            $maximum_loan_amount = $_POST["maximum_loan_amount"];

            
            $db = new SQLite3($path);

            
            if (!$db) {
                echo "Error: Unable to open database.";
            } else {
                //  SQL statement to fetch mortgage products based on user input criteria
                $stmt = $db->prepare("SELECT * FROM mortgage_product 
                                    WHERE minimum_down_payment <= :down_payment 
                                    AND loan_term <= :loan_term 
                                    AND maximum_loan_amount <= :maximum_loan_amount
                                    LIMIT 3");

                
                if (!$stmt) {
                    echo "Error: Unable to prepare statement.";
                } else {
                    
                    $stmt->bindParam(':down_payment', $down_payment);
                    $stmt->bindParam(':loan_term', $loan_term);
                    $stmt->bindParam(':maximum_loan_amount', $maximum_loan_amount);

                    
                    $result = $stmt->execute();

                    
                    if ($result->numColumns() > 0) {
                        $bestProduct = null;
                        $lowestInterestRate = PHP_FLOAT_MAX;
                        $longestLoanTerm = 0;
                        $highestMaximumLoanAmount = 0;
                        $lowestDownPayment = PHP_FLOAT_MAX;

                        // Iterate through retrieved mortgage products
                        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                            // Compare each product's interest rate, loan term, maximum loan amount, and down payment
                            
                            $interestRate = floatval($row['interest_rate']);
                            $loanTerm = intval($row['loan_term']);
                            $maximumLoanAmount = floatval($row['maximum_loan_amount']);
                            $minimumDownPayment = floatval($row['minimum_down_payment']);

                            if ($interestRate < $lowestInterestRate || ($interestRate == $lowestInterestRate && $loanTerm > $longestLoanTerm) || 
                                ($interestRate == $lowestInterestRate && $loanTerm == $longestLoanTerm && $maximumLoanAmount > $highestMaximumLoanAmount) ||
                                ($interestRate == $lowestInterestRate && $loanTerm == $longestLoanTerm && $maximumLoanAmount == $highestMaximumLoanAmount && $minimumDownPayment < $lowestDownPayment)) {
                                $bestProduct = $row;
                                $lowestInterestRate = $interestRate;
                                $longestLoanTerm = $loanTerm;
                                $highestMaximumLoanAmount = $maximumLoanAmount;
                                $lowestDownPayment = $minimumDownPayment;
                            }
                        }

                        // Display the best mortgage product
                        if ($bestProduct) {
                            echo '<div class="mortgage-product">';
                            echo '<div class="product-details">Best Mortgage Product Based on Criteria:</div>';
                            echo '<div class="product-details">Mortgage Type: ' . $bestProduct["product_name"] . '</div>';
                            echo '<div class="product-details">Interest Rate: ' . $bestProduct["interest_rate"] . '%</div>';
                            echo '<div class="product-details">Loan Term: ' . $bestProduct["loan_term"] . ' years</div>';
                            echo '<div class="product-details">Maximum Loan Amount: £' . $bestProduct["maximum_loan_amount"] . '</div>';
                            echo '<div class="product-details">Minimum Down Payment: £' . $bestProduct["minimum_down_payment"] . '</div>';
                            echo '</div>';
                        } else {
                            echo "No mortgage products found within the specified range.";
                        }
                    } else {
                        echo "No mortgage products found within the specified range.";
                    }

                    
                    $stmt->close();
                    $db->close();
                }
            }
        }
        ?>
    </div>
</body>
</html>
