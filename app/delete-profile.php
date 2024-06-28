<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
}

if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
    $sql = "DELETE FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $_SESSION['username']);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        session_destroy();
        setcookie('username', '', time() - 3600, '/');
        header('Location: registration.php');
    } else {
        $errors['db'] = 'Error in deleting data from database';
    }
}

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Profile</title>
    <link rel="stylesheet" href="./css/delete.css">
</head>
<body>
    <h1>Delete Profile</h1>
    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <p>Are you sure you want to delete your profile? This action cannot be undone.</p>
    <button><a href="delete-profile.php?confirm=yes">Yes, delete my profile</a></button>
    <button><a href="dashboard.php">Cancel</a></button>
</body>
</html>