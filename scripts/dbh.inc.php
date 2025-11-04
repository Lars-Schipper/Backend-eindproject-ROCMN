<?php

$dbname = "trade_index";
$dbuser = "bit_academy";
$dbpass = "bit_academy";
$dbhost = "localhost";

try {
    $pdo = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpass);
} catch (PDOException $err) {
    echo "Database connection problem: " . $err->getMessage();
    exit();
}