<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=ijdb; charset=utf8", "root", "jerusalem1991");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error trying to connect to the database ' . $e->getMessage();
}
// $output = "Connected successfully";
