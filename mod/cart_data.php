
<?php

require_once('../inc/autoload.php');

$objCart = new Cart();
$out = array();

$out['shm_np']= $objCart->_number_of_items;
$out['shm_pt']=number_format($objCart->_sub_total,2);
$out['shm_tvsh']=number_format($objCart->_vat,2);
$out['shm_total']=number_format($objCart->_total,2);
echo json_encode($out);
?>