<?php

class Validation
{
	private $objForm;

	private $_error = array();

	public $_message = array(
		'first_name' 	=> 'Please provide your first name',
		'last_name'		=> 'Please provide your last name',
		'address_1' 	=> 'Please provide the first line of your address',
		'address_2' 	=> 'Please provide the first line of your address 2',
		'town' 			=> 'Please provide your town name',
 		'county' 		=> 'Ju lutem jepni county',
 		'post_code'		=> 'Please provide your post code',
 		'country'		=> 'Please provide your country',
 		'email'			=> 'Please provide your eamil address',
 		'email_duplicate'  => 'This email address is already taken!',
 		'login' 		=> 'Username and / or password were incorect',
 		'password'		=> 'Please choose your password',
 		'confirm_password' => 'Please confirm your password',
 		'password_mismatch' => 'Password did not match'
 		

		);


	//fushat pritura
	public $_expected = array();

	//fushat e kerkuara
	public $_required = array();

	//fushat speciale
	//array('field_name'=>'format')
	public $_special = array();

	//vektori post
	public $_post = array();

	//fushat per tu larguar nga $_post vektori
	public $_post_remove = array();

	//fushat per formatim
	public $_post_format = array();


	public function __construct($objForm)
	{
		$this->objForm = $objForm;
	}

	public function process()
	{
		if ($this->objForm->isPost() &&  !empty($this->_required)) {
			//get only expected fields 
			$this->_post = $this->objForm->getPostArray($this->_expected); 

			if (!empty($this->_post)) {
				foreach ($this->_post as $key => $value) {
					$this->check($key, $value);
				}
			}
		}
	}


	public function add2Errors($key)
	{
		$this->_errors[] = $key;
	}

	public function check($key, $value)
	{
		if (!empty($this->_special) && array_key_exists($key, $this->_special)) {
			$this->checkSpecial($key, $value);
		} else {
			if(in_array($key, $this->_required) && empty($value))
			{
				$this->add2Errors($key);
			}
		}
	}


	public function checkSpecial($key, $value)
	{
		switch ($this->_special[$key]) {
			case 'email':
				if (!$this->isEmail($value)) {
					$this->add2Errors($key);
				}
				break;
			
			
		}
	}

	public function isEmail($email = null)
	{
		if(!empty($email))
		{
			$result = filter_var($email, FILTER_VALIDATE_EMAIL);

			return !$result ? false : true;
		}

		return false;
	}

	public function isValid()
	{
		$this->process();

		if (empty($this->_errors) && !empty($this->_post)) {
			//remove all unwanted fields
			if(!empty($this->_post_remove))
			{
				foreach ($this->_post_remove as $value) {
					unset($this->_post[$value]);
				}
			}

			//format all required fields
			if (!empty($this->_post_format)) {
				foreach ($this->_post_format as $key => $value) {
					$this->format($key, $value);
				}
			}

			return true;
		}

		return false;
	}



	public function validate($key)
	{
		if (!empty($this->_errors) && in_array($key, $this->_errors)) {
			return $this->wrapWarn($this->_message[$key]);
		}
	}


	public function wrapWarn($mess=null)
	{
		if(!empty($mess))
		{
			return "<span class=\"warn\">{$mess}</span>";
		}
	}


	public function format($key, $value)
	{
		switch ($value) {
			case 'password':
				$this->_post[$key] = Login::stringhash($this->_post[$key]);
				break;
			
		}
	}










}

?>