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
    echo "The cheapest mortgage product is: <br>";
    echo "Product Name: " . $cheapestProduct['product_name'] . "<br>";
    echo "Interest Rate: " . $cheapestProduct['interest_rate'] . "<br>";
    echo "Secondary Interest Rate: " . $cheapestProduct['secondary_interest_rate'] . "<br>";
    echo "Loan Term: " . $cheapestProduct['loan_term'] . "<br>";
    echo "Maximum Loan Amount: " . $cheapestProduct['maximum_loan_amount'] . "<br>";
    echo "Minimum Down Payment: " . $cheapestProduct['minimum_down_payment'] . "<br>";
    echo "Credit Score: " . $cheapestProduct['credit_score'] . "<br>";
    echo "Mortgage Type: " . $cheapestProduct['mortgage_type'] . "<br>";
} else {
    echo "No mortgage products found.";
}
?>
 
