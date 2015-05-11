<?php

class DataBase
{
	/* The $_dsn variable will get the specific database in this case MYSQL */
	private $_dsn="mysql:host=localhost;dbname=ecommerce";
	/* mysql username */
	private $_user = "root";
	/* mysql password */
	private $_password = "";
	
	private $_options = array(
            PDO::ATTR_PERSISTENT    => true,
            PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
        );
    private $db=false;   
	
	public $_last_query = null;
	public $_affected_rows = 0;

	public $_insert_keys = array();
	public $_insert_values = array();
	public $_update_sets = array();

	public $_id;

	/*The constructer with no parameters of the class DataBase */
	public function __construct()
	{
		$this->connect();

	}

	/*This function will connect with db and output any error if exsts
		@$db the connection will be save in this parameter
	 */
	private function connect()
	{
		try {
			$this->db = new PDO($this->_dsn, $this->_user, $this->_password, $this->_options);
              
		} catch (Exception $e) {
			echo "Database connection failed: ".$e->getMessage(); 
		}
		
	}
       
    /* The Result Set function returns an array of the result set rows from specific sql query.
       It uses the PDOStatement::fetchAll PDO method.
       First we run the execute method, then we return the results.*/         
    public function resultset($param)
    {         
             $stmt=$this->db->prepare($param);
             $stmt->execute();
             $result= $stmt->fetchAll(PDO::FETCH_ASSOC);
             return $result;
    }


    /* The Single method simply returns a single record from the database from tpecific sql query saved in $param variable.
       First we run the execute method, then we return the single result.
       This method uses the PDO method PDOStatement::fetch.*/
    public function single($sql)
    {
        	
            $stmt=$this->db->prepare($sql);

            $stmt->execute();
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            return $result;

    }


    public function dis($sql,$id,$cat)
    {
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->bindParam(':cat',$cat);
        $stmt->execute();
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

   public function updateCategory($sql,$name,$id)
   {
        $stmt=$this->db->prepare($sql);
        $stmt->bindParam(':name',$name); 
        $stmt->bindParam(':id',$id, PDO::PARAM_INT);    // <-- Automatically sanitized by PDO
        $result=$stmt->execute();

        return !empty($result) ? true : false;
   }

    public function validAdmin($sql,$param1,$param2)
    {
    	$stmt = $this->db->prepare($sql);
    	$stmt->execute(array('name'=>$param1,'password'=>$param2));
    

    	$result=$stmt->fetch(PDO::FETCH_ASSOC);
    	return $result;
    	

    }

    public function validUser($sql,$email,$password)
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array('email'=>$email,'password'=>$password));
    

        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
        

    }


    public function insert($sql,$params)
    {
    	if(!empty($params))
    	{
	    	$stmt=$this->db->prepare($sql);
	    	$stmt->execute(array(
                'category'=>$params['category'],
                'name'=>$params['name'],
	    		'description'=>$params['description'],
                'price'=>$params['price'],
                'date'=>$params['date'],
                'sasia_po'=>$params['sasia_per_oferte'],
                'zbritja'=>$params['zbritja']
                ));
	    	if($stmt)
	    	{
	    		$this->_id=$this->idFundit();
	    		return $this->_id;
	    	}
    	}
    
    }



    public function insertOrder($sql,$params)
    {
        if(!empty($params))
        {
            $stmt=$this->db->prepare($sql);
            $stmt->execute(array(
                'client'    =>$params['client'],
                'vat_rate'  =>$params['vat_rate'],
                'vat'       =>$params['vat'],
                'subtotal'  =>$params['subtotal'],
                'total'     =>$params['total'],
                'date'      =>$params['date']
                ));
            if($stmt)
            {
                $this->_id=$this->idFundit();
                return $this->_id;
            }
        }
    
    }


    public function insertOrderdb($sql= null, $params = null)
    {
        if (!empty($params)) {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                'order'     => $params['order'],
                'products'  => $params['products'],
                'price'     => $params['price'],
                'qty'       => $params['qty']
                ));

            if ($stmt) {
                return true;

            }
            return false;
        }
    }


    public function insertUser($sql,$params)
    {
        if(!empty($params))
        {
            $stmt=$this->db->prepare($sql);
            $stmt->execute(array(

                'first_name' => $params['first_name'],
                'last_name'  => $params['last_name'],
                'address_1'  => $params['address_1'],
                'address_2'  => $params['address_2'],
                'town'       => $params['town'],
                'county'     => $params['address_2'],
                'post_code'  => $params['post_code'],
                'country'    => $params['country'],
                'email'      => $params['email'],
                'password'   => $params['password'],
                'date'       => $params['date'],
                'hash'       => $params['hash']

               
                ));
            if($stmt)
            {
                //$this->_id=$this->idFundit();
                return true;
            }
        }
    
    }


    public function updateUserActive($sql,$id)
       {
            $stmt=$this->db->prepare($sql);
           
            $stmt->bindParam(':id',$id, PDO::PARAM_INT);    // <-- Automatically sanitized by PDO
            $result=$stmt->execute();

            return !empty($result) ? true : false;
       }



    public function dbupdateUser($array = null, $sql = null)
    {
        if (!empty($array))
        {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':first_name',$array['first_name']);
            $stmt->bindParam(':last_name',$array['last_name']);
            $stmt->bindParam(':address_1',$array['address_1']);
            $stmt->bindParam(':address_2',$array['address_2']);
            $stmt->bindParam(':town',$array['town']);
            $stmt->bindParam(':county',$array['county']);
            $stmt->bindParam(':post_code',$array['post_code']);
            $stmt->bindParam(':country',$array['country']);
            $stmt->bindParam(':email',$array['email']);

            $stmt->execute();
            return true;

        }

        return false;
    }




    public function insCategory($sql=null,$name)
    {
        if(!empty($sql))
        {

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':name',$name);    
            $stmt->execute();
            return true;
        }
        return false;
    }

    public function update($sql,$param=null)
    {
    	if(!empty($param))
    	{

     	$stmt = $this->db->prepare($sql);
    	$stmt->execute(array('image'=>$param['image']));

    	return true;
    	}

    	return false;
    }

    public function ndryshoProduktin($sql,$params=null)
    {
    	if (!empty($params))
    	{
    		$stmt = $this->db->prepare($sql);
    		$stmt->bindParam(':category',$params['category']);
    		$stmt->bindParam(':name',$params['name']);
    		$stmt->bindParam(':description',$params['description']);
    		$stmt->bindParam(':price',$params['price']);
    		$stmt->bindParam(':date',$params['date']);

    		$stmt->execute();
    		return true;

    	}

    	return false;
    }


    public function delete($sql=null)
    {
    	if(!empty($sql))
    	{
    		$stmt=$this->db->prepare($sql);
    		$stmt->execute();
    		return true;
            
    	}

    	return false;
    }

    public function idFundit()
    {
    	return $this->db->lastInsertId(); 
    }

	/*This funciton will close the connection with database*/
	public function close()
	{
		$dbh=null;
	}





    //prepare params
    public function prepareInsert($array = null)
    {
        if (!empty($array)) {
            foreach ($array as $key => $value) {
                $this->_insert_keys[] = $key;
                $this->_insert_values[] = $value;
            }
        }
    }


}



?>