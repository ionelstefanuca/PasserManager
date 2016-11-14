<?php
	$title='Contact';
	require_once('module-pagini/index-header.php'); 
?>


<div id="contactati">
	<div id="in_contac">
		
<?php
echo "inainte ISSET(sendEmail)<br>";
	$succes=true;
	$mesajEroare="";
	
if(isset($_POST['sendEmail'])){

	echo "dupa ISSET(sendEmail)<br>";
	
	$email_to="you@yourdomain";
	$email_subject="PASSER";

	if(empty($_POST['pers'])||empty($_POST['email'])||empty($_POST['coment'])){
		$succes=false;
		$mesajEroare="<p>Exista campuri necompletate in formular.</p>";
	}
	else
	{
		$persoana=$_POST['pers'];
		$email_from=$_POST['email'];
		$comentarii=$_POST['coment'];
	
		$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
		if(!preg_match($email_exp,$email_from)){
			$mesajEroare='<p>Adresa de email nu este valida.</p>';
			$succes=false;
		}
		$string_exp = "/^[A-Za-z .'-]+$/";
		if(!preg_match($string_exp,$persoana)){
			$mesajEroare+='<p>Persoana nu este valida.</p>';
			$succes=false;
		}
		if(strlen($comentarii)<3){
			$mesajEroare+='<p>Comentariile nu sunt valide.</p>';
			$succes=false;
		}

	$continut_mesaj="Detalii formular:\n\n";
	
	function clean_string($string){
		$bad=array("content-type","bcc:","to:","cc:","href");
		return str_replace($bad,"",$string);
	}
	
	$continut_mesaj.="Persoana: ".clean_string($persoana)."\n";
	$continut_mesaj.="Email: ".clean_string($email_from)."\n";
	$continut_mesaj.="Comentarii: ".clean_string($comentarii)."\n";
	
	$headers = 'From: '.$email_from."\r\n".'Reply-To: '.$email_from."\r\n".'X-Mailer: PHP/'.phpversion();
	
	if(mail($email_to,$email_subject,$continut_mesaj,$headers))
		$succes=true;
	else
		$succes=false;
	
	}	
	
if($succes===true)
	echo '<p>Mesajul a fost trimis cu succes.</p>';
else
	echo $mesajEroare;
}



?>

</div>
</div>