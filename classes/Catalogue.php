<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Catalogue extends Database {
    
    private $_table = 'categories';
    private $_table_2= 'products';
    public $_path = 'media/catalogue/';
    public static $_currency='&euro;';
    public $_id;
     
   
    /* The function that will get all categories */
    public function getAllCategories(){
       
        $sql="SELECT * FROM `{$this->_table}` ORDER BY `name` ASC";
        return $this->resultset($sql);
    }

    /* This function will get the category with specific Id */
    public function getCategory($id)
    {
        $sql = "SELECT * FROM `{$this->_table}`  WHERE `id` = {$id} ";
        return $this->single($sql);
    }


    public function addCategory($name=null)
    {
        if(!empty($name))
        {
             $sql  = "INSERT INTO `{$this->_table}` (name) VALUES (:name) ";
             return $this->insCategory($sql,$name);
        }
       
    }

    public function duplicateCategory($name=null, $id=null)
    {
        if(!empty($name))
        {
            $sql= "SELECT * FROM `{$this->_table}` WHERE `name` = '{$name}'";
            
            $sql .= !empty($id) ? " AND `id` != {$id}" : null;

            $result= $this->resultset($sql);
            
            return empty($result) ? true : false;
        }

        return false;
    }

    public function editCategory($name=null, $id=null)
    {
        if(!empty($name) && !empty($id))
        {
            $sql="UPDATE `{$this->_table}` SET `name` = :name WHERE `id`=:id";
            return $this->updateCategory($sql,$name,$id);
        }
        return false;
    }

    public function deleteCategory($id)
    {
        $sql = "DELETE FROM `{$this->_table}` WHERE `id` = {$id} ";
        return $this->delete($sql); 
    }
    
    public function getProducts($cat){
        $sql = "SELECT * FROM `{$this->_table_2}`
        WHERE `category` = '".$cat."' ORDER BY `date` DESC";
        return $this->resultset($sql);
    }

    public function getProduct($id){
        $sql = "SELECT * FROM `{$this->_table_2}`
        WHERE `id` = ".$id;
        return $this->single($sql);
    }

    public function getAllProducts($limit=null)
    {
        if (empty($limit)) {
             $sql = "SELECT * FROM `{$this->_table_2}`";
        } else {
            $sql = "SELECT * FROM `{$this->_table_2}`  ORDER BY `id` DESC limit $limit";
        }
        
        return $this->resultset($sql);
    }


    public function addProduct($params=null)
    {
        if(!empty($params))
        {
            $params['date']=date('YmdHis',time());
           
            $sql= "INSERT INTO `{$this->_table_2}` (category,name,description,price,date,sasia_po,zbritja) VALUES (:category,:name,:description,:price,:date,:sasia_po,:zbritja)";
            $result= $this->insert($sql,$params);
            
           
            $this->_id = $result;
            return true;
        }
        return false;
    
    }


    public function updateProduct($params=null,$id=null)
    {
        if(!empty($params) && !empty($id))
        {
            $sql = "UPDATE `{$this->_table_2}` SET `image` = :image WHERE `id`={$id}";
            //$params permban vleren e iamzhit ne string
            return $this->update($sql,$params);
        
        }

        return false;
    }

    public function editProduct($params=null,$id=null)
    {
        if(!empty($params) && !empty($id))
        {
            $params['date']=date('YmdHis',time());
            $sql = "UPDATE `{$this->_table_2}` SET `category` = :category, 
            `name`=:name, `description`=:description, `price`=:price, `date`=:date WHERE `id`={$id}";
            return $this->ndryshoProduktin($sql,$params);
        }
    }

    public function deleteProduct($id)
    {
        if(!empty($id))
        {
            $product = $this->getProduct($id);
            if(!empty($product))
            {
                if(is_file(CATALOGUE_PATH.DS.$product['image']))
                {
                    unlink(CATALOGUE_PATH.DS.$product['image']);
                }

                 $sql = "DELETE FROM `{$this->_table_2}` WHERE `id` = {$id}";
             return $this->delete($sql);
            }

            return false;
            
        }

        return false;
       
    }

    public function randomProduct($id,$cat)
    {
        $sql = "SELECT * FROM `{$this->_table_2}` WHERE `id` != :id AND  `category` = :cat";

        return $this->dis($sql,$id,$cat);


    }

}
?>
