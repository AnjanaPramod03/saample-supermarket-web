<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .message {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="message">
        <h1>Thank You!</h1>
        <p>Your order has been placed successfully.</p>
        <p>You will be redirected to the homepage shortly.</p>
    </div>
    <?php
    
    header("refresh:3;url=index.php");
    ?>
</body>
</html>
