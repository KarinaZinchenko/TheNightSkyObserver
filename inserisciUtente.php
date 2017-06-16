<?php
ob_start();
?>
<html>
<head> <title>Inserimento nuovo utente</title> </head>
<body>
<?php
session_start();
include("config.php");
include("header.php");
include("navbar.php");
echo "<div class='container'>";
echo "<div class='row-fluid'>";
echo "<div class='span10 offset1'>";
echo "<div class='contact-info'>";
echo "<div class='panel-body'>";

if(isset($_SESSION["autenticato"])&& isset($_SESSION["tipo"]))
{
	if($_SESSION["tipo"]=="amministratore")
	{
       ?>
        <h1> Inserisci i dati dell'utente</h1>
        <form method="post" action="inserisciUtenteEffettivo.php">
            <div class="row">
                <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                    <label>Nome *</label><input type="text" name="nome">
                </div>
                <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                    <label>Cognome *</label><input type="text" name="cognome">
                </div>
                <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                    <label>Username *</label><input type="text" name="username">
                </div>
                <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                    <label>Password *</label><input type="password" name="password">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 form-group">
                    <label>Data scadenza tessera *</label><input type="datetime-local" name="data_scadenza_tessera">
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 form-group">
                    <label>Data di nascita *</label><input type="datetime-local" name="data_nascita">
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 form-group">
                    <label>Tipo utente *</label>
                    <select class="soflow-color" name="tipo_utente">
                        <option value="<?php echo "$tipo_utenti[0]";?>"><?php echo "$tipo_utenti[0]";?> </option>
                        <option value="<?php echo "$tipo_utenti[1]";?>"><?php echo "$tipo_utenti[1]";?> </option>
                        <option value="<?php echo "$tipo_utenti[2]";?>"><?php echo "$tipo_utenti[2]";?> </option>
                    </select>
                </div>
            </div>
            <input id="contact-submit" class="btn" type="submit" name="invio" value="inserisci">
        </form>
       <?php
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
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";

include("footer.php");
?>
</body>
</html>