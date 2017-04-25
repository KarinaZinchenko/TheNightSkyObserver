<?php
session_start();
include("config.php");
if(isset($_SESSION["autenticato"])&& isset($_SESSION["tipo"]))
{
	if($_SESSION["tipo"]=="amministratore" || $_SESSION["tipo"]=="regolare")
	{
         switch($_POST["scelta_operazione"])
         {
            case "modifica":
                 $sql="UPDATE osservazioni SET categoria='".$_POST["categoria"]."',trasparenza=".$_POST["trasparenza"].",seeing_antoniani=".$_POST["seeing_antoniani"].",seeing_pickering=".$_POST["seeing_antoniani"].",id_area_geografica=".$_POST["area_osservazione"]." WHERE ID=".$_POST["id_osservazione2"].";";

                 $sql2="UPDATE datiosservazione SET stato='".$_POST["stato"]."',rating=".$_POST["rating"].",descrizione='".$_POST["descrizione"]."',immagine='".$_POST["immagine"]."',note='".$_POST["note"]."',ora_inizio='".$_POST["ora_inizio"]."',ora_fine='".$_POST["ora_fine"]."',id_oggettoceleste=".$_POST["oggetto_celeste"].", id_strumento=".$_POST["strumento"].",id_oculare=".$_POST["oculare"].",id_filtro=".$_POST["filtro"]." WHERE ID=".$_POST["id_datiosservazione2"].";";
                            break;
            case "elimina": 
                            $sql="DELETE  FROM osservazioni WHERE ID=".$_POST["id_osservazione2"].";";
                            $sql2="DELETE  FROM datiosservazione WHERE ID=".$_POST["id_datiosservazione2"].";";
                            break;
         };//chiudo switch

          if((mysqli_query($conn,$sql)) && (mysqli_query($conn,$sql2)))
          {
              echo "<script language='javascript'>"; 
       	    echo "alert('Operazione Riuscita');";
             echo " </script>";
              //echo "<a href='prova-sessioni.php'>Torna alla pagina personale </a> ";
             header( "Refresh:0; url=prova-sessioni.php", true, 303);
             // header("Location:prova-sessioni.php");
          }
          else
          {
              echo "<script language='javascript'>"; 
       	    echo "alert('Operazione non andata a buon fine');";
             echo " </script>";
             echo "Errore nella query: " . $sql . "<br>" . mysqli_error($conn); echo"<br><br>";
           header( "Refresh:0; url=prova-sessioni.php", true, 303);
            //  header("Location:prova-sessioni.php");
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
