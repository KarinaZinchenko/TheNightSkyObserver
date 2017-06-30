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
        switch($_POST["scelta_operazione"])
         {
            case "modifica":
            if ($_REQUEST["nome"] != "" && $_REQUEST["marca"] != "" && $_REQUEST["disponibilita"] != "" && $_REQUEST["dimensione"] != "" && $_REQUEST["lunghezza_focale"] != "" && $_REQUEST["campo_visione_apparente"]!=""){
                 $sql="UPDATE oculare SET nome='".$_POST["nome"]."',marca='".$_POST["marca"]."',descrizione='".$_POST["descrizione"]."',disponibilita=".$_POST["disponibilita"].",note='".$_POST["note"]."',dimensione=".$_POST["dimensione"].",lunghezza_focale=".$_POST["lunghezza_focale"].",campo_visione_apparente=".$_POST["campo_visione_apparente"]." WHERE ID=".$_POST["id_oculare"].";";
                  }else
                          {
                             ?>
                <script>
                    swal({title:"Attenzione!",text:"Tutti i campi obbligatori, contrassegnati da *, devono essere inseriti.",type:"warning",showConfirmButton:false});
                </script>
                <?php
                header("Refresh:3; url=modificaEliminaOculare.php", true, 303);
                $aux=false;
                          }
                            break;
            case "elimina": 
                            $sql="DELETE  FROM oculare WHERE ID=".$_POST["id_oculare"].";";
                         
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
              header("Refresh:2; url=modificaEliminaOculare.php", true, 303);
          }
          else
          {
              ?>
              <script>
                  swal({title:"Operazione non è andata a buon fine!",type:"error",showConfirmButton:false});
              </script>
              <?php
              header("Refresh:2; url=modificaEliminaOculare.php", true, 303);
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
