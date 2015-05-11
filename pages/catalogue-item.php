


<?php
/* Faqja perkatese per produktin */

/* $id parametri merre nga url id e produktit*/
$id=Url::getParam('id');

/* Nese produkti $id nuk eshte i shbrazet 
ateher merre te dhenat specifike nga db per ate produkt dhe shfaqi
*/
if(!empty($id))
{
	$objCatalogue = new Catalogue();
	$product = $objCatalogue->getProduct($id);

	if(!empty($product))
	{

		$category=$objCatalogue->getCategory($product['category']);

		require_once('_header.php');
		?>
		<div class="large-8 columns">
			<div class="row">
		<?php
		echo "<h3>Katalogu::".$category['name']."</h3>";

		// merre imazhin dhe ruje ne parametrin $image nese ekziston
		$image = !empty($product['image']) ? 'media/catalogue/'.$product['image'] : null;

		// shfaqe imazhin
		if(!empty($image))
		{
			$width=Helper::getImageSize($image,0);
			$width=$width >120 ? 120 : $width;
			echo "<div class=\"large-6 columns\">";
			echo "<img src=\"{$image}\"";
			echo "alt=\"". Helper::encodeHTML($product['name'],1); "\"";
			echo "width=\"{$width}\" /></div>";
		}

		echo "<div class=\"large-6 columns\"><h5>".$product['name']."</h5>";
		echo "<h4><strong>&euro;".$product['price']."</strong></h4>";
		echo Cart::activeButton($product['id']);
		echo "</div>";
		echo "<div class=\"dev\">&nbsp;</div>";
		echo "<p>".Helper::encodeHTML($product['description'])."</p>&nbsp;";

		?>
			</div>
		  </div>
		<?php
		require_once('_footer.php');		

	} else {
		require_once('error.php');
	}


	
} else {
	require_once('error.php');
}

?>

