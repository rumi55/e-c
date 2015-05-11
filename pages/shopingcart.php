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


<h1>Shporta</h1>
<?php if(!empty($out)) { ?>

<div class="large-8 columns" id="shoping_cart">
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
					id="qty-<?php echo $item['id']; ?>" class="fload_qty"
				    value="<?php echo $session[$item['id']]['qty']; ?>" /></td>
				<td>&euro;<?php echo number_format($objCart->itemTotal($item['price'],$session[$item['id']]['qty']),2); ?></td>
				<td class="remove_cart"><?php echo Cart::removeButton($item['id']); ?></td>
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
			<a href="?page=paypal" class="button   right">Vazhdo</a>
		</div>
		<div class="sbm update_cart">
			<a href="" class="button  ">Ndrysho</a>
		</div>
	</form>
	<hr/>
</div>



<div class="large-8 columns">
<h4>Produkte te rekomanduara:</h4>
<?php 

//recomand products
foreach ($out as  $values) {
	
	$id_product= $values['id'];
	$id_category = $values['category'];

	$products = $objCatalogue->randomProduct($id_product,$id_category);
	
	$rand_key = array_rand($products,1);
	$rand_product = $products[$rand_key];

	
	$image = !empty($rand_product['image'])?

            $objCatalogue->_path.$rand_product['image'] :
            $objCatalogue->_path.'unavailable.png';
            
            $width = Helper::getImageSize($image,0);
            $width = $width>120 ? 120 : $width;

            $height = Helper::getImageSize($image,1);
            $height = $height>150? 150 :$height;
?>

	 

    <div class="large-4 columns">
    	<a href="?page=catalogue-item&amp;category=<?php echo $rand_product['id']; ?>
           &amp;id=<?php echo $rand_product['id']; ?>">
        <image src="<?php echo $image; ?>" alt="<?php echo Helper::encodeHTML($rand_product['name'],1) ?>"
               width ="<?php echo $width; ?>" height="<?php echo $height; ?>" />
        </a>
        <h6>
            <a href="?page=catalogue-item&amp;category=<?php echo $rand_product['id']; ?>
           &amp;id=<?php echo $rand_product['id']; ?>">Me shume >></a>
        </h6>
       
       

    </div>

<?php
}

?>
</div>





<?php } else { ?>
<p>Shporta e juaj eshte e brazet</p>
<?php  } ?>

<?php require_once('_footer.php'); ?>



