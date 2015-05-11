<?php

class Admin extends Database 
{
	private $_table = 'admin';
	public $_id;


	public function isAdmin($name=null, $password=null)
	{
		if(!empty($name) && !empty($password))
		{

			$password = Login::stringhash($password);
			$sql = "SELECT * FROM `{$this->_table}` WHERE `name` = :name AND `password`= :password";
			$result = $this->validAdmin($sql,$name,$password);

			if(!empty($result))
			{
				$this->_id=$result['id'];
				return true;
			}

			return false;
		}
	}
}

?>