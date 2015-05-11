<?php


require_once('config.php');

/*
The function __autoload is for calling the calsses in 
this case when we have to much classes in the same path "Classes"
*/
function __autoload($class_name)
{
	 $class=explode("_",$class_name);
        
	 $path=implode("/", $class).".php";
     require_once($path);
	//require_once('classes/'.$class_name.'.php');
}

?>