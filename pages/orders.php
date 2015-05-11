<?php

Login::restrictFront();

$objOrder = new Order();
$orders = $objOrder->getClientOrders(Session::getSession(Login::$_login_front));


$objPaging = new Pagination($orders, 5);

$rows = $objPaging->getRecords();


require_once('_header.php');
?>


<h1>My orders</h1>

<?php if(!empty($rows)) {?>

	
	<table cellspacing="0" cellpadding="0" border="0" class="tbl_repeat">
		<tr>
			<th>Id</th>
			<th>Date</th>
			<th>Status</th>
			<th>Total</th>
			<th>Invoice</th>
		</tr>

		<?php  foreach ($rows as $row) { ?>
			<tr>
				<td><?php echo $row['id'] ?></td>
				<td><?php echo Helper::setDate(1, $row['date']) ?></td>
				<td>
					<?php $status = $objOrder->getStatus($row['status']);
					echo $status['name'];
					 ?>
				</td>
				<td>&euro;<?php echo number_format($row['total'],2); ?></td>
				<td>
					<?php 
					if ($row['pp_status'] == 1) {
						 echo '<a href="?page=invoice&amp;id=';
						 echo $row['id'];
						 echo '" target="new">Invoice</a>';
					}  else {
						echo '<span>Inavtive</span>';
					} 
					?>
				</td>

			</tr>
		<?php }?>

	</table>

	<?php echo $objPaging->getPagination(); ?>

<?php } else { ?>

<p>Currently you don not have any orders</p>
<?php } ?>

<?php require_once('_footer.php') ?>