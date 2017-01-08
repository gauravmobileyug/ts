<?php 

if(isset($_REQUEST['cmd']) && $_REQUEST['cmd'] == 'ok'){
	
}

require_once('leavecrone.php');

$crone = new LeaveCrone();

$crone->run_leave_crone();




die("Successfully Run");

?>