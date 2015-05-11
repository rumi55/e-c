<?php

class Cart
{

	public $_instanc_catalogue;
	public $_empty_cart;
	public $_vat_rate;
	public $_number_of_items;
	public $_sub_total;
	public $_vat;
	public $_total;

	public function __construct()
	{
		$this->_instanc_catalogue= new Catalogue();
	    $this->_empty_cart=	empty($_SESSION['cart']) ? true : false;

		$objBusiness = new Business();
		$this->_vat_rate = $objBusiness->getVatRate();

		$this->numberOfItems();
		$this->subTotal();
		$this->vat();
		$this->total();

	}

	public function numberOfItems()
	{
		$value=0;
		if (!$this->_empty_cart)
		{
			foreach ($_SESSION['cart'] as $key => $cart) {
					$value +=$cart['qty'];
				}	
		}
		$this->_number_of_items=$value;
	}

	public function subTotal()
	{
		$value=0;
		if (!$this->_empty_cart)
		{
			foreach ($_SESSION['cart'] as $key => $cart) {
					$product = $this->_instanc_catalogue->getProduct($key);
					
					if($cart['qty']>$product['qty_p_discount'])
					{
					    $discount = $product['price']*($product['discount_product']/100);
						$value +=($cart['qty']*($product['price']-$discount));
					} else {
						 $value +=($cart['qty']*$product['price']);

						
					}

					
				}
		}
		$this->_sub_total=round($value,2);  
	}
	
	public function vat()
	{
		$value=0;
		if (!$this->_empty_cart)
		{
			$value=($this->_vat_rate*($this->_sub_total / 100));
		}
		$this->_vat=round($value,2);  
	}

	public function total()
	{
		$this->_total=round($this->_sub_total + $this->_vat,2);
	}

	public static function activeButton($session_id)
	{

		if(isset($_SESSION['cart'][$session_id]))
		{
			$id=0;
			$label="Largo nga shporta";
		} else {
			$id=1;
			$label="Shto ne shport";
		}

		$out="<a href=\"#\" class=\"shto_ne_shport";
		$out .= $id == 0 ?" red" : null;
		$out .= "\" rel = \"";
		$out .= $session_id."_".$id;
		$out .= "\">{$label}</a>";

		return $out;
	}


	public function itemTotal($price=null, $qty= null)
	{
		if(!empty($price) && !empty($qty))
		{
			return round(($price * $qty),2);
		}

	}

	public static function removeButton($id=null)
	{
		if(!empty($id))
		{
			if(isset($_SESSION['cart'][$id]))
			{
				$out = "<a href=\"#\" class=\"remove_cart red";
				$out .="\" rel=\"{$id}\">Largo</a>";
				return $out;
			}
		}
	}


}

?>