<?php

session_start();
$user_check=$_SESSION['login_user'];

$login_session=$user_check;
if(!isset($login_session))
{
	header('Location: ../login.php');
}

?>