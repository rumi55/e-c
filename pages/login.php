<?php 

if (Login::isLogged(Login::$_login_front)) {
	Helper::redirect(Login::$_dashboard_front);
}


$objForm = new Form();
$objValid = new Validation($objForm);
$objUser = new User();



//login form
if ($objForm->isPost('login_email')) {
	if ($objUser->isUser($objForm->getPost('login_email'), $objForm->getPost('login_password'))) {
		Login::loginFront($objUser->_id, Url::getReferrerUrl());
	} else {
		$objValid->add2Errors('login');
	}
}


//registration form 
if ($objForm->isPost('first_name')) {

	$objValid->_expected = array(
			'first_name',
			'last_name',
			'address_1',
			'address_2',
			'town',
			'county',
			'post_code',
			'country',
			'email',
			'password',
			'confirm_password'
		);

	$objValid->_required = array(
			'first_name',
			'last_name',
			'address_1',
			'address_2',
			'town',
			'county',
			'post_code',
			'country',
			'email',
			'password',
			'confirm_password'
		);

	$objValid->_special = array(
			'email'=>'email'
		);

	

	$objValid->_post_remove = array(
			'confirm_password'
		);

	$objValid->_post_format = array(
			'password' => 'password'
		);


	//validate password
	$pass_1 = $objForm->getPost('password');
	$pass_2 = $objForm->getPost('confirm_password');


	if (!empty($pass_1) && !empty($pass_2) && $pass_1 != $pass_2) {
		$objValid->add2Errors('password_mismatch');

	}



	$email = $objForm->getPost('email');
	$user = $objUser->getByEmail($email);

	if (!empty($user)) {
		$objValid->add2Errors('email_duplicate');
	}


	if ($objValid->isValid()) {
		
		//add hash for activating account
		$objValid->_post['hash'] = mt_rand().date('YmdHis').mt_rand();

		//add registration date
		$objValid->_post['date'] = Helper::setDate();


		if ($objUser->addUser($objValid->_post, $objForm->getPost('password'))) {
			Helper::redirect('?page=registered');
		} else {
			Helper::redirect('?page=registered-failed');
		}
	}

}

require_once('_header.php'); 

?>




<h1>Login</h1>


<form action="" method="post">
	<table cellpadding="0" cellspacing="0" border="0" class="tbl_insert">
		<tr>
			<th>
				<label for="login_email">Login:</label>
			</th>
			<td>
			<?php echo $objValid->validate('login'); ?>
				<input type="text" name="login_email" id="login_email" class="fld" value="" />
			</td>
		</tr>

		<tr>
			<th>
				<label for="login_password">Password:</label>
			</th>
			<td>
				<input type="password" name="login_password" id="login_password" class="fld" value="" />
			</td>
		</tr>

		<tr>
			<th>&nbsp;</th>
			<td>
				<label for="btn_login" class="sbm smb_blue fl_l">

					<input type="submit" id="btn_login" class="btn" value="Login">	
				</label>
			</td>
		</tr>

	</table>
</form>

<div class="dev br_td">&#160;</div>

<h3>Not registered yet?</h3>

<form action="" method="post">
	<table cellpadding="0" cellspacing="0" border="0" class="tbl_insert">

		<tr>
			<th>
				<label for="first_name">First Name: *</label>
			</th>
			<td>
				<?php echo $objValid->validate('first_name'); ?>
				<input type="text" name="first_name" id="first_name" 
				value="<?php echo $objForm->stickyText('first_name'); ?>" class="fld">
			</td>
		</tr>

		<tr>
			<th>
				<label for="last_name">Last Name: *</label>
			</th>
			<td>
				<?php echo $objValid->validate('last_name'); ?>
				<input type="text" name="last_name" id="last_name" 
				value="<?php echo $objForm->stickyText('last_name'); ?>" class="fld">
			</td>
		</tr>

		<tr>
			<th>
				<label for="address_1">Address 1: *</label>
			</th>
			<td>
				<?php echo $objValid->validate('address_1'); ?>
				<input type="text" name="address_1" id="address_1" 
				value="<?php echo $objForm->stickyText('address_1'); ?>" class="fld">
			</td>
		</tr>

		<tr>
			<th>
				<label for="address_2">Address 2: *</label>
			</th>
			<td>
				<?php echo $objValid->validate('address_2'); ?>
				<input type="text" name="address_2" id="address_2" 
				value="<?php echo $objForm->stickyText('address_2'); ?>" class="fld">
			</td>
		</tr>

		<tr>
			<th>
				<label for="town">Town: *</label>
			</th>
			<td>
				<?php echo $objValid->validate('town'); ?>
				<input type="text" name="town" id="town" 
				value="<?php echo $objForm->stickyText('town'); ?>" class="fld">
			</td>
		</tr>

		<tr>
			<th>
				<label for="county">County: *</label>
			</th>
			<td>
				<?php echo $objValid->validate('county'); ?>
				<input type="text" name="county" id="county" 
				value="<?php echo $objForm->stickyText('county'); ?>" class="fld">
			</td>
		</tr>

		<tr>
			<th>
				<label for="post_code">Post code: *</label>
			</th>
			<td>
				<?php echo $objValid->validate('post_code'); ?>
				<input type="text" name="post_code" id="post_code" 
				value="<?php echo $objForm->stickyText('post_code'); ?>" class="fld">
			</td>
		</tr>

		<tr>
			<th>
				<label for="country">Country: *</label>
			</th>
			<td>
				<?php echo $objValid->validate('country'); ?>
				<?php echo $objForm->selectCountry('AL'); ?>
			</td>
		</tr>

		<tr>
			<th>
				<label for="email">Email address: *</label>
			</th>
			<td>
				<?php echo $objValid->validate('email'); ?>
				<?php echo $objValid->validate('email_duplicate'); ?>
				<input type="text" name="email" id="email" 
				value="<?php echo $objForm->stickyText('email'); ?>" class="fld">
			</td>
		</tr>

		<tr>
			<th>
				<label for="password">Password: *</label>
			</th>
			<td>
				<?php echo $objValid->validate('password'); ?>
				<?php echo $objValid->validate('password_mismatch'); ?>
				<input type="password" name="password" id="password" value="" class="fld">
			</td>
		</tr>

		<tr>
			<th>
				<label for="confirm_password">Confirm Password: *</label>
			</th>
			<td>
				<?php echo $objValid->validate('confirm_password'); ?>
				<input type="password" name="confirm_password" id="confirm_password" value="" class="fld">
			</td>
		</tr>

		<tr>
			<th>&nbsp;</th>
			<td>
				<label for="btn" class="sbm smb_blue fl_l">

					<input type="submit" id="btn" class="btn" value="Register">	
				</label>
			</td>
		</tr>

	</table>	
</form>


<?php require_once('_footer.php'); ?>
