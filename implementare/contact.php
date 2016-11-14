<?php
	$title='Contact';
	require_once('module-pagini/index-header.php'); 
	include('module-pagini/test_eroare_contact.php');
?>
	
<div id="contactati">
	<div id="in_contac">
	<!--
		<script src="https://maps.googleapis.com/maps/api/js"></script>
    	<script>
      			function initialize() {
        			var mapCanvas = document.getElementById('map-canvas');
        			var mapOptions = {
          			center: new google.maps.LatLng(47.1740, 27.5749),
          			zoom: 18,
          			mapTypeId: google.maps.MapTypeId.ROADMAP
        			}
        		var map = new google.maps.Map(mapCanvas, mapOptions)
      			}
      			google.maps.event.addDomListener(window, 'load', initialize);
    	</script>
	-->
		<div id="contact-stanga">
			<div id="divInformatica">
				<a href="https://www.google.ro/maps/place/Faculty+of+Computer+Science/@47.1739196,27.574909,88m/data=!3m1!1e3!4m2!3m1!1s0x0:0x193e4b6864504e2c!6m1!1e1" target="_blank" title="Google Maps: FII">
					<img src="img/cris/informatica.png">
				</a>
			</div>
			<div id="divAdresa">
				<address>
					<strong>Address:</strong><br/>
						Facultatea de Informatică, Universitatea "Al. I. Cuza",<br/>
						General Berthelot, 16, IAŞI 700483, ROMANIA<br/>
					<strong>Phone:</strong><br/>
						+40 232 201090<br/>
					<strong>Fax:</strong><br/>
						+40 232 201490<br/>
					<strong>E-mail:</strong><br/>
						secretariat&commat;info.uaic.ro<br/>
				</address>
			</div>
				<!--<div id="map-canvas" style="width: 300px;height: 200px;"></div>-->
		</div>

		<div id="contact-dreapta">
			
			<div id="cuFormContact">
				<form name="contactform" method="post" action="" id="contact-form">
					<fieldset>
						<legend>Lasati un mesaj...</legend>
							<input type="text" id="persoana" name="persoana" placeholder="Persoana" autocomplete="off">
							<input type="email" id="email" name="email" placeholder="Email" autocomplete="off">
							<textarea name="mesaj" maxlength="500" cols="25" rows="6" placeholder="Mesaj"  autocomplete="off"></textarea>
							<input type="submit" name="trimite" value="Trimite mesaj" id="trim-email-submit">
					</fieldset>
				</form>
			</div>
			<div id="cuFeedback">
				<p><?php echo $mesajFeedback;?></p>
			</div>
		</div>
	
	</div>
	
</div>


<!--<?php 	require_once('module-pagini/index-footer.php'); ?>;-->