<?php
Login::restrictPage();
require_once('template/_header.php');
$id=Url::getParam('id');

if(!empty($id))
{




$objCatalogue = new Catalogue();
$product = $objCatalogue->getProduct($id);

if(!empty($product)) 
{



	$categories = $objCatalogue->getAllCategories();

	$objForm = new Form();
	$params=array();




	if(isset($_POST['btn_newproduct']))
	{ 

		$params['category'] = $_POST['category'];
		$params['name'] = $_POST['name'];
		$params['description'] = $_POST['description'];
		$params['price'] = $_POST['price'];
		
			// updateproduct
		if($objCatalogue->editProduct($params,$id))
		{
			
			$objUpload = new Upload();
			if($objUpload->uploadFile(CATALOGUE_PATH))
			{
				if(is_file(CATALOGUE_PATH.DS.$product['image']))
				{
					unlink(CATALOGUE_PATH.DS.$product['image']);
				}
				$objCatalogue->updateProduct(array('image'=>$objUpload->_names[0]),$id);
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
				<legend>Ndrysho te dhenat per produktin</legend>
				<lablel>Kategoria<br/>
					<select name="category" id="category">
						<option value="">Zgjidhni kategorine</option>
						<?php if(!empty($categories)) {
							foreach($categories as $cat) { ?>
								<option value="<?php echo $cat['id']; ?>"
									<?php echo $objForm->stickyValue('category', $cat['id'], $product['category']); ?>
									>
									<?php echo Helper::encodeHTML($cat['name']); ?>
								</option>	
						<?php	}
						}
						?>
					</select>
				</label>
				<label>Emri produktit: <br/>
					<input type="text" name="name" id="name" value="<?php echo $objForm->stickyText('name',$product['name']); ?>" placeholder="emri produktit">
				</label>
				<label>Pershkrimi i produktit: 			
			        <textarea name="description" rows="8" placeholder=""><?php echo $objForm->stickyText('description',$product['description']); ?></textarea>
			    </label>
			    <label>Cmimi:
			    	<input type="text" name="price" value="<?php echo $objForm->stickyText('price', $product['price']); ?>" id="price" />
			    </label>
			    <label>Imazhi:
			    	<input type="file" name="image" id="image" />
			    </label>
			    <label>
			    	<input type="submit" name="btn_newproduct" id="btn_newproduct" class="button" value="Ndrysho produktin" />
			    </label>
			</fieldset>

		</form>
		</div>
	</div>
</div>
<?php 

require_once('template/_footer.php'); 
   } //end of if ->product is not empty
} //end of if ->id is not empty

?>