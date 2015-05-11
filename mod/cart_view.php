<?php
require_once('../inc/autoload.php'); 
$session = Session::getSession('cart');

$objCart = new Cart();


$out = array();

//ruaj te gjitha produktet e perzgjedhura 
if(!empty($session))
{

	$objCatalogue = new Catalogue();
	foreach ($session as $key => $value)
	{	
		$out[$key] = $objCatalogue->getProduct($key);
		
	}

}



 ?>



<?php if(!empty($out)) { ?>


	<form action="" method="POST" id="frm_shopingcart">
		<table id="">
			<tr>
				<th>Produkti</th>
				<th>Sasia</th>
				<th>Çmimi</th>
				<th>Largo</th>
			</tr>

			<?php foreach ($out as $item) { ?>
	
			<tr>
				<td><?php echo Helper::encodeHTML($item['name']); ?></td>
				<td><input type="text" name="qty-<?php echo $item['id']; ?>" 
					id="qty-<?php echo $item['id']; ?>" class="float_qty"
				    value="<?php echo $session[$item['id']]['qty']; ?>" /></td>
				<td>&euro;<?php echo number_format($objCart->itemTotal($item['price'],$session[$item['id']]['qty']),2); ?></td>
				<td><?php echo Cart::removeButton($item['id']); ?></td>
			</tr>

			<?php  }//end of foreach ?>


			<?php if($objCart->_vat_rate != 0) { ?>
			<tr>
				<td colspan="2" >Pa-tvsh</td>
				<td>&euro;<?php echo number_format($objCart->_sub_total,2); ?></td>
				<td>&nbsp;</td>
			</tr>
			

			<tr>
				<td colspan="2" >Tvsh (<?php echo $objCart->_vat_rate; ?>%)</td>
				<td>&euro;<?php echo number_format($objCart->_vat,2)?></td>
				<td>&nbsp;</td>
			</tr>
			<?php }?>
			
			<tr>
				<td colspan="2" >Totali:</td>
				<td>&euro;<?php echo number_format($objCart->_total,2); ?></td>
				<td>&nbsp;</td>
			</tr>
		</table>

		<div>&nbsp;</div>
		<div class="sbm">
			<a href="?page=paypal" class="button ">Vazhdo</a>
		</div>
		<div class="sbm update_cart">
			<a href="" class="button ">Ndrysho</a>
		</div>
	</form>


<?php } else { ?>
<p>Shporta juaj eshte e zbrazet</p>
<?php  } ?>

