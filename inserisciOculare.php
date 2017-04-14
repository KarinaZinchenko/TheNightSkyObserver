<?php
session_start();
include("config.php");
if(isset($_SESSION["autenticato"])&& isset($_SESSION["tipo"]))
{
	if($_SESSION["tipo"]=="amministratore")
	{
		if(!isset($_POST["invio"]))
		{
       ?>       
         <html>
         <head>
         	<title>Inserimento nuovo Oculare</title>
         </head>
         <body>
         <center>
         <h1> Inserisci i dati dell'oculare: </h1>  <br><br>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" >
         nome: <input type="text" name="nome"><br><br>
         marca: <input type="text" name="marca"><br><br>
         descrizione: <input type="text" name="descrizione"><br><br>
	     disponibilita: <input type="number" name="disponibilita"><br><br>
	     note: <input type="text" name="note"><br><br>
	     dimensione: <input type="number" name="dimensione" step=any><br><br>
	     Lunghezza focale: <input type="number" name="lunghezza_focale" step=any><br><br>
	     Campo visione apparente: <input type="number" name="campo_visione_apparente" step=any><br><br>
	     <input type="submit" name="invio" value="inserisci">
         </form>
         </center>
         </body>
         </html>
       <?php
       } // chiudo if per verificare se accedo alla pagina prima volta o se ho gia inserito dati
       else
       {
         $nome="";
		$marca="";
		$descrizione="";
		$disponibilita="";
		$note="";
		$dimensione=0;
		$lunghezza_focale=0;
		$campo_visione_apparente=0;
		if($_REQUEST["nome"]!="" && $_REQUEST["marca"]!="" && $_REQUEST["disponibilita"]!="" && $_REQUEST["dimensione"]!="" && $_REQUEST["lunghezza_focale"]!="" &&$_REQUEST["campo_visione_apparente"]!="")
		{
			$nome=$_REQUEST["nome"];
			$marca=$_REQUEST["marca"];
			$descrizione=$_REQUEST["descrizione"];
			$disponibilita=$_REQUEST["disponibilita"];
			$note=$_REQUEST["note"];
			$dimensione=$_REQUEST["dimensione"];
			$lunghezza_focale=$_REQUEST["lunghezza_focale"];
			$campo_visione_apparente=$_REQUEST["campo_visione_apparente"];

			$nome=nl2br(htmlentities($nome,ENT_QUOTES,'UTF-8'));
			$marca=nl2br(htmlentities($marca,ENT_QUOTES,'UTF-8'));
			$descrizione=nl2br(htmlentities($descrizione,ENT_QUOTES,'UTF-8'));
			$disponibilita=nl2br(htmlentities($disponibilita,ENT_QUOTES,'UTF-8'));
			$note=nl2br(htmlentities($note,ENT_QUOTES,'UTF-8'));
			$dimensione=nl2br(htmlentities($dimensione,ENT_QUOTES,'UTF-8'));
			$lunghezza_focale=nl2br(htmlentities($lunghezza_focale,ENT_QUOTES,'UTF-8'));
			$campo_visione_apparente=nl2br(htmlentities($campo_visione_apparente,ENT_QUOTES,'UTF-8'));

			$sql="INSERT INTO oculare(nome,marca,descrizione,disponibilita,note,dimensione,lunghezza_focale,campo_visione_apparente) VALUES ('".addslashes($nome)."','".addslashes($marca)."','".addslashes($descrizione)."',".addslashes($disponibilita).",'".addslashes($note)."',".addslashes($dimensione).",".addslashes($lunghezza_focale).",".addslashes($campo_visione_apparente).");";
			if(mysqli_query($conn, $sql) )
       {
            echo "<script language='javascript'>"; 
       	    echo "alert('Inserimento effettuato');";
             echo " </script>";
             header( "Refresh:0; url=prova-sessioni.php", true, 303);

       } 
          else {die("Errore nella query: "     . $sql . "\n" . mysqli_error($conn));}

 	 mysqli_close($conn);


		}//chiudo if per verificre che i campi siano stati inseriti
		else
		{
			echo "<script language='javascript'>"; 
         echo "alert('tutti i campi tranne descrizione e note sono obbligatori ');";
        echo " </script>";
        header( "Refresh:0; url=inserisciOculare.php", true, 303);
		}

       }
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