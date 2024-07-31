<?php


include 'connection.php';
include 'header.php';


function calculateTotalPrice($conn) {
    $total = 0;
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $product_sql = "SELECT price FROM products WHERE product_id = ?";
        $stmt = $conn->prepare($product_sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $total += $product['price'] * $quantity;
    }
    return $total;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    
  
    $insert_customer_sql = "INSERT INTO customers (username, name, email, phone) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_customer_sql);
    $stmt->bind_param("ssss", $name, $name, $email, $phone);
    $stmt->execute();
    $customer_id = $stmt->insert_id;

  
    $total_price = calculateTotalPrice($conn);
    $insert_order_sql = "INSERT INTO orders (customer_id, total) VALUES (?, ?)";
    $stmt = $conn->prepare($insert_order_sql);
    $stmt->bind_param("id", $customer_id, $total_price);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $product_sql = "SELECT price FROM products WHERE product_id = ?";
        $stmt = $conn->prepare($product_sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $price = $product['price'];

        $insert_order_item_sql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_order_item_sql);
        $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price);
        $stmt->execute();
    }

 
    unset($_SESSION['cart']);

  
    header("Location: thank_you.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
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
        }
        h1, h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"], input[type="email"], input[type="tel"] {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        ul li {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Checkout</h1>
        <?php if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0): ?>
            <p>Your cart is empty. Please add some items to your cart before proceeding to checkout.</p>
        <?php else: ?>
            <form action="checkout.php" method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" required>
                <input type="submit" value="Place Order">
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
