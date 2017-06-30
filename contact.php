<?php
session_start();
include("config.php");
include("header.php");
include("navbar.php");
?>
<html>
<head>
	<title>Contact</title>
</head>
<body>
<div class="container">
	<div class="row-fluid">
		<div class="span10 offset1">
			<div class="contact-info">
				<div class="panel-body">
					<h1>Contattaci</h1>
					<br>
					<div class="col-xs-4 col-sm-4 col-md-4">
						<br><br>
						<h4>Indirizzo</h4>
						<p>
							Via delle Scienze, 206 <br>
							33100 Udine UD
						</p>
						<br>
						<h4>Email</h4>
						<p>
							thenightskyobserver@gmail.com
						</p>
						<br>
						<h4>Telefono</h4>
						<p>
							(+39) 346-6XXXX34
						</p>
					</div>
					<div class="col-xs-8 col-sm-8 col-md-8">
						<iframe width="500" height="350" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/search?q=Universit%C3%A0%20degli%20Studi%20di%20Udine%20-%20Polo%20Scientifico%20Rizzi%2C%20Via%20delle%20Scienze%2C%20Udine%2C%20UD%2C%20Italia&key=AIzaSyDWD47kkXviPHX9SZyXCuaIZGaK5lUEUO0" allowfullscreen></iframe>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<?php
include("footer.php");
?>
</body>
</html>
