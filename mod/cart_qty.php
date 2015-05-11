<?php

require_once('../inc/autoload.php');

if(isset($_POST['qty']) && isset($_POST['id']))
{
	$out = array();
	$id = $_POST['id'];
	$value=$_POST['qty'];

	$objCatalogue = new Catalogue();
	$product = $objCatalogue->getProduct($id);

	if(!empty($product))
	{
		switch ($value) {
			case 0:
				Session::removeItem($id);
				break;
			
			default:
				Session::setItem($id,$value);
				
		}
	}
}
?>