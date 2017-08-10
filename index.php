<?php
	session_start();
	require_once "classes/classesAutoload.php";
	if (isset($_POST["username"])){	
		$success = $objLogin->checkValidUser($MYSQL);
		if ($success){

			$objLayout->head();
			$objLayout->body_open();
			$objLayout->list_container();
			//$objLayout->user_lists();
			$objLayout->footer();
		}
		else{
			$objLogin->show_login();
			//$objLayout->errorMessage("error");
		}
	}
	else{

		$objLogin->show_login();


	}
?>
 