<?php
	session_start();
	require_once "classes/classesAutoload.php";
	
	list($select_user, $spot_select_user) = $ObjProc->spot_user_list($MYSQL);

	$ObjUdis->grid_fetch($spot_select_user, $select_user, $MYSQL);

?>