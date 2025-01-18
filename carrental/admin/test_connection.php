<?php
include('config.php');

try {
    $dbh->query("SELECT 1"); // Test query
    echo "Database connection successful.";
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
}
?>
