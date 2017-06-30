<?php
ob_start();

session_start();
include("config.php");
include("header.php");
include("navbar.php");
if(isset($_SESSION["autenticato"])&& isset($_SESSION["tipo"]))
{
	if($_SESSION["tipo"]=="amministratore") {
		$nome = "";
		$cognome = "";
		$user = "";
		$password = "";
		$tipo = "";
		//$numero_socio="";
		$data_scadenza_tessera = "";
		$data_nascita = "";
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if ($_REQUEST["nome"] != "" && $_REQUEST["cognome"] != "" && $_REQUEST["username"] != "" && $_REQUEST["password"] != "" && $_REQUEST["tipo_utente"] != "" && $_REQUEST["data_scadenza_tessera"] != "" && $_REQUEST["data_nascita"] != "") {

				$nome = $_REQUEST["nome"];
				$cognome = $_REQUEST["cognome"];
				$user = $_REQUEST["username"];
				$password = $_REQUEST["password"];
				$tipo = $_REQUEST["tipo_utente"];
				//$numero_socio=$_REQUEST["numero_socio"];
				$data_scadenza_tessera = $_REQUEST["data_scadenza_tessera"];
				$data_nascita = $_REQUEST["data_nascita"];

				$nome = nl2br(htmlentities($nome, ENT_QUOTES, 'UTF-8'));
				$cognome = nl2br(htmlentities($cognome, ENT_QUOTES, 'UTF-8'));
				$user = nl2br(htmlentities($user, ENT_QUOTES, 'UTF-8'));
				$password = nl2br(htmlentities($password, ENT_QUOTES, 'UTF-8'));
				$tipo = nl2br(htmlentities($tipo, ENT_QUOTES, 'UTF-8'));
				//$numero_socio=nl2br(htmlentities($numero_socio,ENT_QUOTES,'UTF-8'));
				$data_scadenza_tessera = nl2br(htmlentities($data_scadenza_tessera, ENT_QUOTES, 'UTF-8'));
				$data_nascita = nl2br(htmlentities($data_nascita, ENT_QUOTES, 'UTF-8'));

				$sql = "INSERT INTO anagrafica(nome,cognome,username,password,tipo,scadenza_tessera,data_nascita) VALUES ('" . addslashes($nome) . "','" . addslashes($cognome) . "','" . addslashes($user) . "','" . addslashes(md5($password)) . "','" . addslashes($tipo) . "','" . addslashes($data_scadenza_tessera) . "','" . addslashes($data_nascita) . "');";
				if (mysqli_query($conn, $sql)) {
					?>
					<script>
						swal({title: "Inserimento effettuato!", type: "success", showConfirmButton: false});
					</script>
					<?php
					header("Refresh:2; url=inserisciUtente.php", true, 303);
				} else {
					?>
					<script>
						swal({
							title: "Attenzione!",
							text: "Errore nella query.",
							type: "warning",
							showConfirmButton: false
						});
					</script>
					<?php
					header("Refresh:2; url=inserisciUtente.php", true, 303);
				}
				mysqli_close($conn);
			} else {
				?>
				<script>
					swal({
						title: "Attenzione!",
						text: "Tutti i campi sono obbligatori.",
						type: "warning",
						showConfirmButton: false
					});
				</script>
				<?php
				header("Refresh:3; url=inserisciUtente.php", true, 303);
			}


		} // fine if controllo accesso in post
		else {
			?>
			<script>
				swal({
					title: "Attenzione!",
					text: "Accesso errato alla pagina.",
					type: "warning",
					showConfirmButton: false
				});
			</script>
			<?php
			header("Refresh:2; url=profiloUtente.php", true, 303);

		} //fine if controllo sessione autorizzata
	}
else
  {
	  ?>
	  <script>
		  swal({title:"Oops...!",text:"Non sei autorizzato.",type:"error",showConfirmButton:false});
	  </script>
	  <?php
	  header("Refresh:2; url=profiloUtente.php", true, 303);
  }
}
else
{
	?>
	<script>
		swal({title:"Oops...!",text:"Non sei autorizzato.",type:"error",showConfirmButton:false});
	</script>
	<?php
	header("Refresh:2; index.php", true, 303);
}
?>
