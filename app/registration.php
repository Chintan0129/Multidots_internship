<?php
session_start();
require_once 'config.php';

if (isset($_SESSION['username'])) {
	header('Location: dashboard.php');
}

$errors = array();
$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$first_name = trim($_POST['first_name']);
	$last_name = trim($_POST['last_name']);
	$username = trim($_POST['username']);
	$mobile_number = trim($_POST['mobile_number']);
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);
	$confirm_password = trim($_POST['confirm_password']);
	$user_photo = $_FILES['user_photo'];

	if (empty($first_name)) {
		$errors['first_name'] = 'First Name is required';
	} elseif (strlen($first_name) < 3) {
		$errors['first_name'] = 'First Name should have minimum 3 characters';
	} elseif (!preg_match('/^[a-zA-Z]+$/', $first_name)) {
		$errors['first_name'] = 'Only letters are allowed in First Name';
	}

	if (empty($last_name)) {
		$errors['last_name'] = 'Last Name is required';
	} elseif (strlen($last_name) < 2) {
		$errors['last_name'] = 'Last Name should have minimum 2 characters';
	} elseif (!preg_match('/^[a-zA-Z]+$/', $last_name)) {
		$errors['last_name'] = 'Only letters are allowed in Last Name';
	}

	if (empty($username)) {
		$errors['username'] = 'Username is required';
	} elseif (strlen($username) > 25) {
		$errors['username'] = 'Username should not be more than 25 characters';
	} else {
		$sql = "SELECT * FROM users WHERE username = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
			$errors['username'] = 'Username is already taken';
		}
	}

	if (!empty($mobile_number) && (!preg_match('/^[0-9]{10}$/', $mobile_number))) {
		$errors['mobile_number'] = 'Mobile Number should have minimum and maximum 10 numbers';
	}

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors['email'] = 'Invalid email syntax';
	} else {
		$sql = "SELECT * FROM users WHERE email = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
			$errors['email'] = 'Email is already taken';
		}
	}

	if (empty($password)) {
		$errors['password'] = 'Password is required';
	} elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,16}$/', $password)) {
		$errors['password'] = 'Password must have minimum 8 characters, maximum 16 characters, at least one uppercase,one number.';
	}
	if ($password != $confirm_password) {
		$errors['confirm_password'] = 'Confirm Password does not match with Password';
	}

	if (empty($errors)) {
		$password_hash = password_hash($password, PASSWORD_DEFAULT);
		$registration_date = date('Y-m-d H:i:s');

		$sql = "INSERT INTO users (first_name, last_name, username, mobile_number, email, password, user_photo, registration_date) VALUES (?, ?, ?, ?,?, ?, ?, ?)";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('ssssssss', $first_name, $last_name, $username, $mobile_number, $email, $password_hash, $user_photo['name'], $registration_date);

		if ($stmt->execute()) {
			move_uploaded_file($user_photo['tmp_name'], 'uploads/' . $user_photo['name']);
			$_SESSION['username'] = $username;
			setcookie('username', $username, time() + (86400 * 30), '/');
			$success = true;
		} else {
			$errors['db'] = 'Error in inserting data into database';
		}
	}
}

if ($success) {
	echo "<script>alert('Registration successful. Please login to continue.'); window.location.href = 'login.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Registration</title>
	<link rel="stylesheet" href="./css/registration.css">
</head>

<body>

	<h1>Registration</h1>
	
	<div class="container">
		<form action="" method="post" enctype="multipart/form-data">
			<table>
				<tr>
					<td><label for="first_name">First Name:</label>
					</td>
					<td><input type="text" name="first_name" id="first_name" value="<?php echo isset($first_name) ? htmlspecialchars($first_name) : ''; ?>"></td>
				</tr>
				<tr>
					<td><label for="last_name">Last Name:</label>
					</td>
					<td><input type="text" name="last_name" id="last_name" value="<?php echo isset($last_name) ? htmlspecialchars($last_name) : ''; ?>"></td>
				</tr>
				<tr>
					<td><label for="username">Username:</label>
					</td>
					<td><input type="text" name="username" id="username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>"></td>
				</tr>
				<tr>
					<td><label for="mobile_number">Mobile Number:</label>
					</td>
					<td><input type="text" name="mobile_number" id="mobile_number" value="<?php echo isset($mobile_number) ? htmlspecialchars($mobile_number) : ''; ?>"></td>
				</tr>
				<tr>
					<td><label for="email">Email:</label>
					</td>
					<td><input type="email" name="email" id="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>"></td>
				</tr>
				<tr>
					<td><label for="user_photo">User Photo:</label>
					</td>
					<td> <input type="file" name="user_photo" id="user_photo">
					</td>
				</tr>
				<tr>
					<td><label for="password">Password:</label>
					</td>
					<td><input type="password" name="password" id="password"></td>
				</tr>
				<tr>
					<td><label for="confirm_password">Confirm Password:</label></td>
					<td><input type="password" name="confirm_password" id="confirm_password"></td>
				</tr>
				<tr>
					<td colspan="2"><button type="submit">Submit</button></td>
				</tr>
				<tr>
					<td colspan="2"><p>Already have an account? <a href="login.php">Login here</a></p></td>
				</tr>
			</table>
			<?php if (!empty($errors)) : ?>
				
		<ul>
			<?php echo "Errors in Validation:" ?>
			<?php foreach ($errors as $error) : ?>
				<li><?php echo $error; ?></li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
		</form>

	</div>
</body>

</html>