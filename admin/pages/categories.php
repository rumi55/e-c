<?php
Login::restrictPage();

 require_once('template/_header.php');

$objCatalogue = new Catalogue();
$category = $objCatalogue->getAllCategories();

$objPaging = new Pagination($category,5);
$rows=$objPaging->getRecords();
$objPaging->_url=$objPaging->_url;

if(!empty($rows)) { ?>

<h1>Kategorite:</h1>
<div class="large-8 columns">
	<div class="row">
		<h4><a href="?page=newcategory">Shto kategori</a></h4>
		<p>&nbsp;</p>
		<table class="products">
			<tr>
				<th>ID</th>
				<th>Kategoria</th>
				<th>Largo</th>
				<th>Ndrysho</th>
			</tr>
			<?php foreach ($rows as $category) { ?>
			
			<tr class="record">
				<td><?php echo $category['id']; ?></td>
				<td><?php echo Helper::encodeHTML($category['name']); ?></td>
				<td><a class="tiny button del_category" id="<?php echo $category['id']; ?>">Fshi</a></td>
				<td><a class="tiny button"  href="?page=edit-category&amp;&amp;id=<?php echo $category['id']; ?>">Ndrysho</a></td>
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