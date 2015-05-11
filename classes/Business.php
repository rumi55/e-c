<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Business extends Database{
    
    private $_table ="business";
    
    public function getBusiness()
    {
       $sql="SELECT * FROM `{$this->_table}` where `id`=1";
       return $this->single($sql);
    }
    
    public function getVatRate(){
        $business=$this->getBusiness();
        return $business['vat_rate'];
    }
    
}

?>
