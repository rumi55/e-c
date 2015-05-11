<?php

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


require_once('_header.php'); 
 ?>


<h4>Kontrolo produktet dhe proceso me blerjen permes paypal</h4>
<?php if(!empty($out)) { ?>

<div class="large-8 columns" id="shoping_cart">
	<form action="" method="POST" id="frm_shopingcart">
		<table id="">
			<tr>
				<th>Produkti</th>
				<th>Sasia</th>
				<th>Çmimi</th>
				
			</tr>

			<?php foreach ($out as $item) { ?>
	
			<tr>
				<td><?php echo Helper::encodeHTML($item['name']); ?></td>
				<td><?php echo $session[$item['id']]['qty']; ?> </td>
				<td>&euro;<?php echo number_format($objCart->itemTotal($item['price'],$session[$item['id']]['qty']),2); ?></td>
				
			</tr>

			<?php  }//end of foreach ?>


			<?php if($objCart->_vat_rate != 0) { ?>
			<tr>
				<td colspan="2" >Pa-tvsh</td>
				<td>&euro;<?php echo number_format($objCart->_sub_total,2); ?></td>
				
			</tr>
			

			<tr>
				<td colspan="2" >Tvsh (<?php echo $objCart->_vat_rate; ?>%)</td>
				<td>&euro;<?php echo number_format($objCart->_vat,2)?></td>
			
			</tr>
			<?php }?>
			
			<tr>
				<td colspan="2" >Totali:</td>
				<td>&euro;<?php echo number_format($objCart->_total,2); ?></td>
				
			</tr>
		</table>

		
	</form>
</div>


<?php

function paypal_items($sessionProduct,$objectCart,$globalOut)
{

				$num=0;
				
				foreach ($globalOut as $item)
				{
					$num++;
					echo '<input type="hidden" name="item_number_'.$num.'" value ="'.$item['id'].'">';
					echo '<input type="hidden" name="item_name_'.$num.'" value= "'.$item['name'].'">';
					echo '<input type="hidden" name="amount_'.$num.'" value="'.$item['price'].'">';
					
					echo '<input type="hidden" name="quantity_'.$num.'" value="'.$sessionProduct[$item['id']]['qty'].'">';
				}
			
				echo '<input type="hidden" name="tax_'.$num.'" value="'.$objectCart->_vat.'">';
}

?>


<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_cart">
<input type="hidden" name="upload" value="1">
<input type="hidden" name="business" value="nw4tony.1@Msn.com">
<?php paypal_items($session,$objCart,$out); ?>

<input type="hidden" name="currency_code" value="EUR">
<input type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
</form>

<?php } else { ?>
<p>Shporta juaj eshte e zbrazet</p>
<?php  } ?>





<?php require_once('_footer.php'); ?>