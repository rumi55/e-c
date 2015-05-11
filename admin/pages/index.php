<?php 

if(Login::isLogged(Login::$_login_admin))
{

	Helper::redirect(Login::$_dashboard);
}


$objAdmin = new Admin();

if(isset($_POST['admin_login']))
{

	if($objAdmin->isAdmin($_POST['name'],$_POST['password']))
	{
		
		Login::loginAdmin($objAdmin->_id);
	} else {
		echo 'gabim';
	}
}

require_once('template/_header.php');
 ?>

<h1>Login</h1>


<form action="" method="post" id="frm_admin">
  
  <div class="row">
    <div class="small-4 small-centered columns ">
      <div class="row">
        <div class="small-3 columns">
          <label for="right-label" class="left inline">Emri:</label>
        </div>
        <div class="small-9 columns">
          <input name="name" id="name" type="text" id="right-label" placeholder="emri">
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="small-4 small-centered columns">
      <div class="row">
        <div class="small-3 columns">
          <label for="right-label" class="left inline">Fjalkalimi:</label>
        </div>
        <div class="small-9 columns">
          <input type="password" id="password" name="password" placeholder="fjalkalimi">
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="small-2 small-centered columns">
      <div class="row">
       
        <div class=" centered small-9 columns">
          <input class="button" type="submit" id="admin_login" name="admin_login" value="Login"/>
        </div>
      </div>
    </div>
  </div>

</form>

<?php require_once('template/_footer.php'); ?>