<?php 
require('./../shared/bundler.php');
require './../shared/config.php';

class User {
    public function loginUser($email, $password) {
        $conn = new mysqli("localhost", "root", "", "yellow");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND password = ? LIMIT 1");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $stmt->bind_result($userId);
        $stmt->fetch();

        if ($userId) {
            session_start();
            $_SESSION['user_id'] = $userId;
            $_SESSION['email'] = $email;
            echo "<div id='success'>Logging In...</div>";
        } else {
            echo "<div id='alert'>Invalid Email or Password, Please try again!</div>";
        }

        $stmt->close();
        $conn->close();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $sess = new User();
    $sess->loginUser($email, $password);
}
?>

<div class="form-box">
<form class="form" method="POST" action="login.php">
    <span class="title">Sign In</span>
    <span class="subtitle">Sign in with your email and password.</span>
    <div class="form-container">
        <input type="email" class="input" name="email" placeholder="Email Address" required>
        <input type="password" class="input" name="password" placeholder="Password" required>
    </div>
    <button type="submit">Login</button>
</form>
<div class="form-section">
  <p>Don't have an account? <a href="register.php">Sign Up</a></p>
</div>
</div>
