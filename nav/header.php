<?php
session_start();
require_once __DIR__ . "/../arrays.php";
require_once __DIR__ . "/../functions.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proving Grounds 2.0</title>
    <link rel="stylesheet" href="/styles/style.css">
    <link rel="icon" type="image/x-icon" href="/assets/images/favIcon.png" />
</head>

<header>
    <h1>The Proving Grounds</h1>
    <h2>Conquer you foes!</h2>
    <nav>
        <a href="index.php">Start</a>
        <a href="about.php">About Game</a>
        <a href="#">Log in</a>
        <a href="#">Register</a>
    </nav>
</header>

<body>