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

if (isset($_SESSION['autenticato']) && isset($_SESSION['tipo'])) {
    if ($_SESSION['tipo'] == 'regolare' || $_SESSION['tipo'] == 'amministratore') {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if ($_REQUEST["categoria"] != "" && $_REQUEST["trasparenza"] != "" && checkStato($_POST['stato']) && checkArea($_POST['area_osservazione'])) {
                $categoria = $_POST['categoria'];
                $trasparenza = $_POST['trasparenza'];
                $seeingAntoniani = $_POST['seeing_antoniani'];
                $seeingPickering = $_POST['seeing_pickering'];
                $idAreaGeografica = $_POST['area_osservazione'];
                $idAnagrafica = $_POST['id_utente'][0];
                $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
                $stmt = $conn->prepare("INSERT INTO osservazioni(categoria, trasparenza, seeing_antoniani, seeing_pickering, id_area_geografica, id_anagrafica) VALUES (:categoria, :trasparenza, :seeing_antoniani, :seeing_pickering, :id_area_geografica, :id_anagrafica)");
                $stmt->bindValue(":categoria", $categoria, PDO::PARAM_STR);
                $stmt->bindValue(":trasparenza", $trasparenza, PDO::PARAM_INT);
                $stmt->bindValue(":seeing_antoniani", $seeingAntoniani, PDO::PARAM_INT);
                $stmt->bindValue(":seeing_pickering", $seeingPickering, PDO::PARAM_STR);
                $stmt->bindValue(":id_area_geografica", $idAreaGeografica, PDO::PARAM_STR);
                $stmt->bindValue(":id_anagrafica", $idAnagrafica, PDO::PARAM_STR);
                $result = $stmt->execute();
                /*
                if ($result) {
                    echo "<script language='javascript'>";
                    echo "alert('Inserimento effettuato');";
                    echo "</script>";
                    header("Refresh:0; url=prova-sessioni.php", true, 303);
                } else {
                    echo "<script language='javascript'>";
                    echo "alert('Errore nella query');";
                    echo "</script>";
                    header("Refresh:0; url=inserisciStrumento.php", true, 303);
                }
                */
                $idOsservazioni = $conn->lastInsertId();
                // Devo combinare tutti gli array della specifica osservazione, formare una matrice ed accedervi per colonne
                $matriceOsservazioni = array($_POST['stato'], $_POST['rating'], $_POST['descrizione'], $_POST['note'], $_POST['ora_inizio'], $_POST['ora_fine'], $_POST['oggetto_celeste'], $_POST['strumento'], $_POST['oculare'], $_POST['filtro'], $_POST['id_utente']) ;
                // echo "<pre>";
                // print_r($_POST);
                // echo "</pre>";
                $numeroCampi = count($matriceOsservazioni);
                $numeroOsservazioni = count($matriceOsservazioni[0]);
                $risultati = [];

                $cartellaImmagini = "immagini/";
                // matrice osservazioni [campo][osservazione]
                for ($i = 0; $i < $numeroOsservazioni; $i++) {
                    $stato = $matriceOsservazioni[0][$i];
                    $rating = $matriceOsservazioni[1][$i];
                    $descrizione = $matriceOsservazioni[2][$i];
                    $note = $matriceOsservazioni[3][$i];
                    $oraInizio = $matriceOsservazioni[4][$i];
                    $oraFine = $matriceOsservazioni[5][$i];
                    $oggettoCeleste = $matriceOsservazioni[6][$i];
                    $strumento = $matriceOsservazioni[7][$i];
                    $oculare = $matriceOsservazioni[8][$i];
                    $filtro = $matriceOsservazioni[9][$i];
                    $idUtente = $matriceOsservazioni[10][$i];

                    if (!empty($_FILES['immagine']['name'][$i])) {
                        $caricaImmagine = $cartellaImmagini . basename($_FILES['immagine']['name'][$i]);
                        $explodeFilePath = explode(".", $_FILES['immagine']['name'][$i]);
                        $newFileName = random_str(8);
                        $nuovoNome = $cartellaImmagini .''. $newFileName . '.' . end($explodeFilePath);
                        move_uploaded_file($_FILES['immagine']['tmp_name'][$i], $nuovoNome);
                    }

                    if (empty($rating)) {
                        $rating = 0;
                    }
                    if (empty($descrizione)) {
                        $descrizione = null;
                    }
                    if (empty($note)) {
                        $note = null;
                    }
                    if (empty($oraInizio)) {
                        $oraInizio = null;
                    }
                    if (empty($oraFine)) {
                        $oraFine = null;
                    }
                    if ($oculare == "NULL") {
                        $oculare = null;
                    }
                    if ($filtro == "NULL") {
                        $filtro = null;
                    }

                    // INSERT INTO blablabla
                    // $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');
                    $stmt = $conn->prepare("INSERT INTO datiosservazione(stato, rating, descrizione, immagine, note, ora_fine, ora_inizio, id_oggettoceleste, id_strumento, id_osservazioni, id_oculare, id_filtro) VALUES (:stato, :rating, :descrizione, :immagine, :note, :ora_fine, :ora_inizio, :id_oggettoceleste, :id_strumento, :id_osservazioni, :id_oculare, :id_filtro)");
                    $stmt->bindValue(":stato", $stato, PDO::PARAM_STR);
                    $stmt->bindValue(":rating", $rating, PDO::PARAM_INT);
                    $stmt->bindValue(":descrizione", $descrizione, PDO::PARAM_NULL);
                    if (!empty($_FILES['immagine']['name'][$i])) {
                        $stmt->bindValue(":immagine", $nuovoNome, PDO::PARAM_NULL);
                    } else {
                        $stmt->bindValue(":immagine", null, PDO::PARAM_NULL);
                    }
                    $stmt->bindValue(":note", $note, PDO::PARAM_NULL);
                    $stmt->bindValue(":ora_fine", $oraFine, PDO::PARAM_NULL);
                    $stmt->bindValue(":ora_inizio", $oraInizio, PDO::PARAM_NULL);
                    $stmt->bindValue(":id_oggettoceleste", $oggettoCeleste, PDO::PARAM_INT);
                    $stmt->bindValue(":id_strumento", $strumento, PDO::PARAM_INT);
                    $stmt->bindValue(":id_osservazioni", $idOsservazioni, PDO::PARAM_INT);
                    $stmt->bindValue(":id_oculare", $oculare, PDO::PARAM_NULL);
                    $stmt->bindValue(":id_filtro", $filtro, PDO::PARAM_NULL);
                    $result = $stmt->execute();
                    $risultati[] = $result;
                }
                if (checkResult($risultati)) {
                    ?>
                    <script>
                    swal({title:"Inserimento effettuato!",type:"success",showConfirmButton:false});
                    </script>
                    <?php
                    header("Refresh:2; url=inserisciOsservazione.php", true, 303);
                } else {
                    ?>
                    <script>
                        swal({title:"Attenzione!",text:"Errore nella query.",type:"warning",showConfirmButton:false});
                    </script>
                    <?php
                    header("Refresh:2; url=inserisciOsservazione.php", true, 303);
                }
            } else {
                ?>
                <script>
                    swal({title:"Attenzione!",text:"Tutti i campi obbligatori, contrassegnati da *, devono essere inseriti.",type:"warning",showConfirmButton:false});
                </script>
                <?php
                header("Refresh:3; url=inserisciOsservazione.php", true, 303);
            }
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
