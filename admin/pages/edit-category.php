<?php
Login::restrictPage();
require_once('template/_header.php');
$id=Url::getParam('id');

if(!empty($id))
{




$objCatalogue = new Catalogue();
$category = $objCatalogue->getCategory($id);

if(!empty($category)) 
{



	

	$objForm = new Form();
	$params=array();




	if(isset($_POST['btn_editcategory']))
	{ 

		
		$param = $_POST['name'];

			// updateproduct
		if($objCatalogue->editCategory($param,$id))
		{
			
			Helper::redirect('?page=categories');

		} else {
			echo "Nuk u editua kategoria";
		}
	}
?>

<div class="large-8 columns">
	<div class="row">
		<h1>Nrysho kategorine:</h1>

		<div class="small-10 small-cetered columns">
		<form action="" id="frm_newproduct" method="post">
			<fieldset>
				<legend>Ndrysho te dhenat per kategorine</legend>
				
				<label>Emri kategorise:* <br/>
					<input type="text" name="name" id="name" value="<?php echo $objForm->stickyText('name',$category['name']); ?>">
				</label>
				
			    <label>
			    	<input type="submit" name="btn_editcategory" id="btn_editcategory" class="button" value="Ndrysho kategorine" />
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