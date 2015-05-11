<?php
require_once('../inc/autoload.php');


if (isset($_POST['active'] ) && isset($_POST['id'])) 
{
	
	$out =array();

	 $active=$_POST['active'];
	 $id=$_POST['id'];


	$objCatalogue = new Catalogue();
	$product = $objCatalogue->getProduct($id);

	if(!empty($product))
	{
		switch ($active) 
		{
			case 0:
				Session::removeItem($id);
				$out['active']=1;
				break;
			
			case 1:
				Session::setItem($id);
				$out['active']=0;
			break;
		}

		//converts php array  to javascript array
		echo json_encode($out);
	}
}





?>