<?php
Login::restrictPage();

 require_once('template/_header.php');

$objCatalogue = new Catalogue();
$products = $objCatalogue->getAllProducts();

$objPaging = new Pagination($products,10);
$rows=$objPaging->getRecords();
$objPaging->_url=$objPaging->_url;

if(!empty($rows)) { ?>

<h1>Produktet:</h1>
<div class="large-8 columns">
	<div class="row">
		<h4><a href="?page=newproduct">Shto produkte</a></h4>
		<p>&nbsp;</p>
		<table class="products">
			<tr>
				<th>ID</th>
				<th>Produkti</th>
				<th>Largo</th>
				<th>Ndrysho</th>
			</tr>
			<?php foreach ($rows as $product) { ?>
			
			<tr class="record">
				<td><?php echo $product['id']; ?></td>
				<td><?php echo Helper::encodeHTML($product['name']); ?></td>
				<td><a class="tiny button del_product" id="<?php echo $product['id']; ?>">Fshi</a></td>
				<td><a class="tiny button"  href="?page=edit-product&amp;&amp;id=<?php echo $product['id']; ?>">Ndrysho</a></td>
			</tr>
			<?php } ?>
		</table>
	</div>

<?php 

echo $objPaging->getPagination(); 

}

 else { ?>

<p>Nuk ka produkte</p>

<?php  } ?>
</div>
<?php require_once('template/_footer.php'); ?>