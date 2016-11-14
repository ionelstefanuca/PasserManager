<?php 
$title='Add Passwords';
$meniuLabel = 'Data Manager > Add password';
require_once('module-pagini/dashboard-head.php'); 
require_once('module-pagini/addPasswords.php');

$valoaretarie='slaba';
if(empty($_SESSION['parolaGenerata']))	$parolaeste=''; else $parolaeste=$_SESSION['parolaGenerata'];
if(!empty($_SESSION['parolaGenerata']))
{
	$scor=10;
	$subject = $_SESSION['parolaGenerata'];
	$scor+=strlen($subject);
	if (strlen($subject)>0 && strlen($subject) <= 4) {$scor += strlen($subject);}
	else 
		if(strlen($subject)>=5 && strlen($subject) <= 7) {$scor += 6;}
		else 
		if(strlen($subject)>=8)	{$scor += 10;}
	if (preg_match("/[a-z]/", $subject))		{$scor += 1;}
	if (preg_match("/[A-Z]/", $subject))		{$scor += 5;}
	if (preg_match("/\d/",  $subject))		{$scor += 5;}
	if (preg_match("/(.*\d.*\d.*\d){1,}/", $subject))		{$scor += 5;}
	if (preg_match("/[-!@#%^*?~+=]/", $subject))		{$scor += 5;}
	if (preg_match("/(.*[-!@#%^*?~+=].*[-!@#%^*?~+=]){1,}/", $subject))		{$scor += 5;}
	if (preg_match("/(?=.*[a-z])(?=.*[A-Z])/", $subject))		{$scor += 2;}
	if (preg_match("/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])/", $subject))		{$scor += 2;}
	if($scor<35)
	{
		$valoaretarie='slaba';
		$bgTarie='#CC0000';
	}
	else if($scor<60)
	{
		$valoaretarie='medie';
		$bgTarie='#732C7B';
	}
	else
	{
		$valoaretarie='puternica';
		$bgTarie='#3399CC';
	}
}

?>

<div id="continut">
		<div id="titlu-continut">
			<h3><?php echo $meniuLabel;?></h3>
		</div>

		<div id="body-continut">

		
		<?php
		if($error!='')
			echo "<div id=\"erori\">
				 ".$error."
			</div>";
		?>	

		
			<form action="" id="addpass_form"  method="POST">
			<h3>Adauga parola...</h3>
			<hr>
				<input name="titluP" type="text" placeholder="*Titlu parola" pattern="[-\sa-zA-Z0-9]{1,50}" title="Caractere permise: - a-z A-Z 0-9 spatiu">
				<input name="adresaSite" type="text" placeholder="*Adresa Site" pattern="^((http(s)?)|(ftp)):\/\/(((www)?([-a-zA-Z0-9]{2,256}\.){1,})|(([-a-zA-Z0-9]{2,256}\.){1,}))([a-z]{2,4}){1}$" title="Caractere permise: -a-zA-Z0-9.://">
				<input name="contP" type="text" placeholder="*User" pattern="[a-zA-Z0-9]{3,25}">
				<input id="parolaPPP" name="parolaP" type="text" value="<?php echo $parolaeste; ?>" placeholder="*Parola" onkeyup="myFunction()" pattern="[a-zA-Z0-9!@#%^*?_~+-=]+" title="Caractere permise: a-zA-Z0-9!@#%^*?_~+-=">
				<input name="timpValabilitateP" type="number" placeholder="*Timp maxim de Valabilitate (zile)">
				<input type="text" style="color:white;background-color:<?php if(isset($bgTarie)) echo $bgTarie; else echo 'black';?>" name="tarieP" id="tarieTTT" placeholder="Tarie parola" value="<?php echo $valoaretarie;?>" readonly="readonly">
				<select name="frecventaUtilizare" id="third_selection">
					<option value="" disabled="disabled" selected="selected">*Frecventa utilizare</option>
					<option value="zilnic">zilnic</option>
					<option value="saptamanal">saptamanal</option>
					<option value="lunar">lunar</option>
				</select>
				<select name="domeniuSite" id="second_select">
					<option value="" disabled="disabled" selected="selected">*Domeniu site</option>
					<option value="educativ">educational</option>
					<option value="social">social</option>
					<option value="shopping">shopping</option>
					<option value="fun">funny</option>
				</select>						
				<textarea name="ComentariuP" rows="5" placeholder="*Comentariu despre parola..."></textarea>
				<hr>
				<input name="adaugaParola" type="submit" value="Add password">
			</form>
		</div>

<script>
function calcTarie()
{
	var scor=Number(10);
	var pass=document.getElementById('parolaPPP').value;
	scor+=Number(pass.length);
	if(pass.length > 0 && pass.length <= 4) {scor += Number(pass.length);}
	else if (pass.length >= 5 && pass.length <= 7) {scor += Number(6);}
	else if (pass.length >= 8)	{scor += Number(10);}	
	if (pass.match(/[a-z]/)) {scor += Number(1);}
	if (pass.match(/[A-Z]/)) {scor += Number(5);}
	if (pass.match(/\d/)) {scor += Number(5);}
	if (pass.match(/.*\d.*\d.*\d/)) {scor += Number(5);}
	if (pass.match(/[-!=@#%^*?_~+]/)) {scor += Number(5);}
	if (pass.match(/.*[-!=@#%^*?_~+].*[!=@#%^*?_~+-]/)) {scor += Number(5);}
	if (pass.match(/(?=.*[a-z])(?=.*[A-Z])/)) {scor += Number(2);}
	if (pass.match(/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])/)) {scor += Number(2);}
return scor;
}

function myFunction() {
    var nr=calcTarie();
	document.getElementById('tarieTTT').style.color='white';
    if(nr<35)	
	{
		document.getElementById('tarieTTT').value='slaba';
		document.getElementById('tarieTTT').style.backgroundColor='#CC0000';
	}
    else if(nr<60)
	{
		document.getElementById('tarieTTT').value='medie';
		document.getElementById('tarieTTT').style.backgroundColor='#732C7B';
	}
    else
	{
		document.getElementById('tarieTTT').value='puternica';
		document.getElementById('tarieTTT').style.backgroundColor='#3399CC';
	}
}
</script>

<?php
	$_SESSION['parolaGenerata']='';
?>
		
</div>

</body>
</html>