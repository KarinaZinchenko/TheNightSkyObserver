<?php
ob_start();

session_start();
include("config.php");
include("header.php");
include("navbar.php");

function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[rand(0, $max)];
    }
    return $str;
}

if (isset($_SESSION["autenticato"]) && isset($_SESSION["tipo"])) {
    if ($_SESSION["tipo"] == "amministratore" || $_SESSION["tipo"] == "regolare") {
        if (isset($_POST["scelta_operazione"])) {
            $cartellaImmagini = "immagini/";
            switch ($_POST["scelta_operazione"]) {
                case "modifica":
                    $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt = $conn->prepare("UPDATE osservazioni SET categoria= :categoria, trasparenza = :trasparenza, seeing_antoniani = :seeingAntoniani, seeing_pickering = :seeingPickering, id_area_geografica = :idAreaGeografica WHERE ID = :idOsservazione");
                    $stmt->bindValue(":categoria", $_POST["categoria"], PDO::PARAM_STR);
                    $stmt->bindValue(":trasparenza", $_POST["trasparenza"], PDO::PARAM_INT);
                    $stmt->bindValue(":seeingAntoniani", $_POST["seeing_antoniani"], PDO::PARAM_INT);
                    $stmt->bindValue(":seeingPickering", $_POST["seeing_pickering"], PDO::PARAM_INT);
                    $stmt->bindValue(":idAreaGeografica", $_POST["area_osservazione"], PDO::PARAM_INT);
                    $stmt->bindValue(":idOsservazione", $_POST["id_osservazione2"], PDO::PARAM_INT);
                    $result = $stmt->execute();
                    /*
                    $sql="UPDATE osservazioni SET categoria='".$_POST["categoria"]."',trasparenza=".$_POST["trasparenza"].",seeing_antoniani=".$_POST["seeing_antoniani"].",seeing_pickering=".$_POST["seeing_antoniani"].",id_area_geografica=".$_POST["area_osservazione"]." WHERE ID=".$_POST["id_osservazione2"].";";
                    mysqli_query($conn, $sql) or die("Errore nella query: " . $sql . "\n" . mysqli_error($conn));
										*/
                    if ($_POST["rating"] == null) {
                        $_POST["rating"] = -1;
                    }
                    $stmt = $conn->prepare("UPDATE datiosservazione SET stato= :stato, rating = :rating, descrizione = :descrizione, immagine = :immagine, note = :note, ora_inizio = :oraInizio, ora_fine = :oraFine, id_oggettoceleste = :idOggettoCeleste, id_strumento = :idStrumento, id_oculare = :idOculare, id_filtro = :idFiltro WHERE ID = :idOsservazione");

                    if (!empty($_FILES['immagine']['name'])) {
                        $caricaImmagine = $cartellaImmagini . basename($_FILES['immagine']['name']);
                        $explodeFilePath = explode(".", $_FILES['immagine']['name']);
                        $newFileName = random_str(8);
                        $nuovoNome = $cartellaImmagini .''. $newFileName . '.' . end($explodeFilePath);
                        move_uploaded_file($_FILES['immagine']['tmp_name'], $nuovoNome);
                    }
                    $stmt->bindValue(":stato", $_POST["stato"], PDO::PARAM_STR);
                    if (empty($_POST['rating'])) {
                        $stmt->bindValue(":rating", null, PDO::PARAM_INT);
                    } else {
                        $stmt->bindValue(":rating", $_POST["rating"], PDO::PARAM_INT);
                    }
                    if (empty($_POST['descrizione'])) {
                        $stmt->bindValue(":descrizione", null, PDO::PARAM_NULL);
                    } else {
                        $stmt->bindValue(":descrizione", $_POST["descrizione"], PDO::PARAM_NULL);
                    }
                    if (!empty($_FILES['immagine']['name'])) {
                        $stmt->bindValue(":immagine", $nuovoNome, PDO::PARAM_NULL);
                    } else {
                        $stmt->bindValue(":immagine", null, PDO::PARAM_NULL);
                    }
                    if (empty($_POST['note'])) {
                        $stmt->bindValue(":note", null, PDO::PARAM_NULL);
                    } else {
                        $stmt->bindValue(":note", $_POST["note"], PDO::PARAM_NULL);
                    }
                    if (empty($_POST['ora_inizio'])) {
                        $stmt->bindValue(":oraInizio", null, PDO::PARAM_NULL);
                    } else {
                        $stmt->bindValue(":oraInizio", $_POST["ora_inizio"], PDO::PARAM_NULL);
                    }
                    if (empty($_POST['ora_fine'])) {
                        $stmt->bindValue(":oraFine", null, PDO::PARAM_NULL);
                    } else {
                        $stmt->bindValue(":oraFine", $_POST["ora_fine"], PDO::PARAM_NULL);
                    }
                    $stmt->bindValue(":idOggettoCeleste", $_POST["oggetto_celeste"], PDO::PARAM_INT);
                    $stmt->bindValue(":idStrumento", $_POST["strumento"], PDO::PARAM_INT);
                    if ($_POST['oculare'. $i] == "NULL") {
                        $stmt->bindValue(":idOculare", null, PDO::PARAM_NULL);
                    } else {
                        $stmt->bindValue(":idOculare", $_POST["oculare"], PDO::PARAM_NULL);
                    }
                    if ($_POST['filtro'] == "NULL") {
                        $stmt->bindValue(":idFiltro", null, PDO::PARAM_NULL);
                    } else {
                        $stmt->bindValue(":idFiltro", $_POST["filtro"], PDO::PARAM_NULL);
                    }
                    $stmt->bindValue(":idOsservazione", $_POST["id_datiosservazione2"], PDO::PARAM_INT);
                    $result = $stmt->execute();
                    /*
                    $sql2="UPDATE datiosservazione SET stato='".$_POST["stato"]."',rating=".$_POST["rating"].",descrizione='".$_POST["descrizione"]."',immagine='".$_POST["immagine"]."',note='".$_POST["note"]."',ora_inizio='".$_POST["ora_inizio"]."',ora_fine='".$_POST["ora_fine"]."',id_oggettoceleste=".$_POST["oggetto_celeste"].", id_strumento=".$_POST["strumento"].",id_oculare=".$_POST["oculare"].",id_filtro=".$_POST["filtro"]." WHERE ID=".$_POST["id_datiosservazione2"].";";
                    mysqli_query($conn, $sql2) or die("Errore nella query: " . $sql2 . "\n" . mysqli_error($conn));
										*/
                    break;
                case "elimina":
                          //$sql="DELETE  FROM osservazioni WHERE ID=".$_POST["id_osservazione2"].";";
                          //mysqli_query($conn,$sql) or die("Errore nella query: " . $sql . "\n" . mysqli_error($conn));

                            $sql2="DELETE  FROM datiosservazione WHERE ID=".$_POST["id_datiosservazione2"].";";
                            mysqli_query($conn, $sql2) or die("Errore nella query: " . $sql2 . "\n" . mysqli_error($conn));
                            break;
            };//chiudo switch
          ?>
          <script>
              swal({title:"Operazione riuscita!",type:"success",showConfirmButton:false});
          </script>
          <?php
          header( "Refresh:2; url=profiloUtente.php", true, 303);
      }
      else
      {
          ?>
          <script>
              swal({title:"Attenzione!",text:"Accesso errato alla pagina.",type:"warning",showConfirmButton:false});
          </script>
          <?php
        header( "Refresh:2; url=profiloUtente.php", true, 303);
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
} else {
    ?>
    <script>
        swal({title:"Oops...!",text:"Non sei autorizzato.",type:"error",showConfirmButton:false});
    </script>
    <?php
    header("Refresh:2; index.php", true, 303);
}
?>
