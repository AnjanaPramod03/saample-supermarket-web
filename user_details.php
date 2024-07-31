<?php
 include 'connection.php';

function getUserDetails($conn, $user_id) {
    $stmt = $conn->prepare("SELECT * FROM customers WHERE customer_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->fetch_assoc();
}

function getAllUsers($conn) {
    $sql = "SELECT * FROM customers";
    return $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">User Details</h1>
        <h2 class="mt-5">Users</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="userTable">
                <?php
                $users = getAllUsers($conn);
                while ($row = $users->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['customer_id'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo '<td><button class="btn btn-info" onclick="viewUserDetails(' . $row['customer_id'] . ')">View Details</button></td>';
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <h2 class="mt-5" id="userDetailsTitle" style="display:none;">User Information</h2>
        <table class="table table-bordered" id="userDetailsTable" style="display:none;">
            <tbody id="userDetails">
               
            </tbody>
        </table>
    </div>

    <script>
        function viewUserDetails(userId) {
            fetch('user_details.php?user_id=' + userId)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('userDetailsTitle').style.display = 'block';
                    document.getElementById('userDetailsTable').style.display = 'block';
                    document.getElementById('userDetails').innerHTML = data;
                });
        }
    </script>
</body>
</html>

<?php
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $userDetails = getUserDetails($conn, $user_id);
    if ($userDetails) {
        echo "<tr><th>User ID</th><td>" . $userDetails['customer_id'] . "</td></tr>";
        echo "<tr><th>Username</th><td>" . $userDetails['username'] . "</td></tr>";
        echo "<tr><th>Name</th><td>" . $userDetails['name'] . "</td></tr>";
        echo "<tr><th>Email</th><td>" . $userDetails['email'] . "</td></tr>";
        echo "<tr><th>Phone</th><td>" . $userDetails['phone'] . "</td></tr>";
        echo "<tr><th>Address</th><td>" . $userDetails['address'] . "</td></tr>";
    } else {
        echo "<tr><td colspan='2'>User not found.</td></tr>";
    }
    $conn->close();
    exit();
}
?>
