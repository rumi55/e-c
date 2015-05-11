<?php
Login::restrictPage();
require_once('template/_header.php');

$objForm = new Form();
$params=array();
$objCatalogue = new Catalogue();
$categories = $objCatalogue->getAllCategories();


if(isset($_POST['btn_newproduct']))
{

	$params['category'] = $_POST['category'];
	$params['name'] = $_POST['name'];
	$params['description'] = $_POST['description'];
	$params['price'] = $_POST['price'];
	$params['sasia_per_oferte']=$_POST['sasia_per_oferte'];
	$params['zbritja']=$_POST['zbritja'];
	
		// nese eshte shtuar produkti
	if($objCatalogue->addProduct($params))
	{
		
		$objUpload = new Upload();
		if($objUpload->uploadFile(CATALOGUE_PATH))
		{
			
			$objCatalogue->updateProduct(array('image'=>$objUpload->_names[0]),$objCatalogue->_id);
			Helper::redirect('?page=products');
		} else {
			echo "nuk u shtua ne db";
		}

	}
}
?>

<div class="large-8 columns">
	<div class="row">
		<h1>Shto produktin:</h1>

		<div class="small-10 small-cetered columns">
		<form action="" id="frm_newproduct" method="post" enctype="multipart/form-data">
			<fieldset>
				<legend>Te dhenat per produktin</legend>
				<lablel>Kategoria<br/>
					<select name="category" id="category">
						<option value="">Zgjidhni kategorine</option>
						<?php if(!empty($categories)) {
							foreach($categories as $cat) { ?>
								<option value="<?php echo $cat['id']; ?>"
									<?php echo $objForm->stickyValue('category', $cat['id']); ?>
									>
									<?php echo Helper::encodeHTML($cat['name']); ?>
								</option>	
						<?php	}
						}
						?>
					</select>
				</label>
				<label>Emri produktit: <br/>
					<input type="text" name="name" id="name" value="<?php echo $objForm->stickyText('name'); ?>" placeholder="emri produktit">
				</label>
				<label>Pershkrimi i produktit: 			
			        <textarea name="description" rows="8" placeholder=""><?php echo $objForm->stickyText('description'); ?></textarea>
			    </label>
			    <label>Cmimi:
			    	<input type="text" name="price" value="<?php echo $objForm->stickyText('price'); ?>" id="price" />
			    </label>
			    <label>Sasia e produktit per oferte
			    	<input type="number" name="sasia_per_oferte" id="sasia_per_oferte" />
			    </label>
			    <label>Zbritja (%)
			    	<input type="number" min="1" max="100" name="zbritja" id="zbritja">
			    </label>

			    <label>Imazhi:
			    	<input type="file" name="image" id="image" />
			    </label>
			    <label>
			    	<input type="submit" name="btn_newproduct" id="btn_newproduct" class="button" value="Shto produktin" />
			    </label>
			</fieldset>

		</form>
		</div>
	</div>
</div>
<?php require_once('template/_footer.php'); ?>