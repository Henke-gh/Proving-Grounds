<?php

declare(strict_types=1);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registerNew'])) {
    header(('Location: /../index.php'));
} else {
}

header('Location: /../index.php');
exit();
