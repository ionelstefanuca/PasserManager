<?php
require_once('Databases.php');
session_start();
$error='';
if(isset($_POST['register'])){
	if(empty($_POST['userreg'])||empty($_POST['passreg'])||empty($_POST['confpass'])){
		$error="Toate campurile marcate cu * trebuie completate.";
	}
	else if(!isset($_POST['agreetoterms']))
		{$error="Trebuie marcata casuta!.";}
		else{
		$pass=$_POST['passreg'];
		$confpass=$_POST['confpass'];
		if($pass!=$confpass)
		{
			$error="Parolele nu coincid.";
		}
		else{
	
			if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
			{
				//verificam daca emailul sau userul este in baza de date
				$interogare = "SELECT email FROM utilizatori WHERE email = '".$_POST['email']."'";
				$bazaDeDate->querySelect($interogare);
				
				if($bazaDeDate->numRow()!=0)
				{
					$error='Acest email este folosit de alt utilizator';
				}
				else 
				{
					
					if (preg_match('/^[A-Za-z]{1}[A-Za-z0-9]{5,31}$/', $_POST['userreg']))
						{
							$interogare = "SELECT username FROM utilizatori WHERE username = '".stripslashes($_POST['userreg'])."'";
							$bazaDeDate->querySelect($interogare);
							
							if($bazaDeDate->numRow()!=0)
							{
								$error='Nu poti folosi acest username';
							}
							else
							{
								//completam noile date in baza de date
								//parola va fi criptata cu sha256
								
								$continent  = isset($_POST['reg_select']) ? stripslashes($_POST['reg_select']) : '';
							    $interogare="INSERT INTO utilizatori VALUES (null, '".stripslashes($_POST['userreg'])."', TabelaParole(infoModificari(1,'".hash('sha256', stripslashes($_POST['passreg']))."')), '".stripslashes($_POST['firstname'])."', '".stripslashes($_POST['lastname'])."', '".stripslashes($_POST['email'])."', '".stripslashes($_POST['zipcode'])."', sysdate,null, '".stripslashes($continent)."',TabelaIstoricLogin(istoricLogin(1,'".$_SERVER['HTTP_USER_AGENT']."','".$ip."','".date("F j, Y").'<br>'.date("g:i a")."')))";
								if($bazaDeDate->queryInsert($interogare))
								{
									//Am creat contul
									//$_SESSION['login_user']=$_POST['userreg'];
									//header("location: ../user_panel.php");
									
									$error="<p style=\"color: rgb(139, 224, 245);font-size: 25px;font-family: cursive;\">Ai creat cu succes contul</p>";
								}
								else
								{
									$error="Nu am putut crea contul";	
								}
							}
						}
						else
						{
							$error="Acest username nu este valid; Trebuie sa aiba lunimea minima de 6 caractere.";
						}
				}
			}
			else
			{
				$error="Email-ul introdus nu este valid";
			}	
		}
	}
}
?>