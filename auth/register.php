<?php 
require('./../shared/bundler.php');
require './../shared/config.php';

class User {
    public function registerUser($username, $email, $password, $phone_number) {
        $conn = new mysqli("localhost", "root", "", "yellow");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($userId);
        $stmt->fetch();
        $stmt->close();

        if ($userId) {
            echo "<div id='alert'>Email already registered. Please use a different email.</div>";
        } else {
            // Insert new user
            $stmt = $conn->prepare("INSERT INTO users (username, email, password, phone_number) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $email, $password, $phone_number);
            if ($stmt->execute()) {
                echo "<div id='success'>Registration successful! Please <a href='login.php'>login</a>.</div>";
            } else {
                echo "<div id='alert'>Registration failed. Please try again.</div>";
            }
            $stmt->close();
        }

        $conn->close();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $phone_number = $_POST["phone_number"];
    $user = new User();
    $user->registerUser($username, $email, $password, $phone_number);
}
?>

<div class="form-box">
<form class="form" method="POST" action="register.php">
    <span class="title">Sign Up</span>
    <span class="subtitle">Create a free account with your email.</span>
    <div class="form-container">
        <input type="text" class="input" name="username" placeholder="Full Name" required>
        <input type="email" class="input" name="email" placeholder="Email Address" required>
        <input type="password" class="input" name="password" placeholder="Password" required>
        <input type="text" class="input" name="phone_number" placeholder="Phone Number" required>
    </div>
    <button type="submit">Register</button>
</form>
<div class="form-section">
  <p>Already have an account? <a href="login.php">Sign In</a></p>
</div>
</div>
