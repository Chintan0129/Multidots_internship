<?php
session_start();
require_once 'config.php';

if (isset($_SESSION['username'])) {
    header('Location: dashboard.php');
}

$errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username)) {
        $errors['username'] = 'Username is required';
    }

    if (empty($password)) {
        $errors['password'] = 'Password is required';
    }

    if (empty($errors)) {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $username;
                header('Location: dashboard.php');
            } else {
                $errors['password'] = 'Incorrect password';
            }
        } else {
            $errors['username'] = 'Username not found';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./css/login.css">
</head>

<body>
    <h1>Login</h1>
    <div class="container">
        <form action="" method="post">
            <table>
                <tr>
                    <td><label for="username">Username:</label></td>
                    <td> <input type="text" name="username" id="username" value="<?php echo isset($_COOKIE['username']) ? htmlspecialchars($_COOKIE['username']) : ''; ?>"></td>
                </tr>
                <tr>
                    <td><label for="password">Password:</label></td>
                    <td><input type="password" name="password" id="password"></td>
                </tr>
                <tr>
                    <td colspan="2"> <input type="checkbox" name="remember_me" id="remember_me">
                        <label for="remember_me">Remember me</label>
                    </td>

                </tr>
                <tr>
                    <td colspan="2"><button type="submit">Login</button></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p>Don't have an account? <a href="registration.php">Register here</a></p>
                    </td>
                </tr>
            </table>
            <?php if (!empty($errors)) : ?>
                <ul>
                    <?php echo "Errors:" ?>
                    <?php foreach ($errors as $error) : ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </form>
    </div>
</body>

</html>