<?php
require_once('Databases.php');
session_start();
$error='';
if(isset($_POST['login']))
{
	//verificam daca exista campuri necompletate
	if(empty($_POST['user'])||empty($_POST['pass'])){
		$error="Nu ati completat username-ul sau parola.";
	}
	//verificam daca username-ul este valid
	else if(!preg_match("/^[a-zA-Z0-9_]{1,50}$/",$_POST['user']))
		{$error="Username-ul nu este valid.";}
		//varificam daca parola este valida
		else if(!preg_match("/^[a-zA-Z0-9!=@#%^*?_~+]{1,50}$/",$_POST['pass']))
		{$error="Parola nu este valida.";}
	else
	{
		//cautam utilizatorul in baza de date
		$interogare = "SELECT * FROM viewLogin WHERE username = '".stripslashes($_POST['user'])."' and pachet.returneazaParola(userid) ='".hash('sha256', stripslashes($_POST['pass']))."'";
		$bazaDeDate->querySelect($interogare);
		//actualizam variabilele de sesiune precum avatarul, id-ul userului curent
		if($bazaDeDate->numRow()==1)
		{
			foreach ($bazaDeDate->rows() as $key) {
				 $_SESSION['USERID'] = $key['USERID'];
				 if(isset($key['AVATAR']))
				 {
				 	$_SESSION['AVATAR'] = $key['AVATAR'];
				 }
				 else
				 {
				 	$_SESSION['AVATAR']='img/cris/user_logo.png';
				 }

				 $_SESSION['login_user']=$key['NUME'].'<br>'.$key['PRENUME'];
			}
			//facem un update in tabela logarilor recente ale utilizatorului
			$_SESSION['USERNAME']=$_POST['user'];
			$bazaDeDate->uploadIstoricLogin($_SESSION['USERID'],$_SERVER['HTTP_USER_AGENT'],$ip,date("F j, Y").'<br>'.date("g:i a"));
		    $_SESSION['PAROLA']=hash('sha256', stripslashes($_POST['pass']));			
			  header("location: user_panel.php");
		}
		else{
			$error="Datele introduse sunt gresite.";
		}
	}
}
?>