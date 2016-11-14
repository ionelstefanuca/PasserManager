<?php
require_once('Databases.php');

	if(isset($_POST['codParolaSterge']))
	{
		$interogare = "DELETE FROM userpasswords WHERE pid=".$_POST['codParolaSterge']." AND userid=".$_SESSION['USERID'];
		$bazaDeDate->queryInsert($interogare);
	}
?>