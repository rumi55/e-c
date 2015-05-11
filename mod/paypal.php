<?php

require_once('../inc/autoload.php');

//tokens

$token2 = Session::getSession('token2');
$objForm = new Form();
$token1 = $objForm->getPost('token');

if ($token2 == Login::stringhash($token1)) {
	
	//create order
	$objOrder = new Order();
	if($objOrder->createOrder())
	{

		//populate order details
		$order = $objOrder->getOrder();
		$items = $objOrder->getOrderItems();
		

		if (!empty($order) && !empty($items)) {
			
			$objCart = new Cart();
			$objCatalogue = new Catalogue();
			$objPayPal = new PayPal();


			foreach ($items as $item) {
				
				$product = $objCatalogue->getProduct($item['products']);
				
				$objPayPal->addProduct($item['products'], $product['name'], $item['price'], $item['qty']);
			}


			$objPayPal->_tax_cart = $objCart->_vat;


			//populate client's details
			$objUser = new User();
			$user = $objUser->getUser($order['client']);


			if (!empty($user)) {
				
				/* need to add 'id' column on db*/
				//get user country record
				//$objCountry = new Country();
				//$country = $objCountry->getCountry('AL');
				
				
				//pas client's details to the PayPal instace
				$objPayPal->_populate = array(
					  'address1'    =>$user['address_1'],
					  'address2' 	=>$user['address_2'],
					  'city'		=>$user['town'],
					  'state'		=>$user['county'],
					  'zip'			=>$user['post_code'],
					  //'country'		=>$country['code'],
					  'email'		=>$user['email'],
					  'first_name'	=>$user['first_name'],
					  'last_name'	=>$user['last_name']
					);

				//redirect client to Paypal
				echo $objPayPal->run($order['id']);

			}

			

		}

	}
}