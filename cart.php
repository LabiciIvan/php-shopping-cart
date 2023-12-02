<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Shopping Cart</title>
	<link rel="stylesheet" href="./css/style.css">
</head>
<body>
	<?php require "./partials/navbar.php" ?>
	<?php if (isset($cookie_products)) { ?>
		<table class="cart-table">
			<tr>
				<th>Name</th>
				<th>Quantity</th>
				<th>Price</th>
				<th>Increase/Decrease</th>
				<th>Delete</th>
			</tr>
	<?php } ?>

	<?php
	if (isset($cookie_products)) {
		foreach ($cookie_products['products'] as $key => $product) {
			echo "<tr>" .
					"<td>{$product['name']}</td>" .
					"<td>{$product['quantity']}</td>" .
					"<td>{$product['price']}</td>" .
					"<td><button class='add-btn'>+</button><button class='add-btn'>-</button></td>" .
					"<td><button class='cart-link' onClick=\"callToApi('".$product['id']."', 'remove')\">Remove</button></td>" .
				"</tr>";
		}
	} else {
		echo "<div> No items in cart !</div>";
	}
	?>
	</table>

	<script src="./requestsAPI.js" defer></script>
</body>
</html>