<?php

class Country extends Database
{
	public function getCountries()
	{
		$sql = "SELECT * FROM `country` ORDER BY `name` ASC";

		return $this->resultset($sql);
	}


 	public function getCountry($id = null)
 	{
 		if (!empty($code)) {
 			$sql = "SELECT * FROM `country` WHERE `id` = {$id} ";

 			return $this->single($sql);
 		}
 	}	 
}

?>