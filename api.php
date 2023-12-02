<?php

require "./products.php";

/**
 * Receive request from the index.php file and we decide to call {@link addToCart()}
 * to add items or increase quantity in the cart or to call {@link removeFromCart()}
 * to remove items or to decrease quantity from the cart.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	$key = json_decode(file_get_contents('php://input'), true);

	if (isset($key['action']) && ($key['action'] === 'add' || $key['action'] === 'increase')) {
		addToCart($key, $data);
	} else if (isset($key['action']) && ($key['action'] === 'remove' || $key['action'] === 'decrease')) {
		removeFromCart($key['id']);
	}

	echo json_encode(["message" => "Request was a success."]);

} else {
	header("location: index.php");
}

/**
 * Add or increase cart items.
 * 
 * Will increase quantity or add item in cart.
 * 
 * Items in cart are saved in cookies.
 * 
 * @param	string	$key	position of item in $data array.
 * @param	array	$data	each item from database.products.php file.
 */
function addToCart($key, $data): void {

	$product = $data['products'][$key['id']];
	
	$product_template = [
		'id'		=> $key['id'],
		'name'		=> $product['name'],
		'price'		=> $product['price'],
		'quantity'	=> 1,
	];

	if (isset($_COOKIE['products'])) {
		
		$cookie_product = json_decode($_COOKIE['products'], true);

		$found_product = false;

		foreach ($cookie_product['products'] as $key => &$prod) {
			if ($prod['id'] === $product_template['id']) {
				$prod['quantity'] += 1;
				$found_product = true;
			}
		}

		if (!$found_product) {
			array_push($cookie_product['products'], $product_template);
		}

		setcookie('products', json_encode($cookie_product), time() + 360);

	} else {
		setcookie('products', json_encode(array('products' => array($product_template))), time() + 360);
	}
}

function removeFromCart($id):void {
	// @TO DO
}
?>