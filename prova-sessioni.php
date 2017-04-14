<?php
session_start();
include("config.php");
if(isset($_SESSION["autenticato"]))
{
	$user=$_SESSION["login"];
	$tipo=$_SESSION["tipo"];
	echo "Ciao $user <br>";
	echo"<a href='logout.php'>Logout </a>";
	echo "<center>";
	if(in_array($tipo, $tipo_utenti))
	{
         if($tipo=="regolare")
         {
         	echo "utente normale"; // pagina personale utente regolare
         }
         elseif ($tipo=="amministratore") 
         {
            echo "utente amministratore <br>";
            echo "<a href='inserisciUtente.php'>Inserisci nuovo utente </a>";
            echo "&nbsp; &nbsp; <a href='modificaEliminaUtente.php'>Modifica/Elimina Utenti </a>";
            echo "&nbsp; &nbsp; <a href='inserisciOculare.php'>Inserisci Oculare </a>";
            echo "&nbsp; &nbsp; <a href='inserisciFiltro.php'>Inserisci Filtro/Altro </a>";
            echo "&nbsp; &nbsp; <a href='inserisciOggettoCeleste.php'>Inserisci Oggetto Celeste </a>";
        }
         else
           echo "utente insolvente";	
         
	}
	else
	{
		echo "l'utente è di una tipologia sbagliata";
	}
  echo "</center>";
}
else
{
      echo "<script language='javascript'>"; 
         echo "alert('Non sei autorizzato ');";
        echo " </script>";
        header( "Refresh:0; url=index.php", true, 303);
	
}


?>