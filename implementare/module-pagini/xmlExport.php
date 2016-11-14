<?php
require_once('Databases.php');
session_start();
header('Content-Type: text/xml; charset=utf-8');
header('Content-Disposition: attachment; filename=date-'.$_SESSION['login_user'].'.xml');

$interogare =  "SELECT *
				FROM viewExport 
				WHERE userID =".$_SESSION['USERID'];



echo "<?xml version=\"1.0\"?>\n
<catalog>\n";
$contor =1;

$bazaDeDate->querySelect($interogare);
foreach ($bazaDeDate->rows() as $key) 
{
echo "
  <parola id =\"".$contor."\">
	<titluParola>".$key['TITLUPAROLA']."</titluParola>
	<contParola>".$key['CONT']."</contParola>
	<parola>".$key['PAROLA']."</parola>
	<adresaWeb>".$key['ADRESAWEB']."</adresaWeb>
	<dataAdaugare>".$key['DATAADAUGARE']."</dataAdaugare>
	<timpMaximDeValabilitate>".$key['TIMPMAXIMDEVALABILITATE']."</timpMaximDeValabilitate>
	<comentarii>".$key['COMENTARII']."</comentarii>
	<tarieParola>".$key['TARIEPAROLA']."</tarieParola>
	<frecventaUtilizare>".$key['FRECVENTAUTILIZARE']."</frecventaUtilizare>
	<domeniuSite>".$key['DOMENIUSITE']."</domeniuSite>
  </parola>";

  $contor++;
}
	
echo"
</catalog>	";	
?>