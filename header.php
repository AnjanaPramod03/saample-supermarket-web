<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supermarket Landing Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <style> 

header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 50px;
    background: rgba(255, 255, 255, 0.1);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 10px;
    margin: 20px;
    position: sticky;
    top: 0;
    z-index: 1000;
}

header .logo {
    display: flex;
    align-items: center;
}

header .logo img {
    height: 40px;
    margin-right: 10px;
}

header .logo span {
    font-size: 24px;
    font-weight: 700;
    color: #525552;
}

header nav ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
}

header nav ul li {
    margin-left: 20px;
}

header nav ul li a {
    text-decoration: none;
    color: #0956ca;
    font-size: 16px;
    transition: color 0.3s;
}

header nav ul li a:hover {
    color: #007bff;
}

    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="img/logo.png" alt="Logo">
            <span>Fresh Festive</span>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="about.php">About</a></li>
                <?php
                
                if(isset($_SESSION['username'])) {
                    echo '<li><a href="logout.php">Logout</a></li>';
                } else {
                    echo '<li><a href="login.php">Login</a></li>';
                    echo '<li><a href="login.php">Register</a></li>';
                }
                ?>
                <li><a href="cart.php"><b>Shopping Cart</b></a></li>
            </ul>
        </nav>
    </header>

    