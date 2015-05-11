<?php

class User extends Database {

	private $_table  = "clients";
	public $_id;




	public function isUser($email, $password)
	{
		$passsword = Login::stringhash($password);
		

		$password = Login::stringhash($password);
			$sql = "SELECT * FROM `{$this->_table}` WHERE `email` = :email AND `password`= :password AND `active` = 1";
			$result = $this->validUser($sql,$email,$password);

		

		if(!empty($result))
			{
				$this->_id=$result['id'];
				return true;
			}

			return false;
	}



	public function addUser($params= null, $password = null)
	{
		if (!empty($params) && !empty($password)) {
			//sql to insert into db
			 $sql= "INSERT INTO `{$this->_table}` (first_name,last_name,address_1,address_2,town,county,post_code, country, email, password, date, hash) VALUES (:first_name, :last_name, :address_1, :address_2, :town, :county, :post_code, :country, :email, :password, :date, :hash)";
            $result= $this->insertUser($sql,$params);

			//if success send email 
			if ($result) {
				
				//send email
				$objEmail = new Email();
				if($objEmail->process(1, array(
						'email' 	=>$params['email'],
						'first_name'=>$params['first_name'],
						'last_name' =>$params['last_name'],
						'password'  =>$password,
						'hash' 		=>$params['hash']
					)))
				{
					return true;
				}

				return false;

			}

			return false;
			

		}

		return false;
	}



	public function getUserByHash($hash = null)
	{
		if (!empty($hash)) {
			
				$sql = "SELECT * FROM `{$this->_table}` WHERE `hash` = {$hash}";
				return $this->single($sql);
		}
	}

	public function makeActive($id = null)
	{
		if (!empty($id)) {
			
			$sql = "UPDATE `{$this->_table}` SET `active` = 1 WHERE `id` = {$id}";
			return $this->updateUserActive($sql,$id);

		}
	}

	public function getByEmail($email = null)
	{
		if (!empty($email)) {
			$sql = "SELECT * FROM `{$this->_table}` WHERE `email` = '{$email}' AND `active` = 1";
			return $this->single($sql);
		}
	}



	public function getUser($id = null)
	{
		$sql = "SELECT * FROM `{$this->_table}` WHERE `id` = {$id}";
		return $this->single($sql);
	}



	public function updateUser($array = null, $id = null)
	{
		if (!empty($array) && !empty($id)) {
			$sql = "UPDATE `{$this->_table}` SET `first_name` = :first_name, `last_name` = :last_name,
			 `address_1` = :address_1, `address_2` = :address_2, `town` = :town, `county` = :county,
			 `post_code` = :post_code, `country` =:country, `email` = :email WHERE `id` = {$id}";
			 return $this->dbUpdateUser($array,$sql);
		}
	}



}




?>