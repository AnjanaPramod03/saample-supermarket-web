<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $category_id = $_POST['category_id'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $imageUrl = '';
    if ($_FILES['image_upload']['error'] === UPLOAD_ERR_OK) {
        $tmpFilePath = $_FILES['image_upload']['tmp_name'];
        $fileName = $_FILES['image_upload']['name'];
        move_uploaded_file($tmpFilePath, "uploads/" . $fileName);
        $imageUrl = "uploads/" . $fileName;
    }

    $action = $_POST['action'];

    try {
        if ($action == 'create') {
            $stmt = $conn->prepare("INSERT INTO products (category_id, product_name, description, price, stock, image_url) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issdis", $category_id, $product_name, $description, $price, $stock, $imageUrl);
            $stmt->execute();
            $stmt->close();
        } elseif ($action == 'update') {
            $stmt = $conn->prepare("UPDATE products SET category_id=?, product_name=?, description=?, price=?, stock=?, image_url=? WHERE product_id=?");
            $stmt->bind_param("issdisi", $category_id, $product_name, $description, $price, $stock, $imageUrl, $product_id);
            $stmt->execute();
            $stmt->close();
        } elseif ($action == 'delete') {
            $checkStmt = $conn->prepare("SELECT COUNT(*) FROM order_items WHERE product_id = ?");
            $checkStmt->bind_param("i", $product_id);
            $checkStmt->execute();
            $checkStmt->bind_result($count);
            $checkStmt->fetch();
            $checkStmt->close();

            if ($count > 0) {
                echo "Cannot delete product. There are related order items.";
            } else {
                $stmt = $conn->prepare("DELETE FROM products WHERE product_id=?");
                $stmt->bind_param("i", $product_id);
                $stmt->execute();
                $stmt->close();
            }
        }
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Product Management</h1>
        <form id="productForm" method="post" action="product_management.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="productName">Product Name</label>
                <input type="text" class="form-control" id="productName" name="product_name" required>
            </div>
            <div class="form-group">
                <label for="categoryId">Category ID</label>
                <input type="number" class="form-control" id="categoryId" name="category_id" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" class="form-control" id="price" name="price" required>
            </div>
            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" required>
            </div>
            <div class="form-group">
                <label for="imageUpload">Choose Image</label>
                <input type="file" class="form-control-file" id="imageUpload" name="image_upload">
                <small id="imageHelp" class="form-text text-muted">Select an image file from your computer.</small>
            </div>
            <input type="hidden" name="product_id" id="productId">
            <button type="submit" name="action" value="create" class="btn btn-primary">Add Product</button>
            <button type="submit" name="action" value="update" class="btn btn-warning">Update Product</button>
            <button type="submit" name="action" value="delete" class="btn btn-danger">Delete Product</button>
        </form>

        <h2 class="mt-5">Product List</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category ID</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Image URL</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="productTable">
                <?php
                $result = $conn->query("SELECT * FROM products");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['product_id'] . "</td>";
                    echo "<td>" . $row['product_name'] . "</td>";
                    echo "<td>" . $row['category_id'] . "</td>";
                    echo "<td>" . $row['description'] . "</td>";
                    echo "<td>" . $row['price'] . "</td>";
                    echo "<td>" . $row['stock'] . "</td>";
                    echo "<td>" . $row['image_url'] . "</td>";
                    echo '<td><button class="btn btn-info" onclick="editProduct(' . $row['product_id'] . ', \'' . addslashes($row['product_name']) . '\', ' . $row['category_id'] . ', \'' . addslashes($row['description']) . '\', ' . $row['price'] . ', ' . $row['stock'] . ', \'' . addslashes($row['image_url']) . '\')">Edit</button></td>';
                    echo "</tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script>
        function editProduct(id, name, category, description, price, stock, image) {
            document.getElementById('productId').value = id;
            document.getElementById('productName').value = name;
            document.getElementById('categoryId').value = category;
            document.getElementById('description').value = description;
            document.getElementById('price').value = price;
            document.getElementById('stock').value = stock;
            document.getElementById('imageUrl').value = image;
        }
    </script>
</body>
</html>
