<?php
$host = 'localhost';
$db = 'student_info';
$user = 'root'; // Use the appropriate user
$pass = 'webinfotia123'; // Replace with your actual password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
