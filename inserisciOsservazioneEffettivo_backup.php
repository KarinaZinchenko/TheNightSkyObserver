<?php
session_start();
include("config.php");
if(isset($_SESSION["autenticato"])&& isset($_SESSION["tipo"]))
{
	if($_SESSION["tipo"]=="amministratore" || $_SESSION["tipo"]=="regolare")
	{
        
        $categoria="";
        $trasparenza=null;
        $seeing_antoniani=null;
        $seeing_pickering=null;
        $stato="";
        $rating=null;
        $descrizione="";
        $immagini="";
        $note="";
        $ora_inizio="";
        $ora_fine="";
        $id_oggettoceleste=null;
        $id_strumento=null;
        $id_osservazioni=null;
        $id_oculare=null;
        $id_filtro=null;
        $id_area_geografica=null;
        $id_anagrafica=null;
        if($_SERVER["REQUEST_METHOD"]=="POST")
       {
       	if($_REQUEST["categoria"]!="" && $_REQUEST["trasparenza"]!="" && $_REQUEST["stato"]!="")
       	 {
           $categoria=$_REQUEST["categoria"];
        $trasparenza=$_REQUEST["trasparenza"];
        $seeing_antoniani=$_REQUEST["seeing_antoniani"];
        $seeing_pickering=$_REQUEST["seeing_pickering"];
        $stato=$_REQUEST["stato"];
        $rating=$_REQUEST["rating"];
        $descrizione=$_REQUEST["descrizione"];
        $immagini=$_REQUEST["immagine"];
        $note=$_REQUEST["note"];
        $ora_inizio=$_REQUEST["ora_inizio"];
        $ora_fine=$_REQUEST["ora_fine"];
        $id_oggettoceleste=$_REQUEST["oggetto_celeste"];
        $id_strumento=$_REQUEST["strumento"];
        $id_oculare=$_REQUEST["oculare"];
        $id_filtro=$_REQUEST["filtro"];
        $id_area_geografica=$_REQUEST["area_osservazione"];
        $id_anagrafica=$_REQUEST["id_utente"];

          $categoria=nl2br(htmlentities($categoria,ENT_QUOTES,'UTF-8'));
           $trasparenza=nl2br(htmlentities($trasparenza,ENT_QUOTES,'UTF-8'));
            $seeing_antoniani=nl2br(htmlentities($seeing_antoniani,ENT_QUOTES,'UTF-8'));
             $seeing_pickering=nl2br(htmlentities($seeing_pickering,ENT_QUOTES,'UTF-8'));
              $stato=nl2br(htmlentities($stato,ENT_QUOTES,'UTF-8'));
               $rating=nl2br(htmlentities($rating,ENT_QUOTES,'UTF-8'));
                $descrizione=nl2br(htmlentities($descrizione,ENT_QUOTES,'UTF-8'));
                 $immagini=nl2br(htmlentities($immagini,ENT_QUOTES,'UTF-8'));
                  $note=nl2br(htmlentities($note,ENT_QUOTES,'UTF-8'));
                   $ora_fine=nl2br(htmlentities($ora_fine,ENT_QUOTES,'UTF-8'));
                    $ora_inizio=nl2br(htmlentities($ora_inizio,ENT_QUOTES,'UTF-8'));
                     $id_oggettoceleste=nl2br(htmlentities($id_oggettoceleste,ENT_QUOTES,'UTF-8'));
                      $id_strumento=nl2br(htmlentities($id_strumento,ENT_QUOTES,'UTF-8'));
                       $id_oculare=nl2br(htmlentities($id_oculare,ENT_QUOTES,'UTF-8'));
                        $id_filtro=nl2br(htmlentities($id_filtro,ENT_QUOTES,'UTF-8'));
                         $id_area_geografica=nl2br(htmlentities($id_area_geografica,ENT_QUOTES,'UTF-8'));
                          $id_anagrafica=nl2br(htmlentities($id_anagrafica,ENT_QUOTES,'UTF-8'));

        $sql="INSERT INTO osservazioni(categoria,trasparenza,seeing_antoniani,seeing_pickering,id_area_geografica,id_anagrafica) VALUES ('".addslashes($categoria)."',".addslashes($trasparenza).",".addslashes($seeing_antoniani).",".addslashes($seeing_pickering).",".addslashes($id_area_geografica).",".addslashes($id_anagrafica).");";

         if(mysqli_query($conn, $sql) )
       {
       	  $sql="SELECT MAX(ID) as ID from osservazioni";
       	  $risposta=mysqli_query($conn,$sql)or die("Errore nella query: " . $sql . "\n" . mysqli_error($conn));
            if(mysqli_num_rows($risposta)!=0)
                 {
                 	$tupla = mysqli_fetch_array($risposta);
                   $id_osservazioni=$tupla["ID"];

                   $sql="INSERT INTO datiosservazione(stato,rating,descrizione,immagine,note,ora_fine,ora_inizio,id_oggettoceleste,id_strumento,id_osservazioni,id_oculare,id_filtro) VALUES ('".addslashes($stato)."',".addslashes($rating).",'".addslashes($descrizione)."','".addslashes($immagini)."','".addslashes($note)."','".addslashes($ora_fine)."','".addslashes($ora_inizio)."',".addslashes($id_oggettoceleste).",".addslashes($id_strumento).",".addslashes($id_osservazioni).",".addslashes($id_oculare).",".addslashes($id_filtro).");";
                   if(mysqli_query($conn, $sql) )
       {
            echo "<script language='javascript'>"; 
       	    echo "alert('Inserimento effettuato');";
             echo " </script>";
             echo "<a href='prova-sessioni.php'>Torna alla pagina personale </a> ";
       } 
          else {die("Errore nella query: "     . $sql . "\n" . mysqli_error($conn));}

 	 mysqli_close($conn);

                 }
                 else
                 {
                 	die("errore nelle query");
                 }

       } 
          else {die("Errore nella query: "     . $sql . "\n" . mysqli_error($conn));}
        
       	 }
       	 else
       	{echo "<script language='javascript'>"; 
         echo "alert(' i campi obbligatori devono essere inseriti');";
        echo " </script>";
         echo "<a href='inserisciOsservazione.php'>Torna alla pagina per inserire l'osservazione </a> ";
       }
       }
       else{
         echo "accesso errato alla pagina <a href='prova-sessioni.php'>Torna alla pagina personale </a> ";
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