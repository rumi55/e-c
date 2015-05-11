<?php 
require_once('_header.php');

$objFrom = new Form();

?>

<h1>Arka</h1>

<p>Ju lutemi plotesoni te dhenat tuaja dhe klikoni <a href="#"><strong>KETU</strong></a></p>


<form action="" method="post">
	<table>
		<tr>
			<th><label for="firstname">Emri*</label></th>
			<td><input type="text" name="firstname" id="firstname" value="<?php echo $objFrom->formText('firstname'); ?>"/></td>
		</tr>
		<tr>
			<th><label for="lastname">Mbiemri*</label></th>
			<td><input type="text" name="lastname" id="lastname" value="<?php echo $objFrom->formText('lastname'); ?>"/></td>
		</tr>
		<tr>
			<th><label for="address">Adresa*</label></th>
			<td><input type="text" name="address" id="address" value="<?php echo $objFrom->formText('address'); ?>"/></td>
		</th>
		<tr>
			<th><label for="city">Qyteti*</label></td>
			<td><input type="text" name="city" id="city" value="<?php echo $objFrom->formText('city'); ?>"/></td>
		</tr>
		<tr>
			<th><label for="country">Shteti*</label></th>
			<td>
				<?php  echo $objFrom->selectCountry(); ?>
			</td>
		</tr>
		<tr>
			<th><label for="lastname">E-mail*</label></th>
			<td><input type="email" name="email" id="email" value="<?php echo $objFrom->formText('email'); ?>"/></td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td><label for="btn"><input type="submit" id="btnSubmit" name="btnSubmit" value="Vazhdo"></td>

	</table>

</form>

<?php require_once('_footer.php'); ?>