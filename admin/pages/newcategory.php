<?php
Login::restrictPage();
require_once('template/_header.php');

$objForm = new Form();

$objCatalogue = new Catalogue();
$categories = $objCatalogue->getAllCategories();


if(isset($_POST['btn_newcategory']))
{

	
	if(isset($_POST['name']))
		{
			$param = $_POST['name'];
		
			if($objCatalogue->duplicateCategory($param))
			{

				if($objCatalogue->addCategory($param))
				{
					Helper::redirect('?page=categories');

				} else {

					echo "nuk u shtua ne db";
				}
			} else {

				echo "Eksiston kjo kategori";
			}

	}
}
?>

<div class="large-8 columns">
	<div class="row">
		<h1>Shto kategori:</h1>

		<div class="small-10 small-cetered columns">
		<form action="" id="frm_category" method="post" >
			<fieldset>
				<legend>Te dhenat per Kategorine</legend>
				
				<label>Emri Kategorise: <br/>
					<input type="text" name="name" id="name" value="<?php echo $objForm->stickyText('name'); ?>" placeholder="emri kategorise">
				</label>
				
			    <label>
			    	<input type="submit" name="btn_newcategory" id="btn_newcategory" class="button" value="Shto kategorine" />
			    </label>
			</fieldset>

		</form>
		</div>
	</div>
</div>
<?php require_once('template/_footer.php'); ?>