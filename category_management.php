<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_id = $_POST['category_id'];
    $category_name = $_POST['category_name'];
    $description = $_POST['description'];
    $action = $_POST['action'];

    try {
        if ($action == 'create') {
            $stmt = $conn->prepare("INSERT INTO categories (category_name, description) VALUES (?, ?)");
            $stmt->bind_param("ss", $category_name, $description);
            $stmt->execute();
            $stmt->close();
        } elseif ($action == 'update') {
            $stmt = $conn->prepare("UPDATE categories SET category_name=?, description=? WHERE category_id=?");
            $stmt->bind_param("ssi", $category_name, $description, $category_id);
            $stmt->execute();
            $stmt->close();
        } elseif ($action == 'delete') {
            $checkStmt = $conn->prepare("SELECT COUNT(*) FROM products WHERE category_id = ?");
            $checkStmt->bind_param("i", $category_id);
            $checkStmt->execute();
            $checkStmt->bind_result($count);
            $checkStmt->fetch();
            $checkStmt->close();

            if ($count > 0) {
                echo "Cannot delete category. There are related products.";
            } else {
                $stmt = $conn->prepare("DELETE FROM categories WHERE category_id = ?");
                $stmt->bind_param("i", $category_id);
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
    <title>Category Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Category Management</h1>
        <form id="categoryForm" method="post" action="category_management.php">
            <div class="form-group">
                <label for="categoryName">Category Name</label>
                <input type="text" class="form-control" id="categoryName" name="category_name" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <input type="hidden" name="category_id" id="categoryId">
            <button type="submit" name="action" value="create" class="btn btn-primary">Add Category</button>
            <button type="submit" name="action" value="update" class="btn btn-warning">Update Category</button>
            <button type="submit" name="action" value="delete" class="btn btn-danger">Delete Category</button>
        </form>

        <h2 class="mt-5">Category List</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="categoryTable">
                <?php
                $result = $conn->query("SELECT * FROM categories");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['category_id'] . "</td>";
                    echo "<td>" . $row['category_name'] . "</td>";
                    echo "<td>" . $row['description'] . "</td>";
                    echo '<td><button class="btn btn-info" onclick="editCategory(' . $row['category_id'] . ', \'' . addslashes($row['category_name']) . '\', \'' . addslashes($row['description']) . '\')">Edit</button></td>';
                    echo "</tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script>
        function editCategory(id, name, description) {
            document.getElementById('categoryId').value = id;
            document.getElementById('categoryName').value = name;
            document.getElementById('description').value = description;
        }
    </script>
</body>
</html>
