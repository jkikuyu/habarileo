<?php
	session_start();
	require_once "classes/classesAutoload.php";

	if (isset($_POST["username"])){	
		$success= $objLogin->checkValidUser($MYSQL);
		if ($success){
				$objLayout->head();
				$objLayout->body_open();

			switch($_SESSION["userId"]){
				case 1:
				$objLayout->admin_container(1);
				break;
				case 2:

			}  
			$objLayout->footer();			
			//$objLayout->user_lists();
			
		}
		else{
			$objLogin->show_login();
			//$objLayout->errorMessage("error");
		}
	}
	elseif (isset($_SESSION["username"])){
		$objLayout->head();
		$objLayout->body_open();

		switch ($_SESSION["username"]){
			case 'admin':
				$objLayout->admin_container(1);
			break;

		}
	}
	else{

		$objLogin->show_login();
	}
	

?>
 