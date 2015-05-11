<?php

Login::restrictFront();


$token1 = mt_rand();
$token2 = Login::stringhash($token1);
Session::setSession('token2', $token2);




$objBasket = new Cart();

$out = array();

$session = Session::getSession('cart');

if (!empty($session)) {
	$objCatalogue = new Catalogue();
	foreach ($session as $key => $value) {
		
		$out[$key] = $objCatalogue->getProduct($key);


	}
}

require_once('_header.php');
?>

<h1>Order Summary</h1>

<?php if (!empty($out)) { ?>
	

	<div id="big_basket">
		<form action="" method="post" id="frm_basket">
			<table cellspacing="0" cellpadding="0" border="0" class="tbl_repeat">
				<tr>
					<th>Item</th>
					<th class="ta_r">Qty</th>
					<th class="ta_r col_15">Price</th>

				</tr>

				<?php foreach($out as $item){ ?>
					<tr>
						<td><?php echo $item['name']; ?></td>
						<td><?php echo $session[$item['id']]['qty']; ?></td>
						<td>&euro;<?php echo number_format($objBasket->itemTotal($item['price'], $session[$item['id']]['qty']), 2) ?></td>
					</tr>
				<?php }?>

				<?php if ($objBasket->_vat_rate != 0) { ?>
					
					<tr>
						<td colspan="2">
							Sub-total:
						</td>
						<td >
							&euro;<?php echo number_format($objBasket->_sub_total, 2) ?>
						</td>
					</tr>

					<tr>
						<td colspan="2">
							Vat(<?php echo $objBasket->_vat_rate; ?> %)
						</td>
						<td >
							&euro;<?php echo number_format($objBasket->_vat, 2) ?>
						</td>
					</tr>

				<?php } ?>


					<tr>
						<td colspan="2">
							<strong>Total</strong> 
						</td>
						<td >
							<strong>&euro;<?php echo number_format($objBasket->_total, 2) ?> </strong> 
						</td>
					</tr>

			</table>

			<div>&#160;</div>

			<div class="sbm sbm_blue right button paypal" id="<?php echo $token1; ?>">
				<span>Proceed to paypal</span>
			</div>

			<div class="sbm button left" >
					<a href="?page=shopingcart"> Amend order</a>
			</div>

		</form>
	</div>

<div class="dn">
	<img src="assets/images/loadinfo.net.gif"  alt="Proceeding to PayPal"/>
</div>


<?php } else {   ?>

<p>Your basket is empty.</p>

<?php } ?>

<?php

require_once('_footer.php');