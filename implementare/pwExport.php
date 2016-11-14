<?php 
$title='Passwords Export ';
$meniuLabel = 'Passwords Export > XML > JSON > CSV';
require_once('module-pagini/dashboard-head.php'); 
?>


<div id="continut">
		<div id="titlu-continut">
			<h3><?php echo $meniuLabel;?></h3>
		</div>

		<div id="body-continutExport">
				<ul>
					<li>
						<a href="module-pagini/csvExport.php"><img src="img/export/csv.png" alt="Export CSV"></a>
					</li>
					<li>
						<a href="module-pagini/jsonExport.php"><img src="img/export/json.png" alt="Export JSON"></a>
					</li>
					<li>
						<a href="module-pagini/xmlExport.php"><img src="img/export/xml.png" alt="Export XML"></a>
					</li>				
				</ul>
		</div>	
</div>

</body>
</html>