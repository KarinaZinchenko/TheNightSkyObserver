<?php
session_start();
include("config.php");
if(isset($_SESSION["autenticato"])&& isset($_SESSION["tipo"]))
{
	if($_SESSION["tipo"]=="amministratore")
	{
         switch($_POST["scelta_operazione"])
         {
            case "modifica":
                 $sql="UPDATE anagrafica SET nome='".$_POST["nome"]."',cognome='".$_POST["cognome"]."',username='".$_POST["username"]."',password='".$_POST["password"]."',tipo='".$_POST["tipo_utente"]."',scadenza_tessera='".$_POST["data_scadenza_tessera"]."',data_nascita='".$_POST["data_nascita"]."' WHERE numero_socio=".$_POST["id_utente"].";";
                            break;
            case "elimina": 
                            $sql="DELETE  FROM anagrafica WHERE numero_socio=".$_POST["id_utente"].";";
                            break;
            case "riattiva tessera":
                               $aux=substr($_POST["data_scadenza_tessera"], 0, 4);
                               $aux=intval($aux);
                               $aux=$aux+1;
                               $_POST["data_scadenza_tessera"]="".$aux.substr($_POST["data_scadenza_tessera"],4,strlen($_POST["data_scadenza_tessera"])-1);
                              $sql="UPDATE anagrafica SET scadenza_tessera='".$_POST["data_scadenza_tessera"]."' WHERE numero_socio=".$_POST["id_utente"].";";
                          
                        break;
         };//chiudo switch

          if(mysqli_query($conn,$sql))
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
