<?php
ob_start();

session_start();
include("config.php");
include("header.php");
include("navbar.php");
$aux=true;
if (isset($_SESSION["autenticato"]) && isset($_SESSION["tipo"])) {
    if ($_SESSION["tipo"] == "amministratore") {
        switch ($_POST["scelta_operazione"]) {
            case "modifica":
             if($_REQUEST["nome"] != "" & $_REQUEST["tipo"] != "" & $_REQUEST["marca"] != "" & $_REQUEST != ["disponibilita"]){
                $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $conn->prepare("UPDATE strumento SET nome= :nome, note = :note, tipo = :tipo, marca = :marca, disponibilita = :disponibilita, campo_focale = :campoFocale, ingrandimenti = :ingrandimenti, lunghezza_focale = :lunghezzaFocale, montatura = :montatura, focal_ratio = :focalRatio, campo_cercatore = :campoCercatore, tipo_telescopio = :tipoTelescopio, apertura_millimetri = :aperturaMillimetri, apertura_pollici = :aperturaPollici, risoluzione_angolare = :risoluzioneAngolare, stima_potere_risolutivo = :stimaPotereRisolutivo WHERE ID = :IDStrumento");
                $stmt->bindValue(":nome", $_POST["nome"], PDO::PARAM_STR);
                $stmt->bindValue(":note", $_POST["note"], PDO::PARAM_STR);
                $stmt->bindValue(":tipo", $_POST["tipo"], PDO::PARAM_STR);
                $stmt->bindValue(":marca", $_POST["marca"], PDO::PARAM_STR);
                $stmt->bindValue(":disponibilita", $_POST["disponibilita"], PDO::PARAM_INT);
                $stmt->bindValue(":campoFocale", $_POST["campoFocale"], PDO::PARAM_INT);
                $stmt->bindValue(":ingrandimenti", $_POST["ingrandimenti"], PDO::PARAM_INT);
                $stmt->bindValue(":lunghezzaFocale", $_POST["lunghezzaFocale"], PDO::PARAM_INT);
                $stmt->bindValue(":montatura", $_POST["montatura"], PDO::PARAM_INT);
                $stmt->bindValue(":focalRatio", $_POST["focalRatio"], PDO::PARAM_INT);
                $stmt->bindValue(":campoCercatore", $_POST["campoCercatore"], PDO::PARAM_INT);
                $stmt->bindValue(":tipoTelescopio", $_POST["tipoTelescopio"], PDO::PARAM_STR);
                $stmt->bindValue(":aperturaMillimetri", $_POST["aperturaMillimetri"], PDO::PARAM_INT);
                $stmt->bindValue(":aperturaPollici", $_POST["aperturaPollici"], PDO::PARAM_INT);
                $stmt->bindValue(":risoluzioneAngolare", $_POST["risoluzioneAngolare"], PDO::PARAM_INT);
                $stmt->bindValue(":stimaPotereRisolutivo", $_POST["stimaPotereRisolutivo"], PDO::PARAM_INT);
                $stmt->bindValue(":IDStrumento", $_POST["IDStrumento"], PDO::PARAM_INT);
                $result = $stmt->execute();
            }else{
                 ?>
                <script>
                    swal({title:"Attenzione!",text:"Tutti i campi obbligatori, contrassegnati da *, devono essere inseriti.",type:"warning",showConfirmButton:false});
                </script>
                <?php
                header("Refresh:3; url=modificaEliminaStrumento.php", true, 303);
                $aux=false;
            }
                /*
                $sql = "UPDATE anagrafica SET nome='".$_POST["nome"]."',cognome='".$_POST["cognome"]."',username='".$_POST["username"]."',password='".$_POST["password"]."',tipo='".$_POST["tipo_utente"]."',scadenza_tessera='".$_POST["data_scadenza_tessera"]."',data_nascita='".$_POST["data_nascita"]."' WHERE numero_socio=".$_POST["id_utente"].";";
                */
                break;
            case "elimina":
                // In teoria cancellare è sbagliato: meglio impostare disponibilitò a 0 (?)
                $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');
                $stmt = $conn->prepare("UPDATE strumento SET disponibilita = :disponibilita WHERE ID = :IDStrumento");
                $stmt->bindValue(":disponibilita", 0, PDO::PARAM_INT);
                $stmt->bindValue(":IDStrumento", $_POST["IDStrumento"], PDO::PARAM_INT);
                $result = $stmt->execute();
                /*
                $sql = "DELETE  FROM anagrafica WHERE numero_socio=".$_POST["id_utente"].";";
                */
                break;
        }; //chiudo switch
        // if (mysqli_query($conn, $sql)) {
        if($aux)
        {
        if ($result) {
            ?>
            <script>
                swal({title:"Operazione riuscita!",type:"success",showConfirmButton:false});
            </script>
            <?php
            header("Refresh:2; url=modificaEliminaStrumento.php", true, 303);
        } else {
            ?>
            <script>
                swal({title:"Operazione non è andata a buon fine!",type:"error",showConfirmButton:false});
            </script>
            <?php
            header("Refresh:2; url=modificaEliminaStrumento.php", true, 303);
           }
       }
    } else {
        ?>
        <script>
            swal({title:"Oops...!",text:"Non sei autorizzato.",type:"error",showConfirmButton:false});
        </script>
        <?php
        header("Refresh:2; url=profiloUtente.php", true, 303);
    }
} else {
    ?>
    <script>
        swal({title:"Oops...!",text:"Non sei autorizzato.",type:"error",showConfirmButton:false});
    </script>
    <?php
    header("Refresh:2; index.php", true, 303);
}
?>
