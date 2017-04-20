<?php
session_start();
include("config.php");
if(isset($_SESSION["autenticato"])&& isset($_SESSION["tipo"]))
{
	if($_SESSION["tipo"]=="amministratore")
	{
       ?>
        
         <html>
         <head>
         	<title>Inserimento nuovo utente</title>
         </head>
         <body>
         <center>
          <h1> Inserisci i dati dell'utente: </h1>  <br><br>
         <form method="post" action="inserisciUtenteEffettivo.php">
         nome: <input type="text" name="nome"><br><br>
         cognome: <input type="text" name="cognome"><br><br>
         username: <input type="text" name="username"><br><br>
	     password: <input type="password" name="password"><br><br>
	     tipo utente: &nbsp;<select name="tipo_utente">
         <option value="<?php echo "$tipo_utenti[0]";?>"><?php echo "$tipo_utenti[0]";?> </option>
         <option value="<?php echo "$tipo_utenti[1]";?>"><?php echo "$tipo_utenti[1]";?> </option>
         <option value="<?php echo "$tipo_utenti[2]";?>"><?php echo "$tipo_utenti[2]";?> </option>
	      </select> <br><br>
	     data scadenza tessera: <input type="date" name="data_scadenza_tessera"><br><br>
	     data nascita: <input type="date" name="data_nascita"><br><br>
	     <input type="submit" name="invio">
         </form>
         </center>
         </body>
         </html>
       <?php
	}
	else
    {
      echo "<script language='javascript'>"; 
         echo "alert('Non sei autorizzato ');";
        echo " </script>";
        header( "Refresh:0; url=prova-sessioni.php", true, 303);
    }
}
else
{
    echo "<script language='javascript'>"; 
         echo "alert('Non sei autorizzato ');";
        echo " </script>";
        header( "Refresh:0; index.php", true, 303);
}
?>
