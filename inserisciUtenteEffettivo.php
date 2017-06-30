<?php
session_start();
include("config.php");
if(isset($_SESSION["autenticato"])&& isset($_SESSION["tipo"]))
{
	if($_SESSION["tipo"]=="amministratore")
	{
		$nome="";
		$cognome="";
		$user="";
		$password="";
		$tipo="";
		//$numero_socio="";
		$data_scadenza_tessera="";
		$data_nascita="";
       if($_SERVER["REQUEST_METHOD"]=="POST")
       {
       	if($_REQUEST["nome"]!="" && $_REQUEST["cognome"]!="" && $_REQUEST["username"]!="" && $_REQUEST["password"]!="" && $_REQUEST["tipo_utente"]!="" &&$_REQUEST["data_scadenza_tessera"]!="" &&$_REQUEST["data_nascita"]!="")
       	{

       	 $nome=$_REQUEST["nome"];
		 $cognome=$_REQUEST["cognome"];
		 $user=$_REQUEST["username"];
		 $password=$_REQUEST["password"];
		 $tipo=$_REQUEST["tipo_utente"];
		 //$numero_socio=$_REQUEST["numero_socio"];
		 $data_scadenza_tessera=$_REQUEST["data_scadenza_tessera"];
		 $data_nascita=$_REQUEST["data_nascita"];

       $nome=nl2br(htmlentities($nome,ENT_QUOTES,'UTF-8'));
  	   $cognome=nl2br(htmlentities($cognome,ENT_QUOTES,'UTF-8'));
  	   $user=nl2br(htmlentities($user,ENT_QUOTES,'UTF-8'));
  	    $password=nl2br(htmlentities($password,ENT_QUOTES,'UTF-8'));
  	    $tipo=nl2br(htmlentities($tipo,ENT_QUOTES,'UTF-8'));
  	    //$numero_socio=nl2br(htmlentities($numero_socio,ENT_QUOTES,'UTF-8'));
  	    $data_scadenza_tessera=nl2br(htmlentities($data_scadenza_tessera,ENT_QUOTES,'UTF-8'));
  	     $data_nascita=nl2br(htmlentities($data_nascita,ENT_QUOTES,'UTF-8'));

  	     $sql="INSERT INTO anagrafica(nome,cognome,username,password,tipo,scadenza_tessera,data_nascita) VALUES ('".addslashes($nome)."','".addslashes($cognome)."','".addslashes($user)."','".addslashes($password)."','".addslashes($tipo)."','".addslashes($data_scadenza_tessera)."','".addslashes($data_nascita)."');";
  	     if(mysqli_query($conn, $sql) )
       {
            echo "<script language='javascript'>"; 
       	    echo "alert('Inserimento effettuato');";
             echo " </script>";

             echo "<a href='prova-sessioni.php'>Torna alla pagina personale </a> ";
       } 
          else {die("Errore nella query: "     . $sql . "\n" . mysqli_error($conn));}

 	 mysqli_close($conn);
  }else
       	{echo "<script language='javascript'>"; 
         echo "alert('tutti i campi devono essere inseriti');";
        echo " </script>";
         echo "<a href='inserisciUtente.php'>Torna alla pagina per inserire utenti </a> ";
       }

       	

       	} // fine if controllo accesso in post
       else{
         echo "accesso errato alla pagina <a href='prova-sessioni.php'>Torna alla pagina personale </a> ";
            }
       
       } //fine if controllo sessione autorizzata

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
