<?php

session_start();
$login_session=$_SESSION['login_user'];
if(!isset($login_session)){
	header('Location: ./login.php');
}
?>


<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title;?></title>
	<meta name="keywords" content="proiect tehnologie web, infoiasi,students" />
	<link rel="icon" type="image/x-icon" href="img/favicon.ico" />
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="css/dashboard.css" type="text/css"/>
	<link rel="stylesheet" href="css/viewPassword.css" type="text/css"/>
	<link rel="stylesheet" href="css/export.css" type="text/css"/>
	<link rel="stylesheet" href="css/account.css" type="text/css" />
	<link rel="stylesheet" href="css/userPanel.css" type="text/css">
	<link rel="stylesheet" href="css/uploadFromCSV.css" type="text/css">
	<link rel="stylesheet" href="css/genPass.css" type="text/css">
</head>

<body>

<div id="header">
		
		<div id="headSearch">
					<form method="post" action="search.php" id="searchform"> 
						<input type="text" name="information"> 
						<input title="Search" type="submit" name="postSearch" value="   "> 
					</form>
		</div>
		

		<div id="headLogout">
					<form method="post" action="module-pagini/logout.php" id="delogare">
								<input title="Delogare" type="submit" name="submit" value="   "> 
					</form>		
		</div>
</div>

<div id="sidebar">
	<div id="logoUser">
			<a href=""><img src="img/cris/logouser.PNG"></a>
	</div>

	<div id="helloUser">
			<img src="<?php echo $_SESSION['AVATAR'];?>">
			<p>Welcome,</p>
			<p style = "color:red"><?php echo $login_session ; ?></p>
	</div>

	<div id="meniuDashboard">
				<nav><ul>
						<a href="./user_panel.php"><li class="main">Data Manager</li></a>
							<a href="./addNewPassword.php"><li class="sec">Add password</li></a>
							<a href="./viewPasswords.php"><li class="sec">View passwords</li></a>
							<a href="./fileUpload.php"><li class="sec">Upload from CSV</li></a>
						<a href="./pwGenerator.php"><li class="main">Password Generator</li></a>
						<a href="./pwExport.php"><li class="main">Export</li></a>
							<a href="module-pagini/csvExport.php"><li class="sec">CSV</li></a>
							<a href="module-pagini/jsonExport.php"><li class="sec">JSON</li></a>
							<a href="module-pagini/xmlExport.php"><li class="sec">XML</li></a>
							<a href="./account.php"><li class="main">My Account</li></a>
						</ul>
					</nav>
	</div>	
</div>