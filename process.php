<?php

require "./database.products.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	$key = json_decode(file_get_contents('php://input'), true);

	$product = $data['products'][$key['key']];

	$product_template = [
		'name'		=> $product['name'],
		'price'		=> $product['price'],
		'quantity'	=> 1,
	];

	if (isset($_COOKIE['products'])) {
		
		$cookie_product = json_decode($_COOKIE['products'], true);

		$found_product = false;

		foreach ($cookie_product['products'] as $key => &$prod) {
			if ($prod['name'] === $product_template['name']) {
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

	echo json_encode(["message" => "Request was a success."]);

}
?>