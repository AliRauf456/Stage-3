<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['generate_quote'])) {
    $selected_product_id = $_POST['generate_quote'];
    header("Location: mortgage-quote-generator.php?product_id=$selected_product_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mortgage Products</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .table-container {
            text-align: center;
            margin: 20px auto; 
            width: 80%; 
        }
        
        table {  
            border-collapse: collapse;
            width: 100%; 
        }

        th, td {
            border: 1px solid #dddddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .delete-button {
            text-align: center;
            margin-top: 20px;
        }

        .confirm-button {
            text-align: center;
            margin-top: 20px;
        }
    </style>
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
        <h1>Mortgage Products</h1>
    </div>

    <div class="table-container">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <table>
                <thead>
                    <tr>
                        <th>Mortgage Product ID</th>
                        <th>Product Name</th>
                        <th>Interest Rate</th>
                        <th>Secondary Interest Rate</th>
                        <th>Loan Term</th>
                        <th>Maximum Loan Amount</th>
                        <th>Minimum Down Payment</th>
                        <th>Minimum Credit Score Required</th>
                        <th>Mortgage Type</th>
                        <th>Select</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $db = new PDO('sqlite:C:/xampp/htdocs/latest 18/Stage-3/Isaac Database.db');
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $sql = "SELECT mortgage_product_id, product_name, interest_rate, secondary_interest_rate, loan_term, maximum_loan_amount, minimum_down_payment, credit_score, mortgage_type FROM mortgage_product";

                    $stmt = $db->prepare($sql);
                    $stmt->execute();
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($rows as $row) {
                        echo "<tr>";
                        echo "<td>{$row['mortgage_product_id']}</td>";
                        echo "<td>{$row['product_name']}</td>";
                        echo "<td>{$row['interest_rate']}</td>";
                        echo "<td>{$row['secondary_interest_rate']}</td>";
                        echo "<td>{$row['loan_term']}</td>";
                        echo "<td>{$row['maximum_loan_amount']}</td>";
                        echo "<td>{$row['minimum_down_payment']}</td>";
                        echo "<td>{$row['credit_score']}</td>";
                        echo "<td>{$row['mortgage_type']}</td>";
                        echo "<td><input type='checkbox' name='selected_products[]' value='{$row['mortgage_product_id']}'></td>";
                        echo "<td><button type='submit' name='generate_quote' value='{$row['mortgage_product_id']}'>Generate Quote</button></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </form>
    </div>

    <div class="create-button">
        <a href="user-picked-products.php">Mortgage Product Creation</a>
    </div>
</body>
</html>
