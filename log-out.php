<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Additional styles here */
        .container {
            text-align: center;
            margin-top: 50px;
        }
        .logout-message {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .button-container {
            margin-top: 20px;
        }
        .button-container button {
            margin-right: 10px;
        }
        .delete-account-button {
            background-color: #ff6347; /* Red color */
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="log-out.php">Log out</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="left-background"></div> 
        <div class="right-background"></div> 
        
        <h1>Logout</h1>
        <div class="logout-message">Are you sure you want to log out?</div>
        <div class="button-container">
            <a href="view_mortgage-product.php"><button>No</button></a>
            <a href="login.php"><button>Yes</button></a>
        </div>
        <!-- Delete Account functionality -->
        <form action="confirm-delete-account.php" method="post" class="button-container">
            <input type="submit" class="delete-account-button" name="delete_account" value="Delete Account">
        </form>
    </div>
</body>
</html>
