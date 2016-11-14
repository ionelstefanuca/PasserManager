<?php 
	$title='Search Results';
	require_once('module-pagini/dashboard-head.php');
	require_once('module-pagini/removePossib.php');
	$start=0;
	$limit=10;

	if(isset($_GET['id'])){
		$id=$_GET['id'];
		$start=($id-1)*$limit;}
	else{
	$id=1;}

if(isset($_POST['information'])){
	$_SESSION['informa']=$_POST['information'];
}


	isset($_POST['information'])? $meniuLabel = 'Search Results %'.$_POST['information']."%"
								:$meniuLabel = 'Search Results %'.$_SESSION['informa']."%";

?>

<div id="continut">
		<div id="titlu-continut">
			<h3><?php echo $meniuLabel;?></h3>
		</div>

		<div id="body-continut">
			<?php
			if(isset($_POST['postSearch']) or (isset($_SESSION['informa']))){
				$interogare = "SELECT * FROM viewParoleNegrupate WHERE userID = ".$_SESSION['USERID']." AND titluparola LIKE '%".$_SESSION['informa']."%' ORDER BY pid OFFSET ".$start." ROWS FETCH NEXT ".$limit." ROWS ONLY";
				$bazaDeDate->querySelect($interogare);

				if ($bazaDeDate->numRow()!=0){
					foreach ($bazaDeDate->rows() as $key){
						$dateDeAfisat ="<div class=\"parola\">
											<div id=\"titluParola\">".$key['TITLUPAROLA']."</div>
											<div id=\"continutParola\">
												<table>
														<tbody><tr>
															<td>Username</td>
															<td>Parola</td> 
															<td>Adresa Web</td>
															<td>Adaugata la data de </td>
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
						$interogare2 = "SELECT * FROM viewParoleNegrupate WHERE userID = ".$_SESSION['USERID']." AND titluparola LIKE '%".$_SESSION['informa']."%' ORDER BY pid ";
						$bazaDeDate->querySelect($interogare2);

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
							
				}
				else{
				echo "<p>Nu exista parole corespunzatoare.</p>";}
			}
			else{
				echo "<p>Pagina nu a fost incarcata corespunzator.</p>";}
			?>
		</div>
</div>

</body>
</html>