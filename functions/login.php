<?php

declare(strict_types=1);
require_once __DIR__ . "/startSession.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userLogin'])) {
    //if username or userpassword is unset, send user back to login form.
    if (!isset($_POST['userName'], $_POST['userPassword'])) {
        $_SESSION['loginError'] = "Enter Username and Password.";
        header('Location: /../index.php');
        exit();
        //if set, save login-variables and query database for login credentials.
    } else {
        $username = trim(strtolower(htmlspecialchars($_POST['userName'], ENT_QUOTES)));
        $userPW = trim(htmlspecialchars($_POST['userPassword'], ENT_QUOTES));
        unset($_POST['userPassword']);
        $stmt = $db->prepare(
            "SELECT id, username, password_hash
            FROM users
            WHERE username = :username"
        );
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        //if credentials match, set session-id and send user to myHero.php
        //where if no player Hero is found they get sent to character creation.
        if ($user && password_verify($userPW, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];

            try {
                // Prepare and execute the SELECT statement
                $stmt = $db->prepare('SELECT playerHero_data FROM playerHero WHERE user_id = :userID');
                $stmt->bindParam(':userID', $_SESSION['user_id']);
                $stmt->execute();

                // Fetch the result (assuming one row per user)
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    // Player data exists, set it in the session and redirect to the main page
                    $_SESSION['hero'] = json_decode($result['playerHero_data'], true);
                    header('Location: /../app/myHero.php');
                    exit();
                } else {
                    // Player data does not exist, redirect to character creation
                    header('Location: /../app/createNewHero.php');
                    exit();
                }
            } catch (PDOException $e) {
                // Handle errors
                echo "Error: " . $e->getMessage();
            }
        } else {
            $_SESSION['loginError'] = "Wrong username or password.";
            header('Location: /../index.php');
            exit();
        }
    }
}
