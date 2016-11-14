<?php 
$title='View Passwords';
$meniuLabel = 'Data Manager > View passwords';
require_once('module-pagini/dashboard-head.php'); 
require_once('module-pagini/viewPasswords.php');
$start=0;
$limit=10;

if(isset($_GET['id']))
{
	$id=$_GET['id'];
	$start=($id-1)*$limit;
}
else
{
	$id=1;
}

?>

<div id="continut">
		<div id="titlu-continut">
			<h3><?php echo $meniuLabel;?></h3>
		</div>

		<div id="grupareParole">
			<form action="" id="addpass_formm"  method="POST">
				<h3>Alege grupare</h3>
				<hr>
						<select name="tarieP" class="grupare" placeholder="Tarie parola">
							<option value="" disabled="" selected="">Tarie parola</option>
							<option value="slaba">slaba</option>
							<option value="medie">medie</option>
							<option value="puternica">puternica</option>
						</select>
						<select name="frecventaUtilizare" class="grupare" placeholder="Frecventa utilizare">
							<option value="" disabled="" selected="">Frecventa utilizare</option>
							<option value="zilnic">zilnic</option>
							<option value="saptamanal">saptamanal</option>
							<option value="lunar">lunar</option>
						</select>
						
						<select name="domeniuSite" class="grupare" placeholder="Frecventa utilizare">
							<option value="" disabled="" selected="">Domeniu site</option>
							<option value="educativ">educational</option>
							<option value="social">social</option>
							<option value="shopping">shopping</option>
							<option value="fun">funny</option>
						</select>	
					<hr>
						<input id="coosePGrupare" name="grupareParole" type="submit" value="Alege Gruparea">
					</form>
		</div>



<?php
		if(isset($_SESSION['grupare'])){

			echo '<div id ="showTextGrupare">
				Tarie: <span>'. $_SESSION['tarieParola'].'</span> > Domeniu site: <span>'.$_SESSION['domeniuSite'].'</span> > Frecventa utilizare: <span>'.$_SESSION['frecventaUtilizare'].'</span> 
			</div>';
		}
		else
			echo '<div id ="showTextGrupare"> Nu ai selectat nici o grupare > Afisam toate rezultatele </div>';	


?>

		<div id="body-continut">
			<?php
				if(isset($_SESSION['grupare']))
				{
				    $interogare1 = "select *
									from viewParoleNegrupate 
									where userID = ".$_SESSION['USERID']."
					and codGrupare =
									(
									    SELECT codGrupare
									    FROM grupareparole 
									    WHERE  domeniuSite='".$_SESSION['domeniuSite']."'and frecventaUtilizare='".$_SESSION['frecventaUtilizare']."' and tarieParola='".$_SESSION['tarieParola']."'
									) ORDER BY pid OFFSET ".$start." ROWS FETCH NEXT ".$limit." ROWS ONLY";
					
					 $bazaDeDate->querySelect($interogare1);
				}
				else
				{
					   	  $interogare2 = "select *
										  from viewParoleNegrupate 
										  where userID = ".$_SESSION['USERID']." 
										  ORDER BY pid OFFSET ".$start." ROWS FETCH NEXT ".$limit." ROWS ONLY";
					
					$bazaDeDate->querySelect($interogare2);
				}


					if ($bazaDeDate->numRow()!=0) 
					{
						foreach ($bazaDeDate->rows() as $key) {
							
						$dateDeAfisat ="<div class=\"parola\">
										<div id=\"titluParola\">".$key['TITLUPAROLA']."</div>

										<div id=\"continutParola\">
												<table>
														  <tbody><tr>
															<td>Username</td>
															<td>Parola</td> 
															<td>Adresa Web</td>
															<td>Adaugat la data de </td>
															<td>Expira la data de </td>
														  </tr>
														  <tr>
															<td>".$key['CONT']."</td>
															<td>".$key['PAROLA']."</td> 
															<td><a href=\"".$key['ADRESAWEB']."\" target=\"_blank\">".$key['TITLUPAROLA']."</a></td>
															<td>".$key['DATAADAUGARE']."</td> 
															<td>".$key['DATAEXPIRARE']."</td>
														  </tr>
														</tbody>
												</table>
												
												<div id=\"descriereP\">
													<p>Descriere</p>
													<div id=\"cDescriere\">
														<p>".$key['COMENTARII']."</p>
													</div>
												</div>	

												<div id=\"btnStergeP\">
													<form action=\"\" id=\"addpass_formm\"  method=\"POST\">
														<input class=\"special_submit\" type=\"submit\" name=\"stergeParola\" value=\"Sterge parola\">
														<input type=\"hidden\" name=\"codParolaSterge\" value=\"".$key['PID']."\">
													</form>
												</div>
														
										</div>
								</div>";
							echo $dateDeAfisat;	
						}


						//afisarea butoanelor de paginare + lista paginilor
								if(isset($_SESSION['grupare']))
								{
									    $interogare1 = "select pid,titluParola, cont, Parola, AdresaWeb, dataAdaugare, timpMaximDeValabilitate, statusParola, Comentarii, codGrupare, (dataAdaugare+timpMaximDeValabilitate) as dataExpirare 
										from userpasswords 
										where userID = ".$_SESSION['USERID']."
										and codGrupare =
														(
														    SELECT codGrupare
														    FROM grupareparole 
														    WHERE  domeniuSite='".$_SESSION['domeniuSite']."'and frecventaUtilizare='".$_SESSION['frecventaUtilizare']."' and tarieParola='".$_SESSION['tarieParola']."'
														)";

										$bazaDeDate->querySelect($interogare1);
								}
								else
								{		 
									$interogare2 = "select pid,titluParola, cont, Parola, AdresaWeb, dataAdaugare, timpMaximDeValabilitate, statusParola, Comentarii, codGrupare, (dataAdaugare+ timpMaximDeValabilitate) as dataExpirare from userpasswords where userID = ".$_SESSION['USERID'];
									$bazaDeDate->querySelect($interogare2);
								}

								$rows=$bazaDeDate->numRow();
								$total=ceil($rows/$limit);

								echo '<div id="paginare">';
								if($id>1)
								{
									echo "<a href='?id=".($id-1)."' class='button'>PREVIOUS</a>";
								}
								if($id!=$total)
								{
									  echo "<a href='?id=".($id+1)."' class='button'>NEXT</a>";
								}

								echo "<ul class='page'>";
										for($i=1;$i<=$total;$i++)
										{
											if($rows>$limit) if($i==$id) { echo "<li class='current'>".$i."</li>"; }
											
											else { echo "<li><a href='?id=".$i."'>".$i."</a></li>"; }
										}
								echo "</ul>";
								echo '</div>';

								//end afisarea butoanelor de paginare + lista paginilor

					}
			?>

		</div>

</div>

</body>
</html>