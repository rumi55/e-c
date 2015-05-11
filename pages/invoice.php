<?php

$id = Url::getParam('id');

if (!empty($id)) {

	$objOrder = new Order();
	$order = $objOrder->getOrder($id);

	if (!empty($order) && Session::getSession(Login::$_login_front) == $order['client']) {
		
		$items = $objOrder->getOrderItems($id);

		$objCatalogue = new Catalogue();

		$objUser = new User();
		$user = $objUser->getUser($order['client']);

		$objCountry = new Country();

		$objBusiness = new Business();
		$business = $objBusiness->getBusiness();

		$objCart = new Cart();
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Invoice </title>
	<link rel="stylesheet" href="assets/css/templates/foundation.css" />
</head>
<body>

<div class="wrapper">
	<h1>Invoice</h1>

	<div style="width:50%;float:left">
		<p><strong>To:</strong>
		<?php echo $user['first_name']." ".$user['last_name']; ?><br/>
		<?php echo $user['address_1']; ?><br/>
		<?php echo !empty($user['address_2']) ? $user['address_2'].'<br/>' : null; ?>
		<?php echo $user['town']; ?><br/>
		<?php echo $user['county']; ?><br/>
		<?php echo $user['post_code']; ?><br/>
		<?php 
		$country = $objCountry->getCountry($user['country']);
		echo $country['name'];

		?>

		</p>
	</div>
	<div style="width:50%;float:right;text-align:right;">
		<p><strong><?php echo $business['name']; ?></strong>
		<?php echo nl2br($business['address']); ?><br/>
		<?php echo $business['telephone']; ?><br/>
		<?php echo $business['email']; ?><br/>
		</p>
	</div>
	<div>&#160;</div>

	<h3>Order number <?php echo $id; ?></h3>

	<table cellpadding="0" cellspacing="0" border="0" >
		<tr>
			<th>Item</th>
			<th>Qty</th>
			<th>Price</th>
		</tr>

		<?php foreach($items as $item) { ?>

		<tr>
			<td>
				<?php 
				$product  = $objCatalogue->getProduct($item['products']);
				echo $product['name']; 
				?>
			</td>
			<td>
				<?php echo $item['qty']; ?>
			</td>
			<td>
				&euro;<?php echo number_format($objCart->itemTotal($item['price'], $item['qty']), 2); ?>
			</td>
		</tr>

		<?php } ?>

		<?php if($order['vat_rate'] != 0) { ?>
		<tr>
			<td colspan="2">Sub-total:</td>
			<td>&euro;<?php echo number_format($order['subtotal'], 2); ?></td>
		</tr>

		<tr>
			<td colspan="2">Vat: (<?php echo $order['vat'] ?>) %</td>
			<td>&euro;<?php echo number_format($order['vat'], 2); ?></td>
		</tr>

		

		<?php }?>

		<tr>
			<td colspan="2">Total:</td>
			<td>&euro;<?php echo number_format($order['total'], 2); ?></td>
		</tr>


	</table>

	<div>&nbps;</div>
	<p><a href="#" onclick="window.print(); return false">Print this invoice</a></p>

</div>

</body>
</html>


<?php } } ?>