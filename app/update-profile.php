<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
}

$errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $user_photo = $_FILES['user_photo'];
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (!empty($email)) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email syntax';
        }
    }

    if (!empty($user_photo)) {
        $allowed_types = array('jpg', 'jpeg', 'png');
        $file_type = strtolower(pathinfo($user_photo['name'], PATHINFO_EXTENSION));
        if (!in_array($file_type, $allowed_types)) {
            $errors['user_photo'] = 'Allowed file types: jpg, jpeg, png';
        } elseif ($user_photo['size'] > 2097152) {
            $errors['user_photo'] = 'File size should be less than 2 MB';
        }
    }

    if (!empty($password)) {
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,16}$/', $password)) {
            $errors['password'] = 'Password must have minimum 8 characters, maximum 16 characters, and must use 1 uppercase and 1 number. ';
        }

        if ($password != $confirm_password) {
            $errors['confirm_password'] = 'Confirm Password does not match with Password';
        }
    }

    if (empty($errors)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $update_date = date('Y-m-d H:i:s');

        $sql = "UPDATE users SET email = ?, user_photo = ?, first_name = ?, last_name = ?, password = ?, update_date = ? WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssss', $email, $user_photo['name'], $first_name, $last_name, $password_hash, $update_date, $_SESSION['username']);

        if ($stmt->execute()) {
            if (!empty($user_photo)) {
                move_uploaded_file($user_photo['tmp_name'], 'uploads/' . $user_photo['name']);
            }
            header('Location: dashboard.php');
        } else {
            $errors['db'] = 'Error in updating data into database';
        }
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
    <title>Update Profile</title>
    <link rel="stylesheet" href="./css/update.css">
</head>

<body>
    <h1>Update Profile</h1>
    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td><label for="email">Email:</label></td>
                    <td><input type="email" name="email" id="email" value="<?php echo isset($email) ? htmlspecialchars($email) : htmlspecialchars($user['email']); ?>"></td>
                </tr>
                <tr>
                    <td><label for="user_photo">User Photo:</label></td>
                    <td><input type="file" name="user_photo" id="user_photo">
                        <p>Allowed file types: jpg, jpeg, png. File size should be less than 2 MB.</p>
                    </td>
                </tr>
                <tr>
                    <td><label for="first_name">First Name:</label></td>
                    <td><input type="text" name="first_name" id="first_name" value="<?php echo isset($first_name) ? htmlspecialchars($first_name) : htmlspecialchars($user['first_name']); ?>"></td>
                </tr>
                <tr>
                    <td><label for="last_name">Last Name:</label></td>
                    <td><input type="text" name="last_name" id="last_name" value="<?php echo isset($last_name) ? htmlspecialchars($last_name) : htmlspecialchars($user['last_name']); ?>"></td>
                </tr>
                <tr>
                    <td> <label for="password">Password:</label></td>
                    <td> <input type="password" name="password" id="password"></td>
                </tr>
                <tr>
                    <td> <label for="confirm_password">Confirm Password:</label></td>
                    <td> <input type="password" name="confirm_password" id="confirm_password"></td>
                </tr>
                <tr>
                    <td><button type="submit">Update</button></td>
                    <td> <button><a href="dashboard.php">Cancel</a></button> </td>
                    <td><button><a href="delete-profile.php" onclick="return confirmDelete()">Delete </a></button></td>
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
    <script>
        function confirmDelete() {
            return confirm('Are you sure, You want to delete the profile?');
        }
    </script>

</body>

</html>