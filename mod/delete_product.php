<?php

require_once('../inc/autoload.php');

$objCatalogue = new Catalogue();

if(isset($_POST['id']))
{
	$id=$_POST['id'];
	$objCatalogue->deleteProduct($id);

	
}



?>