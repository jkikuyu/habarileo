<?php
	session_start();
	require_once "classes/classesAutoload.php";
	
	list($select_user, $spot_select_user) = $ObjProc->user_list($MYSQL);

	$ObjUdis->list_fetch($select_user, $MYSQL);
?>
