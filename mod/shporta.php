<!-- Shporta -->
<?php $objCart = new Cart(); ?>
<h2>Shporta juaj</h2>
<dl id="shporta">
	<dt>Numri i produkteve</dt>
	<dd class="shm_np"><span><?php echo $objCart->_number_of_items; ?></span></dd>
	<dt>Pa tvsh: </dt>
	<dd class="shm_pt">&euro;<span><?php echo number_format($objCart->_sub_total,2); ?></span></dd>
	<dt>TVSH (<span><?php echo $objCart->_vat_rate; ?></span> % ): </dt>
	<dd class="shm_tvsh">&euro;<span><?php echo number_format($objCart->_vat,2); ?></span></dd>
	<dt>Total (inc):</dt>
	<dd class="shm_total">&euro;<span><?php echo number_format($objCart->_total,2); ?></span></dd>
</dl>
<div class="dev shd_td">&#160;</div>
<p><a href="?page=shopingcart">Shiko Shporten</a> | <a href="?page=paypal">Proceso blerjen</a></p>
<p><a href="?page=checkout">Checkout</a> </p>
<div class="dev shd_td">&#160;</div>