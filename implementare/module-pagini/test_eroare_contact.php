<?php
	$mesajFeedback = "";
	
	if(isset($_POST['trimite']))
	{
		 $succes = true;
		 
		if(empty($_POST['persoana'])||!preg_match("/^[a-zA-Z '-]+$/", $_POST['persoana'])||preg_match("/^\s+$/", $_POST['persoana']))
		{
			$errPers = "Numele este invalid.<br/>";
			$succes = false;
		}
		
		
		if (empty($_POST['email'])||!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
		{
			$errMail = "Emailul este invalid.<br/>";
			$succes = false;
		}
		
		
		if(empty($_POST['mesaj'])||!preg_match("/^[\w\s'-.:;<>=+()*!?,\"]{1,500}$/", $_POST['mesaj'])||preg_match("/^\s+$/", $_POST['mesaj']))
		{
			$errMesaj = "Mesajul nu corespunde cerintelor.<br/>";
			$succes = false;
		}

		
		if($succes == true)
		{
			$date = date('m-d-Y_h-i-s_a', time());
			$numeFisier='feedback/'.$_POST['persoana'].'_'.$date.'.txt';
			$file = fopen($numeFisier,"w");
			$continutFisier = "PERSOANA: ".$_POST['persoana']."\n".
							  "EMAIL: ".$_POST['email']."\n".
							  "MESAJ:\n".$_POST['mesaj']."\n";
			fwrite($file,$continutFisier);
			fclose($file);
			$mesajFeedback = "Mesajul a fost inregistrat cu succes.";
		}
		else
		{
			$mesajFeedback = "";
			if(!empty($errPers))	$mesajFeedback .= $errPers;
			if(!empty($errMail))	$mesajFeedback .= $errMail;
			if(!empty($errMesaj))	$mesajFeedback .= $errMesaj;
		}
	}			
?>