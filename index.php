<?php require "./products.php"; ?>
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
	<?php
		foreach ($data['products'] as $key => $product) {
			echo "<div class='card'>" .
				"<img class='card-image' src={$product['image']} alt='Product' />" .
				"<h2 class='card-title'>{$product['name']}</h2>" .
				"<div class='card-footer'>" . 
					"<h3 class='price'>{$data['currency']['symbol']} {$product['price']}</h3>".
					"<button class='add-btn' value={$key} onClick=\"callToApi('" .$product['id']. "', 'add')\">Add</button>".
				"</div>" .
			"</div>";
		}
	?>
	<script src="./requestsAPI.js" defer></script>
</body>
</html>