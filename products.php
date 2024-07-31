<?php


include 'connection.php';
include 'header.php';


$categories_sql = "SELECT * FROM categories";
$categories_result = $conn->query($categories_sql);

$categories = [];
while ($row = $categories_result->fetch_assoc()) {
    $categories[] = $row;
}


$selected_category = isset($_GET['category']) ? $_GET['category'] : '';
$products = [];

if ($selected_category) {
    $products_sql = "SELECT * FROM products WHERE category_id = ?";
    $stmt = $conn->prepare($products_sql);
    $stmt->bind_param("i", $selected_category);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
} else {
    $products_sql = "SELECT * FROM products";
    $products_result = $conn->query($products_sql);

    while ($row = $products_result->fetch_assoc()) {
        $products[] = $row;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    
    
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    $_SESSION['cart'][$product_id] = $quantity;
    
   
    header("Location: {$_SERVER['REQUEST_URI']}");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Products</h1>
    <div class="filter">
        <form action="products.php" method="get">
            <label for="category">Select Category:</label>
            <select name="category" id="category" onchange="this.form.submit()">
                <option value="">All Categories</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['category_id']; ?>" <?php if ($category['category_id'] == $selected_category) echo 'selected'; ?>>
                        <?php echo $category['category_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>
    <div class="products">
        <?php foreach ($products as $product): ?>
            <div class="product">
                <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['product_name']; ?>">
                <h3><?php echo $product['product_name']; ?></h3>
                <p><?php echo $product['description']; ?></p>
                <p>Price: $<?php echo $product['price']; ?></p>
                <p>Stock: <?php echo $product['stock']; ?></p>
                <form action="products.php" method="post">
                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                    <label for="quantity_<?php echo $product['product_id']; ?>">Quantity:</label>
                    <input type="number" name="quantity" id="quantity_<?php echo $product['product_id']; ?>" value="1" min="1" max="<?php echo $product['stock']; ?>">
                    <button type="submit">Add to Cart</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
