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
		removeFromCart($key['id'], $key['action']);
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

/**
 * Remove or decrease cart items.
 * 
 * Will remove or decrease the quantity of the cart items.
 * 
 * If after removing items from cart there will be no more items left, then
 * will terminate the cookie as well, as there are no reason to keep it.
 * 
 * @param	string	$id		identification number of item in cookies.
 * @param	string	$action	decision to remove item or to decrease quantity.
 */
function removeFromCart($id, $action): void {
	// Retrieve data from cookies.
	$cart_products = (isset($_COOKIE['products']) ? json_decode($_COOKIE['products'], true) : null);

	$to_remove = null;

	// Iterate products from cookies to find which index element to remove from array.
	if (isset($cart_products)) {
		foreach ($cart_products['products'] as $key => $product) {

			if ((int)$product['id'] === (int)$id) {
				$to_remove = $key;
			}
		}
	}

	// Remove the product from the cart.
	array_splice($cart_products['products'], $to_remove, 1);

	// Eliminate cookie if there are no more products.
	if (count($cart_products['products']) === 0) {
		setcookie('products', json_encode($cart_products), time() - 360);
	} else {
		// Update cookies with new array without the specified element.
		setcookie('products', json_encode($cart_products), time() + 360);
	}
}
?>