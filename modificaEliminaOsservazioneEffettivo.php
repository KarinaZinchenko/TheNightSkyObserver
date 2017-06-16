<?php
ob_start();

session_start();
include("config.php");
include("header.php");
include("navbar.php");
function checkStato($statiOsservazione)
{
    foreach ($statiOsservazione as $stato) {
        if ($stato == "") {
            return false;
        }
    }
    return true;
}

function checkArea($area)
{
    if ($area == "") {
        return false;
    } else {
        return true;
    }
}

function checkResult($risultati)
{
    foreach ($risultati as $risultato) {
        if ($risultato == false) {
            return false;
        }
    }
    return true;
}



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
            $numero_tuple = $_POST["numero_tuple"];
            switch ($_POST["scelta_operazione"]) {
                case "modifica":
                // if ($_REQUEST["categoria"] != "" && $_REQUEST["trasparenza"] != "" && checkStato($_POST['stato']) && checkArea($_POST['area_osservazione']) &&is_numeric($_REQUEST["seeing_antoniani"]) && is_numeric($_REQUEST["seeing_pickering"])) {
                    if ($_REQUEST["categoria"] != "" &&  $_REQUEST["trasparenza"] != "" && checkStato($_POST['stato']) && checkArea($_POST['area_osservazione'])) {
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
                    $sql = "UPDATE osservazioni SET categoria='".$_POST["categoria"]."',trasparenza=".$_POST["trasparenza"].",seeing_antoniani=".$_POST["seeing_antoniani"].",seeing_pickering=".$_POST["seeing_antoniani"].",id_area_geografica=".$_POST["area_osservazione"]." WHERE ID=".$_POST["id_osservazione2"].";";
                    mysqli_query($conn, $sql) or die("Errore nella query: " . $sql . "\n" . mysqli_error($conn));
										*/
                    for ($i = 1; $i <= $numero_tuple; $i++) {
                        if (isset($_POST["scelta_modifica_elimina".$i])) {
                            if ($_POST["rating".$i] == null) {
                                $_POST["rating".$i] = -1;
                            }
                            $stmt = $conn->prepare("UPDATE datiosservazione SET stato= :stato, rating = :rating, descrizione = :descrizione, immagine = :immagine, note = :note, ora_inizio = :oraInizio, ora_fine = :oraFine, id_oggettoceleste = :idOggettoCeleste, id_strumento = :idStrumento, id_oculare = :idOculare, id_filtro = :idFiltro WHERE ID = :idOsservazione");

                            if (!empty($_FILES['immagine'. $i]['name'])) {
                                $caricaImmagine = $cartellaImmagini . basename($_FILES['immagine'. $i]['name']);
                                $explodeFilePath = explode(".", $_FILES['immagine'. $i]['name']);
                                $newFileName = random_str(8);
                                $nuovoNome = $cartellaImmagini .''. $newFileName . '.' . end($explodeFilePath);
                                move_uploaded_file($_FILES['immagine'. $i]['tmp_name'], $nuovoNome);
                            }
                            $stmt->bindValue(":stato", $_POST["stato". $i], PDO::PARAM_STR);
                            if (empty($_POST['rating'. $i])) {
                                $stmt->bindValue(":rating", null, PDO::PARAM_INT);
                            } else {
                                $stmt->bindValue(":rating", $_POST["rating". $i], PDO::PARAM_INT);
                            }
                            if (empty($_POST['descrizione'. $i])) {
                                $stmt->bindValue(":descrizione", null, PDO::PARAM_NULL);
                            } else {
                                $stmt->bindValue(":descrizione", $_POST["descrizione". $i], PDO::PARAM_NULL);
                            }
                            if (!empty($_FILES['immagine'. $i]['name'])) {
                                $stmt->bindValue(":immagine", $nuovoNome, PDO::PARAM_NULL);
                            } else {
                                $stmt->bindValue(":immagine", null, PDO::PARAM_NULL);
                            }
                            if (empty($_POST['note'. $i])) {
                                $stmt->bindValue(":note", null, PDO::PARAM_NULL);
                            } else {
                                $stmt->bindValue(":note", $_POST["note". $i], PDO::PARAM_NULL);
                            }
                            if (empty($_POST['ora_inizio'. $i])) {
                                $stmt->bindValue(":oraInizio", null, PDO::PARAM_NULL);
                            } else {
                                $stmt->bindValue(":oraInizio", $_POST["ora_inizio". $i], PDO::PARAM_NULL);
                            }
                            if (empty($_POST['ora_fine'. $i])) {
                                $stmt->bindValue(":oraFine", null, PDO::PARAM_NULL);
                            } else {
                                $stmt->bindValue(":oraFine", $_POST["ora_fine". $i], PDO::PARAM_NULL);
                            }
                            $stmt->bindValue(":idOggettoCeleste", $_POST["oggetto_celeste". $i], PDO::PARAM_INT);
                            $stmt->bindValue(":idStrumento", $_POST["strumento". $i], PDO::PARAM_INT);
                            if ($_POST['oculare'. $i] == "NULL") {
                                $stmt->bindValue(":idOculare", null, PDO::PARAM_NULL);
                            } else {
                                $stmt->bindValue(":idOculare", $_POST["oculare". $i], PDO::PARAM_NULL);
                            }
                            if ($_POST['filtro'. $i] == "NULL") {
                                $stmt->bindValue(":idFiltro", null, PDO::PARAM_NULL);
                            } else {
                                $stmt->bindValue(":idFiltro", $_POST["filtro". $i], PDO::PARAM_NULL);
                            }
                            $stmt->bindValue(":idOsservazione", $_POST["id_datiosservazione2". $i], PDO::PARAM_INT);
                            $result = $stmt->execute();
                            /*
                            $sql2="UPDATE datiosservazione SET stato='".$_POST["stato".$i]."',rating=".$_POST["rating".$i].",descrizione='".$_POST["descrizione".$i]."',immagine='".$_POST["immagine".$i]."',note='".$_POST["note".$i]."',ora_inizio='".$_POST["ora_inizio".$i]."',ora_fine='".$_POST["ora_fine".$i]."',id_oggettoceleste=".$_POST["oggetto_celeste".$i].", id_strumento=".$_POST["strumento".$i].",id_oculare=".$_POST["oculare".$i].",id_filtro=".$_POST["filtro".$i]." WHERE ID=".$_POST["id_datiosservazione2".$i].";";
                            mysqli_query($conn, $sql2) or die("Errore nella query: " . $sql2 . "\n" . mysqli_error($conn));
														*/
                        }
                    }
                    $aux=false;
                }else
                {?>
                     <script>
                          swal({title:"Oops...!",text:"Tutti i campi obbligatori devono essere completati.",type:"error",showConfirmButton:false});
                      </script>
                      <?php
                      $aux=true;
                      header("Refresh:2; modificaEliminaOsservazione.php", true, 303);
                }

                    break;

                case "elimina":
                          //$sql="DELETE  FROM osservazioni WHERE ID=".$_POST["id_osservazione2"].";";
                          //mysqli_query($conn,$sql) or die("Errore nella query: " . $sql . "\n" . mysqli_error($conn));
                    for ($i = 1; $i <= $numero_tuple; $i++) {
                        if (isset($_POST["scelta_modifica_elimina".$i])) {
                            $sql2="DELETE  FROM datiosservazione WHERE ID=".$_POST["id_datiosservazione2".$i].";";
                            mysqli_query($conn, $sql2) or die("Errore nella query: " . $sql2 . "\n" . mysqli_error($conn));
                        }
                    }
                    break;
            }; //chiudo switch
            if($aux==false)
            {
            ?>
            <script>
              swal({title:"Operazione riuscita!",type:"success",showConfirmButton:false});
            </script>
            <?php
            header("Refresh:2; url=modificaEliminaOsservazione.php", true, 303);}
        } else {
            ?>
            <script>
              swal({title:"Attenzione!",text:"Accesso errato alla pagina.",type:"warning",showConfirmButton:false});
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
