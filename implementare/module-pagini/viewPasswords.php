<?php
require_once('Databases.php');

$eroareGrupare='';

	if(isset($_POST['grupareParole'])){
		if(empty($_POST['tarieP'])||empty($_POST['frecventaUtilizare'])||empty($_POST['domeniuSite']))
		{
			  $eroareGrupare='Toate campurile gruparii trebuie completate';
			  echo $eroareGrupare;

			  unset($_SESSION['grupare']);
			  header("location: viewPasswords.php");
		}
		else
		{
			 $_SESSION['grupare'] = 'da';
			 $_SESSION['tarieParola'] = $_POST['tarieP'];
			 $_SESSION['frecventaUtilizare'] = $_POST['frecventaUtilizare'];
			 $_SESSION['domeniuSite'] = $_POST['domeniuSite'];
			 header("location: viewPasswords.php");
		}
	}  //end grupare parole

	if(isset($_POST['codParolaSterge']))
	{
		$interogare = "DELETE FROM userpasswords WHERE pid = ".$_POST['codParolaSterge']." and userid=".$_SESSION['USERID'];

		$bazaDeDate->queryInsert($interogare);
	}
?>

