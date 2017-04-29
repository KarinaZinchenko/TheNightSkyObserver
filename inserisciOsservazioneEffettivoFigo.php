<?php
session_start();
include("config.php");

function checkStato($statiOsservazione)
{
    foreach ($statiOsservazione as $stato) {
        if ($stato == "") {
            return false;
        }
    }
    return true;
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

if (isset($_SESSION['autenticato']) && isset($_SESSION['tipo'])) {
    if ($_SESSION['tipo'] == 'regolare' || $_SESSION['tipo'] == 'amministratore') {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if ($_REQUEST["categoria"] != "" && $_REQUEST["trasparenza"] != "" && checkStato($_POST['stato'])) {
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
                $matriceOsservazioni = array($_POST['stato'], $_POST['rating'], $_POST['descrizione'], $_POST['immagine'], $_POST['note'], $_POST['ora_inizio'], $_POST['ora_fine'], $_POST['oggetto_celeste'], $_POST['strumento'], $_POST['oculare'], $_POST['filtro'], $_POST['id_utente']) ;
                // echo "<pre>";
                // print_r($_POST);
                // echo "</pre>";
                $numeroCampi = count($matriceOsservazioni);
                $numeroOsservazioni = count($matriceOsservazioni[0]);
                $risultati = [];
                // matrice osservazioni [campo][osservazione]
                for ($i = 0; $i < $numeroOsservazioni; $i++) {
                    $stato = $matriceOsservazioni[0][$i];
                    $rating = $matriceOsservazioni[1][$i];
                    $descrizione = $matriceOsservazioni[2][$i];
                    $immagine = $matriceOsservazioni[3][$i];
                    $note = $matriceOsservazioni[4][$i];
                    $oraInizio = $matriceOsservazioni[5][$i];
                    $oraFine = $matriceOsservazioni[6][$i];
                    $oggettoCeleste = $matriceOsservazioni[7][$i];
                    $strumento = $matriceOsservazioni[8][$i];
                    $oculare = $matriceOsservazioni[9][$i];
                    $filtro = $matriceOsservazioni[10][$i];
                    $idUtente = $matriceOsservazioni[11][$i];

                    if (empty($rating)) {
                        $rating = 0;
                    }
                    if (empty($descrizione)) {
                        $descrizione = null;
                    }
                    if (empty($immagine)) {
                        $immagine = null;
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
                    $stmt->bindValue(":immagine", $immagine, PDO::PARAM_NULL);
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
                    echo "<script language='javascript'>";
                    echo "alert('Inserimento effettuato');";
                    echo "</script>";
                    header("Refresh:0; url=prova-sessioni.php", true, 303);
                } else {
                    echo "<script language='javascript'>";
                    echo "alert('Errore nella query');";
                    echo "</script>";
                    header("Refresh:0; url=inserisciOsservazioneFigo.php", true, 303);
                }
            } else {
                echo "<script language='javascript'>";
                echo "alert('I campi obbligatori devono essere inseriti');";
                echo "</script>";
                echo "<a href='inserisciOsservazione.php'>Torna alla pagina per inserire l'osservazione</a> ";
            }
        } else {
            echo "Accesso errato alla pagina. <a href='prova-sessioni.php'>Torna alla pagina personale </a>";
        }
    } else {
        echo "<script language='javascript'>";
        echo "alert('Non sei autorizzato ');";
        echo "</script>";
        header("Refresh:0; url=prova-sessioni.php", true, 303);
    }
} else {
    echo "<script language='javascript'>";
    echo "alert('Non sei autorizzato ');";
    echo "</script>";
    header("Refresh:0; url=prova-sessioni.php", true, 303);
}
