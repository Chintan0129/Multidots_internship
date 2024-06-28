<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
}
if (isset($_POST['logout'])) {
    session_regenerate_id();
    $_SESSION = array();
    session_destroy();
    header('Location: login.php');
    exit;
}


$sql = "SELECT * FROM users ORDER BY registration_date DESC LIMIT 5";
$result = $conn->query($sql);
$latest_users = $result->fetch_all(MYSQLI_ASSOC);

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
    <title>Dashboard</title>
    <link rel="stylesheet" href="./css/dashboard.css">
</head>

<body>
    

    <h1>Welcome, <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>!</h1>
    <div class="main">
       <img src="uploads/<?php echo htmlspecialchars($user['user_photo']); ?>" alt="User Photo" >
       
          <ul>
            <?php echo " <h1>Latest Users: </h1>" ?>
            <?php foreach ($latest_users as $latest_user) : ?>
                <li><?php echo htmlspecialchars($latest_user['first_name'] . ' ' . $latest_user['last_name']); ?></li>
            <?php endforeach; ?>
            
            </ul>
      
    </div>
    <form action="" method="post">
           <input type="submit" name="logout" value="Logout">
        </form>
        <button><a href="update-profile.php">Update </a></button>

</body>

</html>