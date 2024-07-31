<?php
include 'connection.php'; 

session_start(); 


if(isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $reg_username = $_POST['reg_username'];
    $reg_password = $_POST['reg_password'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    
    $sql = "INSERT INTO customers (username, password, name, email, phone, address) VALUES ('$reg_username', '$reg_password', '$name', '$email', '$phone', '$address')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registration successful!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $login_username = $_POST['login_username'];
    $login_password = $_POST['login_password'];


    $sql = "SELECT * FROM customers WHERE username='$login_username' AND password='$login_password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
       
        $_SESSION['username'] = $login_username;
        header("Location: index.php");
        exit;
    } else {
        echo "<script>alert('Invalid username or password');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register and Login</title> 
    <style>
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.3)), url('img/bg.jpg');
    backdrop-filter: blur(5px); 
    background-size: cover;
    background-position: center;
    height: 100vh;
    overflow: hidden;
}

.container {
    max-width: 600px;
    margin: 50px auto;
    background-color: rgba(255, 255, 255, 0.705);
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    animation: fadeIn 1s ease;
}

.tabs {
    margin-bottom: 20px;
    display: flex;
    justify-content: center;
}

.tab-btn {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 8px 8px 0 0;
    margin-right: 10px;
    transition: background-color 0.3s ease;
}

.tab-btn:last-child {
    margin-right: 0;
}

.tab-btn.active {
    background-color: #0056b3;
}

.tab-content {
    display: none;
    animation: slideIn 1s ease;
}

.tab-content.active {
    display: block;
}

.tab-content h1 {
    margin-top: 0;
}

input[type="text"],
input[type="password"],
input[type="email"],
textarea {
    width: calc(100% - 20px);
    padding: 10px;
    margin: 8px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    transition: border-color 0.3s ease;
}

input[type="text"]:focus,
input[type="password"]:focus,
input[type="email"]:focus,
textarea:focus {
    border-color: #007bff;
}

button[type="submit"] {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #0056b3;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes slideIn {
    from {
        transform: translateY(-20px);
    }
    to {
        transform: translateY(0);
    }
}

    </style>
    
</head>
<body>
    <div class="container">
        <div class="tabs">
            <button class="tab-btn active" onclick="openTab(event, 'register')">Register</button>
            <button class="tab-btn" onclick="openTab(event, 'login')">Login</button>
        </div>

        <div id="register" class="tab-content">
            <h1>Register</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="reg_username">Username:</label>
                <input type="text" id="reg_username" name="reg_username" required>
                <label for="reg_password">Password:</label>
                <input type="password" id="reg_password" name="reg_password" required>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone">
                <label for="address">Address:</label>
                <textarea id="address" name="address"></textarea>
                <button type="submit" name="register">Register</button>
            </form>
        </div>

        <div id="login" class="tab-content" style="display: none;">
            <h1>Login</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="login_username">Username:</label>
                <input type="text" id="login_username" name="login_username" required>
                <label for="login_password">Password:</label>
                <input type="password" id="login_password" name="login_password" required>
                <button type="submit" name="login">Login</button>
            </form>
        </div>
    </div>

    <script>
      
        function openTab(evt, tabName) {
            var i, tabContent, tabBtn;

            tabContent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabContent.length; i++) {
                tabContent[i].style.display = "none";
            }

            tabBtn = document.getElementsByClassName("tab-btn");
            for (i = 0; i < tabBtn.length; i++) {
                tabBtn[i].className = tabBtn[i].className.replace(" active", "");
            }

            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>
</body>
</html>
