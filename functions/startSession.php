<?php
session_start();
require_once __DIR__ . "/arrays.php";
require_once __DIR__ . "/functions.php";
try {
    // Create a new PDO, instance database-connection is here.
    $db = new PDO('sqlite:../players.sqlite');
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
