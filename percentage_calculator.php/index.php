<!DOCTYPE html>
<html>

<head>
	<title>Percentage Calculator</title>
	<link rel="stylesheet" href="./CSS/style.css">
</head>

<body>
	<h1>Percentage Calculator</h1>
	<form action="index.php" method="post">
		<table>
			<tr>
				<td>
					<label for="amount">Amount:</label>
				</td>
				<td>
					<input type="text" name="amount" id="amount" required>
				</td>
			</tr>
			<tr>
				<td><label for="interest_rate">Interest Rate:</label></td>
				<td> <input type="text" name="interest_rate" id="interest_rate" required></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" name="calculate" value="Calculate" class="submit"></td>
			</tr>
		</table>
	</form>
	<?php
	function calculate__percentage($amount, $interest_rate)
	{
		if (!is_numeric($amount) || !is_numeric($interest_rate)) {
			return "Both amount and interest rate should be numbers.";
		}
		if ($amount <= 0 || $interest_rate <= 0) {
			return "Both amount and interest rate should be greater than 0.";
		}
		return $amount * ($interest_rate / 100);
	}

	if (isset($_POST['calculate'])) {
		$amount = $_POST['amount'];
		$interest_rate = $_POST['interest_rate'];
		$result = calculate__percentage($amount, $interest_rate);
		if (is_numeric($result)) {
			echo "<p class='result'>The result is:" . $result . "</p>";
		} else {
			echo "<p class='form-error'> Error:" . $result . "</p>";
		}
	}
	?>
</body>

</html>