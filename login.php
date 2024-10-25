<?php
// Database connection
$servername = "localhost";
$username = "sign";
$password = "kj";
$dbname = "signdb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    // Query to check if user exists in the database
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        session_start(); // Start the session
        $_SESSION['username'] = $username; // Store the username in a session variable

        // Insert login data into the database
        $login_time = date('Y-m-d H:i:s');
        $insert_sql = "INSERT INTO login_history (username, login_time) VALUES ('$username', '$login_time')";
        $conn->query($insert_sql);

        echo "Login successful!";
        // Redirect to dashboard.php after 2 seconds
        echo '<script>setTimeout(function(){ window.location.href = "index.html"; }, 2000);</script>';
    } else {
        echo "Invalid username or password. Please try again.";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Form</title>
<link rel="stylesheet" href="loginStyle.css">
</head>
<body style="background-image: url('https://tse1.mm.bing.net/th?id=OIP.9j0kj9e2UhR1jB6q-9MviAHaEt&pid=Api&P=0&h=220'); background-size: cover;">

<div class="container">
    <div class="signin">
        <div class="content">
            <h2>Sign In</h2>
            <div class="form">
                <form method="post" action="login.php">
                    <div class="inputBox">
                        <input type="text" name="username" id="username" required>
                        <i>Username</i>
                    </div>
                    <div class="inputBox">
                        <input type="password" name="password" id="password" required>
                        <i>Password</i>
                    </div>
                    <div class="links">
                        <a href="./signup.php">Sign Up</a>
                        <a href="./admin.html">Admin Login</a>
                    </div>
                    <div class="inputBox">
                        <input type="submit" value="Login">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
