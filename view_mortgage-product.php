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
                <li><a href="home-page-prospective.html">Home</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="create-account.php">Create an Account</a></li>
                <li><a href="broker-login.php">Broker Login</a></li>
                <li><a href="mortgage-product.php">Mortgage Products</a></li>
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
    // Your PHP code here

    // Path to the SQLite database
    $path = 'C:/xampp/htdocs/Stage-3-1/Isaac Database.db';
    $realPath = realpath($path);

    if ($realPath === false) {
        die("The path '$path' does not exist.");
    }

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve user input from the form
        $down_payment = $_POST["down_payment"];
        $loan_term = $_POST["loan_term"];
        $maximum_loan_amount = $_POST["maximum_loan_amount"];

        // Connect to the SQLite database
        $db = new SQLite3($path);

        // Check if the connection is successful
        if (!$db) {
            echo "Error: Unable to open database.";
        } else {
            // Prepare the SQL statement to fetch mortgage products based on user input criteria
            $stmt = $db->prepare("SELECT * FROM mortgage_product 
                                WHERE minimum_down_payment <= :down_payment 
                                AND loan_term <= :loan_term 
                                AND maximum_loan_amount <= :maximum_loan_amount");

            // Check if the statement was prepared successfully
            if (!$stmt) {
                echo "Error: Unable to prepare statement.";
            } else {
                // Bind parameters
                $stmt->bindParam(':down_payment', $down_payment);
                $stmt->bindParam(':loan_term', $loan_term);
                $stmt->bindParam(':maximum_loan_amount', $maximum_loan_amount);

                // Execute the statement
                $result = $stmt->execute();

                // Check if there are matching mortgage products
                if ($result->numColumns() > 0) {
                    // Display mortgage products within the specified range
                    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                        echo '<div class="mortgage-product">';
                        echo '<div class="product-details">Product Name: ' . $row["product_name"] . '</div>';
                        echo '<div class="product-details">Interest Rate: ' . $row["interest_rate"] . '%</div>';
                        echo '<div class="product-details">Loan Term: ' . $row["loan_term"] . ' years</div>';
                        echo '<div class="product-details">Maximum Loan Amount: $' . $row["maximum_loan_amount"] . '</div>';
                        echo '<div class="product-details">Minimum Down Payment: $' . $row["minimum_down_payment"] . '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "No mortgage products found within the specified range.";
                }

                // Close the statement and the database connection
                $stmt->close();
                $db->close();
            }
        }
    }
    ?>
</body>
</html>