<?php
ob_start();

session_start();
include("config.php");
include("header.php");
include("navbar.php");
$aux=true;
if(isset($_SESSION["autenticato"])&& isset($_SESSION["tipo"]))
{
	if($_SESSION["tipo"]=="amministratore")
	{
    if($_POST["password"]!=$_POST["password_utente"])
    {
      $password=md5($_POST["password"]);
    }
    else
    {
      $password=$_POST["password"];
    }
         switch($_POST["scelta_operazione"])
         {
            case "modifica":
             if ($_REQUEST["nome"] != "" && $_REQUEST["cognome"] != "" && $_REQUEST["username"] != "" && $_REQUEST["password"] != "" && $_REQUEST["tipo_utente"] != "" && $_REQUEST["scadenza_tessera"] != "" && $_REQUEST["data_nascita"] != ""){
                 $sql="UPDATE anagrafica SET nome='".$_POST["nome"]."',cognome='".$_POST["cognome"]."',username='".$_POST["username"]."',password='".$password."',tipo='".$_POST["tipo_utente"]."',scadenza_tessera='".$_POST["scadenza_tessera"]."',data_nascita='".$_POST["data_nascita"]."' WHERE numero_socio=".$_POST["id_utente"].";";
                }else{  ?>
                <script>
                    swal({title:"Attenzione!",text:"Tutti i campi obbligatori, contrassegnati da *, devono essere inseriti.",type:"warning",showConfirmButton:false});
                </script>
                <?php
                header("Refresh:3; url=modificaEliminaUtente.php", true, 303);
                $aux=false;
            }


                            break;
             
            case "elimina": 
                            $sql="DELETE  FROM anagrafica WHERE numero_socio=".$_POST["id_utente"].";";
                            break;
           case "riattiva tessera":
           					$scadenza=$_POST["scadenza_tessera"];
           					$nuova_scadenza=date('Y-m-d',strtotime($scadenza . " + 365 day"));
                            //echo "<script>console.log('".$scadenza."');</script>";
                            //echo "<script>console.log('".$nuova_scadenza."');</script>";                            
                              if($_POST["tipo_utente"]=="amministratore"){                            
                                  $sql="UPDATE anagrafica SET scadenza_tessera='".$nuova_scadenza."' WHERE numero_socio=".$_POST["id_utente"].";";
                              }
                              else{                            
                                  $sql="UPDATE anagrafica SET tipo='regolare',scadenza_tessera='".$nuova_scadenza."' WHERE numero_socio=".$_POST["id_utente"].";";
                              }
                            
                            /*
                            $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $stmt = $conn->prepare("UPDATE anagrafica SET tipo= :tipo, scadenza_tessera = :scadenza_tessera WHERE numero_socio = :id_utente");
                            //print_r($conn->errorInfo());
                            $stmt->bindValue(":tipo", "regolare", PDO::PARAM_STR);
                            $stmt->bindValue(":scadenza_tessera", $nuova_scadenza->format('Y-m-d'), PDO::PARAM_STR);
                            $stmt->bindValue(":id_utente", $_POST["id_utente"], PDO::PARAM_INT);
                            $result = $stmt->execute();
                            echo "<script>console.log('".$result."');</script>";*/
                            break;
         };//chiudo switch
  if($aux){
         if(mysqli_query($conn,$sql))
          {
              ?>
              <script>
                  swal({title:"Operazione riuscita!",type:"success",showConfirmButton:false});
              </script>
              <?php
              header("Refresh:2; url=modificaEliminaUtente.php", true, 303);
          }
          else
          {
              ?>
              <script>
                  swal({title:"Operazione non è andata a buon fine!",type:"error",showConfirmButton:false});
              </script>
              <?php
              header("Refresh:2; url=modificaEliminaUtente.php", true, 303);
          }
       }
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

?>
