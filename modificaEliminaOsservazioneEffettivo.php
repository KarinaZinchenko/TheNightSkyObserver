<?php
session_start();
include("config.php");
if(isset($_SESSION["autenticato"])&& isset($_SESSION["tipo"]))
{
	if($_SESSION["tipo"]=="amministratore" || $_SESSION["tipo"]=="regolare")
	{
    if(isset($_POST["scelta_operazione"]))
      { $numero_tuple=$_POST["numero_tuple"]; 

         switch($_POST["scelta_operazione"])
         {
         
            case "modifica":
                $sql="UPDATE osservazioni SET categoria='".$_POST["categoria"]."',trasparenza=".$_POST["trasparenza"].",seeing_antoniani=".$_POST["seeing_antoniani"].",seeing_pickering=".$_POST["seeing_antoniani"].",id_area_geografica=".$_POST["area_osservazione"]." WHERE ID=".$_POST["id_osservazione2"].";";
                    mysqli_query($conn,$sql) or die("Errore nella query: " . $sql . "\n" . mysqli_error($conn));
                 for($i=1;$i<=$numero_tuple;$i++)
                 { if(isset($_POST["scelta_modifica_elimina".$i]))
                  {
                  if($_POST["rating".$i]==NULL)
                  {
                    $_POST["rating".$i]=-1;
                  }
                 $sql2="UPDATE datiosservazione SET stato='".$_POST["stato".$i]."',rating=".$_POST["rating".$i].",descrizione='".$_POST["descrizione".$i]."',immagine='".$_POST["immagine".$i]."',note='".$_POST["note".$i]."',ora_inizio='".$_POST["ora_inizio".$i]."',ora_fine='".$_POST["ora_fine".$i]."',id_oggettoceleste=".$_POST["oggetto_celeste".$i].", id_strumento=".$_POST["strumento".$i].",id_oculare=".$_POST["oculare".$i].",id_filtro=".$_POST["filtro".$i]." WHERE ID=".$_POST["id_datiosservazione2".$i].";";
                 mysqli_query($conn,$sql2) or die("Errore nella query: " . $sql2 . "\n" . mysqli_error($conn));
                 }
               }
              
                            break;
            case "elimina": 
                          //$sql="DELETE  FROM osservazioni WHERE ID=".$_POST["id_osservazione2"].";";
                          //mysqli_query($conn,$sql) or die("Errore nella query: " . $sql . "\n" . mysqli_error($conn));
                           for($i=1;$i<=$numero_tuple;$i++)
                 {            if(isset($_POST["scelta_modifica_elimina".$i]))
                    {
                            $sql2="DELETE  FROM datiosservazione WHERE ID=".$_POST["id_datiosservazione2".$i].";";          
                            mysqli_query($conn,$sql2) or die("Errore nella query: " . $sql2 . "\n" . mysqli_error($conn));
                    }
                }
           
                            break;
         };//chiudo switch
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
         echo "alert('stai accedendo in modo sbagliato ');";
        echo " </script>";
        header( "Refresh:0; url=prova-sessioni.php", true, 303);
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
