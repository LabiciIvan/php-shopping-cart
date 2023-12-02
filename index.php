<?php
require "./database.products.php";

$cookie_products = (isset($_COOKIE['products']) ? json_decode($_COOKIE['products'], true) : null);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Shopping Cart</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="cart"> <a href="./cart.php"> Products : <?php echo (isset($cookie_products['products']) ? count($cookie_products['products']) : '0')?></a></div>
	<?php
		foreach ($data['products'] as $key => $product) {
			echo "<div class='card'>" .
				"<img class='card-image' src={$product['image']} alt='Product' />" .
				"<h2 class='card-title'>{$product['name']}</h2>" .
				"<div class='card-footer'>" . 
					"<h3 class='price'>{$data['currency']['symbol']} {$product['price']}</h3>".
					"<button class='add-btn' value={$key} onClick={addToCart($key)}>Add</button>".
				"</div>" .
			"</div>";
		}
	?>
	<script src="./functions.js" defer></script>
</body>
</html>