<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .broker-login-box {
            margin-top: 20px;
        }
        .broker-login-box h2 {
            margin-bottom: 10px;
        }
        .broker-login-box p {
            margin-bottom: 20px;
        }
        .broker-login-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .broker-login-button:hover {
            background-color: #0056b3;
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
            </ul>
        </nav>
    </header>

    <div class="left-background"></div> 
    <div class="right-background"></div> 
    
    <div class="container">
        <h1>Login</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" id="email" name="email" placeholder="Email">
            <br><br>
            <input type="password" id="password" name="password" placeholder="Password">
            <br><br>
            <input type="submit" value="Confirm">
        </form>

        <!-- Broker Login Box -->
        <div class="broker-login-box">
            <h2>Broker Login</h2>
            <p>If you are a broker, please login below:</p>
            <a class="broker-login-button" href="broker-login.php">Broker Login</a>
        </div>
    </div>
</body>
</html>
