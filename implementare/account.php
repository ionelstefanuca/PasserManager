<?php 
require_once('module-pagini/Databases.php');

$title='DashBoard';
$meniuLabel = 'User Panel > My account';
require_once('module-pagini/dashboard-head.php'); 

$valoare ="test";

$mesajSchimbar=" ";

if(isset($_POST['updateAccount']))
{
	$oldpassword =$_POST['oldpassword'];
	$newpassword = $_POST['newpassword'];
	$confirm_password = $_POST['confirm_password'];

	if($newpassword != $confirm_password)
	{
		$mesajSchimbar="Cele doua parole nu corespund!"	;
	}
	else
	{
		if(hash('sha256', stripslashes($oldpassword))!=$_SESSION['PAROLA'])
		{
			$mesajSchimbar="Parola veche este gresita";
		}
		else
		{
			if($bazaDeDate->queryBLOCK($_SESSION['USERID'],hash('sha256', stripslashes($newpassword)))=='da')
			{
				$mesajSchimbar="<span style= \"color: rgb(47, 23, 255);\">Parola a fost schimbata cu succes</span>";
				$_SESSION['PAROLA']=hash('sha256', stripslashes($newpassword));
			}
			else
			{
				$mesajSchimbar="<span>Ai mai avut aceasta parola. Din motive de securitate parolele trebuie sa fie diferite.</span>";
			}
		}
	}
}


if(isset($_POST['uploadImage']))
{
	$arrayTest = @getimagesize($_POST['urlImg']);
	if(is_array($arrayTest)===true)
	{
	$urlImg = $_POST['urlImg'];
	$esteOK = true;
	$interogare= "select avatar
				  from utilizatori
				  where userid=".$_SESSION['USERID'];

	$bazaDeDate->querySelect($interogare);			  
	foreach ($bazaDeDate->rows() as $key) {
		if($key['AVATAR']!=$_SESSION['AVATAR'])
				$esteOK = false;

		if($_SESSION['AVATAR']=='img/cris/user_logo.png')	
				$esteOK = true;
	}

	if($esteOK)
				{
					$interogare =  "update utilizatori
								set avatar ='".$urlImg."' where userid = ". $_SESSION['USERID'] ;
						
						if($bazaDeDate->queryInsert($interogare))
						{
							$_SESSION['AVATAR']=$urlImg;
							$mesajSchimbar="<span>Adresa URL a fost actualizata</span>";
							header("location: account.php");
						}
				}
				else
				{
					$mesajSchimbar="Tranzactie: datele nu sunt actualizate";
				}	
	}
	else
	{
		$mesajSchimbar="Linkul nu duce catre o imagine.";
	}
}


/*******************************/
$bazaDeDate->querySelect("SELECT nume, prenume, email FROM utilizatori WHERE userid=".$_SESSION['USERID']);
	if($bazaDeDate->numRow()==1)
	{
			foreach ($bazaDeDate->rows() as $key) 
			{
				 $oldNume = $key['NUME'];
				 $oldPrenume = $key['PRENUME'];
				 $oldEmail = $key['EMAIL'];
			}
	}



if(isset($_POST['updateDiverse']))
{
	if($bazaDeDate->queryInsert("UPDATE utilizatori SET nume='".$_POST['newNume']."', prenume ='".$_POST['newPrenume']."'  WHERE userid=".$_SESSION['USERID']))
	{
		$_SESSION['login_user']=$_POST['newNume'].'<br>'.$_POST['newPrenume'];
	}
	
	if (!filter_var($_POST['newEmail'], FILTER_VALIDATE_EMAIL) === false) 
	{
		$bazaDeDate->querySelect("SELECT email FROM utilizatori WHERE email = '".$_POST['newEmail']."'");
		if($bazaDeDate->numRow()!=0)
		{
			$mesajSchimbar='Acest email este deja folosit.';
		}
		else 
		{
			if($bazaDeDate->queryInsert("UPDATE utilizatori SET email='".$_POST['newEmail']."' WHERE userid=".$_SESSION['USERID']))
			{
				//$mesajSchimbar.="Email-ul a fost actualizat.";
				header("location: account.php");
			}
		}
	}
	
}



?>

<div id="continut">
		<div id="titlu-continut">
			<h3><?php echo $meniuLabel;?></h3>
		</div>

		<div id="body-continut">
				<?php if($mesajSchimbar !=' ') echo "<div id=\"mesajSchimbare\"><p>".$mesajSchimbar."</p></div>";?>
					
<div id="wrapStanga">		


			<div id="schimbaParola">
					<h3>Modifica Parola</h3>
					<div id="euSepar"></div>
					
					<form action="account.php" method="POST">
						
						<input type="password" name="oldpassword" placeholder="Old Password">
						
						<input type="password" name="newpassword" placeholder="New Password">

						<input type="password" name="confirm_password" placeholder="Confirm Passord">

						<div id="euSepar"></div>
					
	                    <input name="updateAccount" type="submit" value="Save Account Changes" onclick="if(!confirm('Are you sure you want to update account?')) return false;" alt="Save Account Changes">
	                    	
					</form>	
					
			</div>


			
			<div id="schimbaImagine">
					<h3>Modifica Avatarul</h3>
					<div id="euSepar"></div>
					
					<form action="account.php" method="POST">
	                   
							<label>Link Avatar<input type="text" value="<?=$_SESSION['AVATAR'];?>" name="urlImg"></label>

							<div id="euSepar"></div>
							
	                    	<input name="uploadImage" type="submit" value="Upload Image">

					</form>	
			</div>	

</div><!--wrapStanga-->
			
<div id="wrapDreapta">


			<div id="schimbaDatele">
					<h3>Modifica Datele</h3>
					<div id="euSepar"></div>
					
					<form action="account.php" method="POST">
							
							<label>Current Username<input type="text" name="newNume" value="<?php echo $oldNume;?>"></label>
									
							<label>Current Name<input type="text" name="newPrenume" value="<?php echo $oldPrenume;?>"></label>
	                    				
							<label>Current Email<input type="email" name="newEmail" value="<?php echo $oldEmail;?>"></label>

							<div id="euSepar"></div>
	                    		
	                    	<input name="updateDiverse" type="submit" value="Update Diverse" onclick="if(!confirm('Are you sure you want to update diverse?')) return false;" alt="Save Diverse Changes">

	                </form>					
					
			</div>	
			


<?php
$contor=1;
$total=0;

$interogare="select count(continent.CODCONTINENT) as numarUtilizatori,numecontinent
from utilizatori,continent
where utilizatori.CODCONTINENT = continent.CODCONTINENT
group by continent.CODCONTINENT,numecontinent
Order by numecontinent";

$bazaDeDate->querySelect($interogare);

foreach ($bazaDeDate->rows() as $key) {
	if($contor==1)	$africa=$key['NUMARUTILIZATORI'];
	if($contor==2)	$amnord=$key['NUMARUTILIZATORI'];
	if($contor==3)	$amsud=$key['NUMARUTILIZATORI'];
	if($contor==4)	$antarctica=$key['NUMARUTILIZATORI'];
	if($contor==5)	$asia=$key['NUMARUTILIZATORI'];
	if($contor==6)	$australia=$key['NUMARUTILIZATORI'];
	if($contor==7)	$europa=$key['NUMARUTILIZATORI'];
	$total+=$key['NUMARUTILIZATORI'];
	$contor++;
	}
?>



<div id="statistici">	
	
	<h3>Statistici tari</h3>
	<div id="euSepar"></div>
	
	<div id="sttts">
	<svg width="600">
   <text x="0" y="15" fill="rgb(0,191,243)" font-family="sans-serif">Africa</text> 
   <line x1="125" y1="10" x2="225" y2="10" style="stroke:rgb(255,255,255);stroke-width:10" />
   <line x1="125" y1="10" x2="<?php echo (125+ceil((100*$africa)/$total)); ?>" y2="10" style="stroke:rgb(0,191,243);stroke-width:10" />
   	<text x="225" y="15" fill="rgb(0,191,243)"><?php echo $africa; ?></text> 

   <text x="0" y="30" fill="rgb(0,191,243)" font-family="sans-serif">America de Nord</text> 
   <line x1="125" y1="25" x2="225" y2="25" style="stroke:rgb(255,255,255);stroke-width:10" />
   <line x1="125" y1="25" x2="<?php echo (125+ceil((100*$amnord)/$total)); ?>" y2="25" style="stroke:rgb(0,191,243);stroke-width:10" />
   	<text x="225" y="30" fill="rgb(0,191,243)"><?php echo $amnord; ?></text> 

   <text x="0" y="45" fill="rgb(0,191,243)" font-family="sans-serif">America de Sud</text> 
   <line x1="125" y1="40" x2="225" y2="40" style="stroke:rgb(255,255,255);stroke-width:10" />
   <line x1="125" y1="40" x2="<?php echo (125+ceil(100*($amsud/$total))); ?>" y2="40" style="stroke:rgb(0,191,243);stroke-width:10" />
   	<text x="225" y="45" fill="rgb(0,191,243)"><?php echo $amsud; ?></text> 

   <text x="0" y="60" fill="rgb(0,191,243)" font-family="sans-serif">Antarctica</text> 
   <line x1="125" y1="55" x2="225" y2="55" style="stroke:rgb(255,255,255);stroke-width:10" />
   <line x1="125" y1="55" x2="<?php echo (125+ceil(100*($antarctica/$total))); ?>" y2="55" style="stroke:rgb(0,191,243);stroke-width:10" />
   	<text x="225" y="60" fill="rgb(0,191,243)"><?php echo $antarctica; ?></text> 

   <text x="0" y="75" fill="rgb(0,191,243)" font-family="sans-serif">Asia</text> 
   <line x1="125" y1="70" x2="225" y2="70" style="stroke:rgb(255,255,255);stroke-width:10" />
   <line x1="125" y1="70" x2="<?php echo (125+ceil(100*($asia/$total))); ?>" y2="70" style="stroke:rgb(0,191,243);stroke-width:10" />
   	<text x="225" y="75" fill="rgb(0,191,243)"><?php echo $asia; ?></text> 

   <text x="0" y="90" fill="rgb(0,191,243)" font-family="sans-serif">Australia</text> 
   <line x1="125" y1="85" x2="225" y2="85" style="stroke:rgb(255,255,255);stroke-width:10" />
   <line x1="125" y1="85" x2="<?php echo (125+ceil(100*($australia/$total))); ?>" y2="85" style="stroke:rgb(0,191,243);stroke-width:10" />
   	<text x="225" y="90" fill="rgb(0,191,243)"><?php echo $australia; ?></text> 

   <text x="0" y="105" fill="rgb(0,191,243)" font-family="sans-serif">Europa</text> 
   <line x1="125" y1="100" x2="225" y2="100" style="stroke:rgb(255,255,255);stroke-width:10" />
   <line x1="125" y1="100" x2="<?php echo (125+ceil(100*($europa/$total))); ?>" y2="100" style="stroke:rgb(0,191,243);stroke-width:10" />
   	<text x="225" y="105" fill="rgb(0,191,243)"><?php echo $europa; ?></text> 

  Browser-ul tau nu suporta SVG.
</svg>
</div>
</div>

</div><!--wrapDreapta-->

		<div id="istoricLogari">
			<h2>Recent Logins:</h2>

					<table>
					  <tr>
					    <th>Timestamp</th>
					    <th>IP</th>		
					    <th>User-Agent</th>
					  </tr>
					  
<?php

		 $interogare =  "select *
		 			from(select browser,dataLogare,ip
					from utilizatori u1,TABLE(u1.istoricLogariU) u2
					where username = '". $_SESSION['USERNAME']."'
					order by iid desc)
					where rownum<6";
		
		$bazaDeDate->querySelect($interogare);
		foreach ($bazaDeDate->rows() as $key) {
							echo"<tr>
							    <td>".$key['DATALOGARE']."</td>
							    <td>".$key['IP']."</td>		
							    <td>".$key['BROWSER']."</td>
							  </tr>";
		}


?>
					</table>
		</div>






</div>		
</div>

</body>
</html>