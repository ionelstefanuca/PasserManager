<?php 
$title='File Upload';
$meniuLabel = 'File upload from CSV';
require_once('module-pagini/dashboard-head.php'); 
require_once('module-pagini/Databases.php'); 

$mesaj=' ';
if(isset($_POST["stergeInregistrarile"])) {
	$interogare = 'DELETE FROM  userpasswords where userID='.$_SESSION['USERID'];

	if($bazaDeDate->queryInsert($interogare))
	{
		$mesaj='Am sters toate parolele';	
	}
	else
	{
		$mesaj='A aparut o eroare neprevazuta';
	}

}


if(isset($_POST["submit"])) {

	$target_dir = "upload/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    if($imageFileType =='csv') 
    {        

    		//fisierele sunt incarcate
    		// apelata functia din pachetul din sgbd pentru a incarca tuplele dupa care
    		// fisiereul este sters (nu ramane pe server)


	    			    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
	    			    {
					        $mesaj= "Fisierul ". ( $_FILES["fileToUpload"]["name"]). " a fost incarcat";

					        $mesajCsvDatabases = $bazaDeDate->uploadCSV( $_SESSION['USERID'],$_FILES["fileToUpload"]["name"]);

					        if($mesajCsvDatabases =='da')
					        {
					        	 $mesaj="Am incarcat cu succes tuplele din fisierul ".$_FILES["fileToUpload"]["name"];
					        }
					        else
					        {
					        	$mesaj = $mesajCsvDatabases;
					        }
					    } 
					    else 
					    {
					        $mesaj= "Nu am putut incarca acest fisier";
					    } 

				    	$path="./upload/".$_FILES["fileToUpload"]["name"];
						unlink($path); 
    } 
    else 
    {
        $mesaj= "Fisierul nu este csv";
    }
}

?>


<div id="continut">
		<div id="titlu-continut">
			<h3><?php echo $meniuLabel;?></h3>
		</div>

<?php
		if($mesaj!=' ')
		echo
			"<div id=\"uploadMesaj\">
				<p>".$mesaj."</p>
			</div>";
			$mesaj=' ';	
?>


		<div id="uploadFIleCSV">
				<form action="" method="post" enctype="multipart/form-data">
				    <h3>Selectati fisierul csv:</h3>
					<hr>
					<div id="contineButoane">
				    <input type="file" name="fileToUpload" id="fileToUpload">
				    <input type="submit" value="Upload CSV" name="submit">
					</div>
				</form>
		</div>

		<div id ="stergeToateTuplele">
				<form action="" method="post" enctype="multipart/form-data">
				    <h3>Sterge toate inregistrarile de pe site:<h3>
					<hr>
				    <input type="submit" value="Sterge toate parolele" name="stergeInregistrarile">
				</form>
		</div>
	
</div>

</body>
</html>