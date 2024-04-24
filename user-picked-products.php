<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Mortgage Products</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        
        .product-box {
            max-width: 300px;
            margin: 0 auto;
            float: left;
            margin-right: 20px;
        }
        
        .best-product-box {
            max-width: 300px;
            margin: 20px auto;
            clear: both;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Sign Out</a></li>
            </ul>
        </nav>
    </header>

    <div class="left-background"></div>
    <div class="right-background"></div>

    <div class="container">
        <h1>Your Mortgage Products</h1>
        <div class="product-grid">
            <?php
           
            if (isset($_GET['products'])) {
                
                $selected_products = explode(',', $_GET['products']);

                $db = new PDO('sqlite:C:/xampp/htdocs/latest 18/Stage-3/Isaac Database.db');
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

              
                $sql = "SELECT * FROM mortgage_product WHERE mortgage_product_id IN (" . implode(',', $selected_products) . ")";
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $selected_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

               
                $best_product = null;
                $best_interest_rate = PHP_INT_MAX;
                $longest_loan_time = 0;
                $max_loan_amount = 0;
                $lowest_down_payment = PHP_INT_MAX;

                
                foreach ($selected_rows as $row) {
                   
                    if ($row['interest_rate'] < $best_interest_rate || 
                        ($row['interest_rate'] == $best_interest_rate && $row['loan_term'] > $longest_loan_time) ||
                        ($row['interest_rate'] == $best_interest_rate && $row['loan_term'] == $longest_loan_time && $row['maximum_loan_amount'] > $max_loan_amount) ||
                        ($row['interest_rate'] == $best_interest_rate && $row['loan_term'] == $longest_loan_time && $row['maximum_loan_amount'] == $max_loan_amount && $row['minimum_down_payment'] < $lowest_down_payment)) {
                        $best_product = $row;
                        $best_interest_rate = $row['interest_rate'];
                        $longest_loan_time = $row['loan_term'];
                        $max_loan_amount = $row['maximum_loan_amount'];
                        $lowest_down_payment = $row['minimum_down_payment'];
                    }

                    
                    echo '<div class="product-box">';
                    echo '<h2>' . $row['product_name'] . '</h2>';
                    echo '<p>Interest Rate: ' . $row['interest_rate'] . '%</p>';
                    echo '<p>Loan Term: ' . $row['loan_term'] . ' years</p>';
                    echo '<p>Maximum Loan Amount: $' . $row['maximum_loan_amount'] . '</p>';
                    echo '<p>Minimum Down Payment: $' . $row['minimum_down_payment'] . '</p>';
                    echo '<p>Mortgage Type: ' . $row['mortgage_type'] . '</p>';
                    echo '</div>';
                }

                
                if ($best_product) {
                    echo '<div class="best-product-box">';
                    echo '<h2>Best Mortgage Product</h2>';
                    echo '<h3>' . $best_product['product_name'] . '</h3>';
                    echo '<p>Interest Rate: ' . $best_product['interest_rate'] . '%</p>';
                    echo '<p>Loan Term: ' . $best_product['loan_term'] . ' years</p>';
                    echo '<p>Maximum Loan Amount: $' . $best_product['maximum_loan_amount'] . '</p>';
                    echo '<p>Minimum Down Payment: $' . $best_product['minimum_down_payment'] . '</p>';
                    echo '<p>Mortgage Type: ' . $best_product['mortgage_type'] . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>No products selected.</p>';
            }
            ?>
        </div>
       
        <div class="create-button">
            <a href="mortgage-product-table.php">Choose Mortgage Products</a>
        </div>
    </div>
</body>
</html>