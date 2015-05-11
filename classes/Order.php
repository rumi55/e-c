<?php

class Order extends Database {


	private $_table = 'orders';
	private $_table_2 = 'orders_items';
	private $_table_3 = 'statuses';

	private $_cart = array();

	private $_items = array();

	private $_fields = array();
	private $_values = array();


	public $_id = null;





	public function getItems()
	{
		$this->_cart = Session::getSession('cart');
		if (!empty($this->_cart)) {
			$objCatalogue = new Catalogue();
			foreach ($this->_cart as $key => $value) {
				$this->_items[$key] = $objCatalogue->getProduct($key);
			}
		}
	}


	public function createOrder()
	{
		$this->getItems();

		if (!empty($this->_items)) {
			$objUser = new User();
			$user = $objUser->getUser(Session::getSession(Login::$_login_front));
		
		
			if (!empty($user)) {
				
				$objCart = new Cart();

				//$this->_fields[] = 'client';
				$order['client'] = $user['id'];
				
				//$this->_fields[] = 'vat_rate';
				$order['vat_rate'] = $objCart->_vat_rate;

				//$this->_fields[] = 'vat';
				$order['vat'] = $objCart->_vat;

				//$this->_fields[] = 'subtotal';
				$order['subtotal'] = $objCart->_sub_total;

				//$this->_fields[] = 'total';
				$order['total'] = $objCart->_total;

				//$this->_fields[] = 'date';
				$order['date'] = Helper::setDate();

				
			

				$sql = "INSERT INTO `{$this->_table}` (`client`, `vat_rate`, `vat`, `subtotal`, `total`, `date`)

				VALUES (:client, :vat_rate, :vat, :subtotal, :total, :date)";

				$this->_id = $this->insertOrder($sql,$order);

				
				
				if (!empty($this->_id)) {
					
					return $this->addItems($this->_id);
				}

			}

			return false;
		}

		return false; 
	}


	public function addItems($order_id = null)
	{

		if (!empty($order_id)) {	


			$error = array();
			foreach ($this->_items as $item) {
		
				$params['order'] 		= $order_id;
				$params['products']		= $item['id'];
				$params['price']		= $item['price'];
				$params['qty'] 			= $this->_cart[$item['id']]['qty'];

				$sql ="INSERT INTO `{$this->_table_2}` (`order`, `products`, `price`, `qty`)
				VALUES (:order, :products, :price, :qty)";

				if (!$this->insertOrderdb($sql,$params)) {
				 	 $error[] = $sql;

				 }

			}

			return empty($error) ? true : false;

		}
		return false;

	}


	public function getOrder($id = null)
	{
		$id = !empty($id) ? $id : $this->_id;

		$sql = "SELECT * FROM `{$this->_table}` WHERE `id` = {$id} ";

		return $this->single($sql);
	}


	public function getOrderItems($id = null)
	{
		$id = !empty($id) ? $id : $this->_id;
		$sql = "SELECT * FROM `{$this->_table_2}` WHERE `order` = {$id} ";
		return $this->resultset($sql);
	}


	public function approve($txn_id = null, $payment_status = null, $id = null)
	{
		if (!empty($txn_id) && !empty($payment_status) && !empty($id)) {
			
			$active = $payment_status == 'Completed' ? 1 : 0;

			$sql = "UPDATE `{$this->_table}` SET `pp_status` = :pp_status, `txn_id` = :txn_id, `payment_status` = :payment_status
			WHERE `id` = {$id} ";

			$this->updatePayment($sql,$txn_id, $payment_status);
		}
	}


	public function getClientOrders($id = null)
	{
		if (!empty($id)) {
			
			$sql = "SELECT * FROM `{$this->_table}` WHERE `client` = {$id} ORDER BY `date` DESC";

			return $this->resultset($sql);
		}
	}

	public function getStatus($id = null)
	{
		if (!empty($id)) {
			$sql = "SELECT * FROM `{$this->_table_3}` WHERE `id` = {$id}";
			return $this->single($sql);
		}
	}

}