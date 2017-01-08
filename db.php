<?php
$db['default'] = array(   
	'dsn' => '',
    'hostname' => 'localhost', 
	'username' => '', 
	'password' => '', 
	'database' => '',
    'dbdriver' => 'mysqli', 
	'dbprefix' => 'ems',
    'pconnect' => FALSE,  
	//'db_debug' => (ENVIRONMENT !== 'production'), 
	'cache_on' => FALSE,  
	'cachedir' => '', 
	'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci', 
	'swap_pre' => '', 
	'encrypt' => FALSE,  
	'compress' => FALSE,  
	'stricton' => FALSE,  
	'failover' => array(), 
	'save_queries' => TRUE
);
return $db;

?>
