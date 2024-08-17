<?php
// config.php
define('YOUTUBE_API_KEY', 'AIzaSyBzHgnoI9OoCNTC10Qrm6mSN8u_iOu_TmY');

$host = 'localhost';
$dbname = 'yellow';
$user = 'root'; // Database username
$pass = ''; // Database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

