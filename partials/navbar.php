<?php
$cookie_products = (isset($_COOKIE['products']) ? json_decode($_COOKIE['products'], true) : null);
?>
<div class="cart">
	<a class="cart-link" href="./index.php"> Products</a>
	<a class="cart-link" href="./cart.php"> Cart : <?php echo (isset($cookie_products['products']) ? count($cookie_products['products']) : '0')?></a>
</div>