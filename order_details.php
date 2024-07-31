<?php
include 'connection.php';

function getOrderDetails($conn, $order_id) {
    $stmt = $conn->prepare("SELECT p.product_name, oi.quantity, p.price 
                            FROM order_items oi
                            JOIN products p ON oi.product_id = p.product_id
                            WHERE oi.order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

function getAllOrders($conn) {
    $sql = "SELECT * FROM orders";
    return $conn->query($sql);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_order_id'])) {
    $order_id = $_POST['delete_order_id'];

   
    $stmt = $conn->prepare("DELETE FROM order_items WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->close();

  
    $stmt = $conn->prepare("DELETE FROM orders WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->close();

    echo "Order deleted successfully";
    header("Location: order_details.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Order Management</h1>
        <h2 class="mt-5">Orders</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer ID</th>
                    <th>Order Date</th>
                    <th>Total Amount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="orderTable">
                <?php
                $orders = getAllOrders($conn);
                while ($row = $orders->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['order_id'] . "</td>";
                    echo "<td>" . $row['customer_id'] . "</td>";
                    echo "<td>" . $row['order_date'] . "</td>";
                    echo "<td>" . $row['total'] . "</td>";
                    echo '<td>
                            <button class="btn btn-info" onclick="viewOrderDetails(' . $row['order_id'] . ')">View Details</button>
                            <form method="POST" action="" style="display:inline-block;">
                                <input type="hidden" name="delete_order_id" value="' . $row['order_id'] . '">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                          </td>';
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <h2 class="mt-5" id="orderDetailsTitle" style="display:none;">Order Items</h2>
        <table class="table table-bordered" id="orderDetailsTable" style="display:none;">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody id="orderDetails">
               
            </tbody>
        </table>
    </div>

    <script>
        function viewOrderDetails(orderId) {
            fetch('order_management.php?order_id=' + orderId)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('orderDetailsTitle').style.display = 'block';
                    document.getElementById('orderDetailsTable').style.display = 'block';
                    document.getElementById('orderDetails').innerHTML = data;
                });
        }
    </script>
</body>
</html>

<?php
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $orderDetails = getOrderDetails($conn, $order_id);
    while ($row = $orderDetails->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['product_name'] . "</td>";
        echo "<td>" . $row['quantity'] . "</td>";
        echo "<td>" . $row['price'] . "</td>";
        echo "</tr>";
    }
    $conn->close();
    exit();
}
?>
