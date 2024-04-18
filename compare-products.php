<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recommend Mortgage Product</title>
</head>
<body>
    <h1>Recommend Mortgage Product</h1>

    <?php
    $db = new PDO("sqlite:C:/xampp/htdocs/Stage-3-1/Isaac Database.db");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM mortgage_product LIMIT 3";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $cheapestProduct = null;
    $lowestInterestRate = PHP_FLOAT_MAX; // Initialize with a very high value

    foreach ($rows as $row) {
        $interestRate = floatval($row['interest_rate']);
        if ($interestRate < $lowestInterestRate) {
            $lowestInterestRate = $interestRate;
            $cheapestProduct = $row;
        }
    }

    if ($cheapestProduct) {
        echo "<h2>We recommend the mortgage product with the lowest interest rate:</h2>";
        echo "<ul>";
        echo "<li><strong>Product Name:</strong> " . $cheapestProduct['product_name'] . "</li>";
        echo "<li><strong>Interest Rate:</strong> " . $cheapestProduct['interest_rate'] . "</li>";
        echo "<li><strong>Secondary Interest Rate:</strong> " . $cheapestProduct['secondary_interest_rate'] . "</li>";
        echo "<li><strong>Loan Term:</strong> " . $cheapestProduct['loan_term'] . "</li>";
        echo "<li><strong>Maximum Loan Amount:</strong> " . $cheapestProduct['maximum_loan_amount'] . "</li>";
        echo "<li><strong>Minimum Down Payment:</strong> " . $cheapestProduct['minimum_down_payment'] . "</li>";
        echo "<li><strong>Credit Score:</strong> " . $cheapestProduct['credit_score'] . "</li>";
        echo "<li><strong>Mortgage Type:</strong> " . $cheapestProduct['mortgage_type'] . "</li>";
        echo "</ul>";
    } else {
        echo "<p>No mortgage products found.</p>";
    }
    ?>
</body>
</html>

 
