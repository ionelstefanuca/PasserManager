<?php
	$title='Register';
	require_once('module-pagini/index-header.php'); 
	include('module-pagini/register-register.php');

	if(isset($_SESSION['login_user']))
	{
		header("location: user_panel.php");
	}
?>


<body>
	<script>
			function sugestii(str)
			{
				if(str.length==0)
				{
					document.getElementById("hinturi").innerHTML="";
					return;
				}
				else
				{
					var xmlhttp=new XMLHttpRequest();
					xmlhttp.onreadystatechange=function(){
						if(xmlhttp.readyState==4 && xmlhttp.status==200){
							document.getElementById("hinturi").innerHTML=xmlhttp.responseText;
						}
					}
					xmlhttp.open("GET","hinturi.php?inceput="+str,true);
					xmlhttp.send();
				}
			}
	</script>
	
<div id="inRegister">
	<div id="divCuFormRegister">
		<form id="formRegister" action="" method="POST" >
			<fieldset>
				<legend>Formular de Inregistrare</legend>
				<span>Enter your personal details below:</span>
				<input type="text" id="prenume" onkeyup="sugestii(this.value)" name="firstname" autocomplete="off" placeholder="*First Name"/>
				
				<p>Sugestii: <span id="hinturi"></span></p>
				
				<input type="text" name="lastname" autocomplete="off" placeholder="*Last Name"/>
				<input type="email" name="email" autocomplete="off" placeholder="*Email"/>
				<select name="reg_select" placeholder="Continent">
								<option value="" disabled selected>Pick your continent</option>
								<option value="0">Africa</option>
								<option value="1">America de Nord</option>
								<option value="2">America de Sud</option>
								<option value="3">Antarctica</option>
								<option value="4">Asia</option>
								<option value="5">Australia</option>
								<option value="6">Europa</option>
							</select>
				<input type="text" name="zipcode" autocomplete="off" placeholder="*Zip/Post Code" pattern="[0-9]{4}"/>
				<span>Enter your account details below:</span>
				<input type="text" name="userreg" autocomplete="off" placeholder="*Username"/>
				<input type="password" name="passreg" autocomplete="off" placeholder="*Password"/>
				<input type="password" name="confpass" autocomplete="off" placeholder="*Confirm Password"/>

				
				<input class="special_checkbox" type="checkbox" id="agreetoterms" name="agreetoterms" checked="checked"/>
						<label class="special_checkbox_label" for="agreetoterms">I agree to the <span id="termsOfUse">Terms of Use</span></label>
				<input class="special_submit" type="submit" name="register" value="Create account">
			</fieldset>
		</form>

			<div id="registerEroare">
				<p><?php echo $error; ?></p>
			</div>
	</div>

</div>
</body>
</html>
