<?php
	session_start();
	require_once "classes/classesAutoload.php";

	
	$pers_to_edit = $objProc->get_edit_user($MYSQL);
	
	//$ObjProc->update_user_details($MYSQL);
	
	$objLayout->head();
	$objLayout->body_open();
	
	$objForm->registration_form($pers_to_edit);
	$objLayout->footer();
?>