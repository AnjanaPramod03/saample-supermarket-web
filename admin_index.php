
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
    
    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
}

.sidebar {
    width: 250px;
    background-color: #333;
    color: #fff;
    position: fixed;
    height: 100%;
    padding-top: 20px;
}

.sidebar h2 {
    text-align: center;
    margin-bottom: 20px;
}

.sidebar ul {
    list-style: none;
    padding: 0;
}

.sidebar ul li {
    padding: 15px 20px;
}

.sidebar ul li a {
    color: #fff;
    text-decoration: none;
    display: block;
}

.sidebar ul li a:hover {
    background-color: #575757;
}

.content {
    margin-left: 250px;
    padding: 20px;
    width: calc(100% - 250px);
    background-color: #f4f4f4;
}

.login-container {
    width: 300px;
    margin: 100px auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    border-radius: 8px;
}

.login-container h1 {
    text-align: center;
    margin-bottom: 20px;
}

.login-container input {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.login-container button {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.login-container button:hover {
    background-color: #45a049;
}

.error {
    color: red;
    text-align: center;
}


    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <ul>
            <li><a href="admin_index.php">Home</a></li>
            <li><a href="user_details.php">Users</a></li>
            <li><a href="product_management.php">Products</a></li>
            <li><a href="category_management.php">categories</a></li>
            <li><a href="order_details.php">Orders</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</body>
</html>
