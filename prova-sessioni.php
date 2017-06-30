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
		echo "<a href='inserisciOsservazione.php'>Crea osservazione </a>"; 
		echo "&nbsp; &nbsp; <a href='modificaEliminaOsservazione.php'>Modifica/Elimina Osservazione </a>";// pagina personale utente regolare
		echo "&nbsp; &nbsp; <a href='vistaSoci.php'>Vista Soci</a>";
		echo "&nbsp; &nbsp; <a href='vistaOsservazioniNonComplete.php'>Vista Osservazioni Non Complete</a>";
		echo "&nbsp; &nbsp; <a href='vistaOggettiCelesti.php'>Vista Oggetti Celesti</a>";
		echo "&nbsp; &nbsp; <a href='vistaSitiOsservativi.php'>Vista Siti Osservativi</a>";
	 }
         elseif ($tipo=="amministratore") 
         {
		echo "utente amministratore <br>";
		echo "<a href='inserisciUtente.php'>Inserisci nuovo utente </a>";
		echo "&nbsp; &nbsp; <a href='modificaEliminaUtente.php'>Modifica/Elimina Utenti </a>";
		echo "&nbsp; &nbsp; <a href='inserisciOculare.php'>Inserisci Oculare </a>";
		echo "&nbsp; &nbsp; <a href='inserisciFiltro.php'>Inserisci Filtro/Altro </a>";
		echo "&nbsp; &nbsp; <a href='inserisciOggettoCeleste.php'>Inserisci Oggetto Celeste </a>";
		echo "&nbsp; &nbsp; <a href='inserisciArea.php'>Inserisci Sito Osservativo </a>";
		echo "&nbsp; &nbsp; <a href='inserisciStrumento.php'>Inserisci Strumento </a>";
		echo "&nbsp; &nbsp; <a href='modificaEliminaStrumento.php'>Modifica/Elimina Strumento</a>";
	    
		echo "<br><br>";
		echo "<a href='inserisciOsservazione.php'>Crea osservazione </a>";
		echo "&nbsp; &nbsp; <a href='modificaEliminaOsservazione.php'>Modifica/Elimina Osservazione </a>";
		echo "&nbsp; &nbsp; <a href='vistaSociInsolventi.php'>Vista Soci Insolventi</a>";
		echo "&nbsp; &nbsp; <a href='vistaSoci.php'>Vista Soci</a>";
		echo "&nbsp; &nbsp; <a href='vistaOsservazioniNonComplete.php'>Vista Osservazioni Non Complete</a>";
		echo "&nbsp; &nbsp; <a href='vistaOggettiCelesti.php'>Vista Oggetti Celesti</a>";
		echo "&nbsp; &nbsp; <a href='vistaSitiOsservativi.php'>Vista Siti Osservativi</a>";
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
