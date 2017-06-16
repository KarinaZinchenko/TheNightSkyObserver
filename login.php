<?php
//session_destroy();
if(isset($_SESSION["autenticato"]) && $_SESSION["autenticato"]!="" )
{
	session_unset();
	session_destroy();
}
session_start();
include("config.php");
include("header.php");
?>

<?php
if ($_SERVER["REQUEST_METHOD"]=="POST") {
	$username="";
	$password="";
	if(isset($_REQUEST["username"]) && isset($_REQUEST["password"]))
	{
		$username=$_REQUEST["username"];
		$password=$_REQUEST["password"];

	}

	if($username=="" || $password=="")
	{
		?>
		<script>
			swal({title:"Attenzione!",text:"User e/o password non esistenti o errati.",type:"warning",showConfirmButton:false, timer:2200});
		</script>
		<?php

	}

	$sql="SELECT numero_socio,password,nome,cognome,tipo,scadenza_tessera FROM anagrafica WHERE username='".addslashes($username)."';";
	$risposta=mysqli_query($conn,$sql)or die("Errore nella query: " . $sql . "\n" . mysqli_error($conn));
	if(mysqli_num_rows($risposta)!=0)
	{
		while ($tupla = mysqli_fetch_array($risposta))
		{
			if($tupla["password"]==md5($password) || $tupla["password"]==$password)
			{				
				$_SESSION["autenticato"]=true;
				$_SESSION["login"]=$username;
				$_SESSION["tipo"]=$tupla["tipo"];
				$_SESSION["nome"]=$tupla["nome"];
				$_SESSION["numero_socio"]=$tupla["numero_socio"];
                $_SESSION["scadenza_tessera"]=$tupla["scadenza_tessera"];

				header("Location: profiloUtente.php");
			}
			else
				?>
				<script>
					swal({title:"Attenzione!",text:"User e/o password non esistenti o errati.",type:"warning",showConfirmButton:false, timer:2200});
				</script>
				<?php
		}

	}
	else
		?>
		<script>
			swal({title:"Attenzione!",text:"User e/o password non esistenti o errati.",type:"warning",showConfirmButton:false, timer:2200});
		</script>
		<?php

	mysqli_close($conn);
}

?>
<html>
<head>
	<title>Login</title>
</head>
<body>
<div class="container">
	<div class="row-fluid">
		<div class="span10 offset1">
			<div class="contact-info">
				<div class="panel-body">
					<h1>Login</h1>
					<h2>Effettua il login per accedere alla tua pagina personale</h2>
					<div class="col-md-4 col-md-offset-4">
						<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
							<div class="form-group">
								<input id="username" name="username" type="text" class="form-control" placeholder="Username">
							</div>
							<div class="form-group">
								<input id="password" name="password" type="password" class="form-control" placeholder="Password">
							</div>
							<div class="form-group">
								<input id="contact-submit" type="submit" name="invia" class="btn" value="Entra">
							</div>
						</form>
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
