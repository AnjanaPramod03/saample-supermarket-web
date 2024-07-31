<?php

include 'connection.php';
include 'header.php';


function calculateTotalPrice($conn) {
    $total = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $product_sql = "SELECT price FROM products WHERE product_id = ?";
            $stmt = $conn->prepare($product_sql);
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $product = $result->fetch_assoc();
            $total += $product['price'] * $quantity;
        }
    }
    return $total;
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $product_id => $quantity) {
        if ($quantity == 0) {
            unset($_SESSION['cart'][$product_id]);
        } else {
            $_SESSION['cart'][$product_id] = $quantity;
        }
    }
    
    header("Location: cart.php");
    exit();
}


if (isset($_GET['remove'])) {
    $product_id = $_GET['remove'];
    unset($_SESSION['cart'][$product_id]);
    
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Cart</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f3f3f3;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            animation: fadeIn 0.5s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            color: #555;
        }
        th {
            background-color: #f5f5f5;
            text-transform: uppercase;
            font-size: 14px;
        }
        td {
            background-color: #fff;
        }
        input[type="number"] {
            width: 50px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: border-color 0.3s;
        }
        input[type="number"]:focus {
            border-color: #4CAF50;
        }
        button {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #45a049;
        }
        .total {
            text-align: right;
            margin-top: 20px;
            font-size: 18px;
            color: #333;
        }
        .total span {
            font-weight: bold;
            color: #4CAF50;
        }
        .action {
            text-align: right;
        }
        .action a {
            color: #ff4444;
            text-decoration: none;
            margin-left: 10px;
            font-size: 16px;
            transition: color 0.3s;
        }
        .action a:hover {
            color: #ff3333;
            text-decoration: underline;
        }
        @media (max-width: 768px) {
            table {
                font-size: 14px;
            }
            input[type="number"] {
                width: 40px;
            }
            button {
                padding: 8px 16px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Shopping Cart</h1>
        <form method="post" action="cart.php">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $product_id => $quantity) {
                            $product_sql = "SELECT * FROM products WHERE product_id = ?";
                            $stmt = $conn->prepare($product_sql);
                            $stmt->bind_param("i", $product_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $product = $result->fetch_assoc();
                            $total = $product['price'] * $quantity;
                            
                            echo "<tr>";
                            echo "<td>{$product['product_name']}</td>";
                            echo "<td>$ {$product['price']}</td>";
                            echo "<td><input type='number' name='quantity[{$product_id}]' value='{$quantity}' min='1' max='{$product['stock']}'></td>";
                            echo "<td>$ {$total}</td>";
                            echo "<td><a href='cart.php?remove={$product_id}' class='btn'>Remove</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Your cart is empty</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <button type="submit" name="update_cart">Update Cart</button>
        </form>
        <div class="total">
            Total Price: <span>$<?php echo calculateTotalPrice($conn); ?></span>
        </div>
        <div class="action">
            <a href="checkout.php">Proceed to Checkout</a>
        </div>
    </div>
</body>
</html>
