<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $customer_id = 1; 

   
    $check_cart_sql = "SELECT * FROM cart WHERE customer_id = ? AND product_id = ?";
    $stmt = $conn->prepare($check_cart_sql);
    $stmt->bind_param("ii", $customer_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      
        $update_cart_sql = "UPDATE cart SET quantity = quantity + ? WHERE customer_id = ? AND product_id = ?";
        $stmt = $conn->prepare($update_cart_sql);
        $stmt->bind_param("iii", $quantity, $customer_id, $product_id);
    } else {
      
        $insert_cart_sql = "INSERT INTO cart (customer_id, product_id, quantity, added_at) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($insert_cart_sql);
        $stmt->bind_param("iii", $customer_id, $product_id, $quantity);
    }

    if ($stmt->execute()) {
        echo "Product added to cart successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
