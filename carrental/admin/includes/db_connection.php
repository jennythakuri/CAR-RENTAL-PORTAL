<?php
// db_connection.php
$host = 'localhost'; // Your database host
$db = 'carrental';   // Your database name
$user = 'root';      // Your database username
$pass = '';          // Your database password

try {
    $dbh = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit; // Exit if connection fails
}
?>
