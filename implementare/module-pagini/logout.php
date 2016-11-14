<?php
require_once('Databases.php');
$bazaDeDate->disconnnectFromDB();

session_start();
	if(session_destroy()) // Destroying All Sessions
	{
		header("Location: ../login.php"); // Redirecting To Home Page
	}
?>