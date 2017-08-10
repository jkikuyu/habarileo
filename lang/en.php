<?php

$lang["pagetitle"] = "Welcome to Habari Leo";
$lang["username"] = "Username";
$lang["password"] = "Password";
$lang["savedetails"] = "Save Details";
$lang["copyright"] = "Copyright &copy; " . date("Y") . " - BBIT3104";
$lang["table_name"] = $_SESSION["table_name"];
$lang["group_name"] = ucwords(strtolower(str_replace( '_' , ' ' , $lang["table_name"] )));
$lang["table_title"] = $lang["group_name"] . " Table List";



?>
