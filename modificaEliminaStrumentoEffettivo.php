<?php
session_start();
include("config.php");
if (isset($_SESSION["autenticato"]) && isset($_SESSION["tipo"])) {
    if ($_SESSION["tipo"] == "amministratore") {
        switch ($_POST["scelta_operazione"]) {
            case "modifica":
                $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $conn->prepare("UPDATE strumento SET nome= :nome, note = :note, tipo = :tipo, marca = :marca, disponibilita = :disponibilita, apertura = :apertura, campo_focale = :campoFocale, ingrandimenti = :ingrandimenti, lunghezza_focale = :lunghezzaFocale, montatura = :montatura, focal_ratio = :focalRatio, campo_cercatore = :campoCercatore, tipo_telescopio = :tipoTelescopio, apertura_millimetri = :aperturaMillimetri, apertura_pollici = :aperturaPollici, risoluzione_angolare = :risoluzioneAngolare, stima_potere_risolutivo = :stimaPotereRisolutivo WHERE ID = :IDStrumento");
                $stmt->bindValue(":nome", $_POST["nome"], PDO::PARAM_STR);
                $stmt->bindValue(":note", $_POST["note"], PDO::PARAM_STR);
                $stmt->bindValue(":tipo", $_POST["tipo"], PDO::PARAM_STR);
                $stmt->bindValue(":marca", $_POST["marca"], PDO::PARAM_STR);
                $stmt->bindValue(":disponibilita", $_POST["disponibilita"], PDO::PARAM_INT);
                $stmt->bindValue(":apertura", $_POST["apertura"], PDO::PARAM_INT);
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
        if ($result) {
            echo "<script language='javascript'>";
            echo "alert('Operazione Riuscita');";
            echo "</script>";
            //echo "<a href='prova-sessioni.php'>Torna alla pagina personale </a> ";
            header("Refresh:0; url=prova-sessioni.php", true, 303);
            // header("Location:prova-sessioni.php");
        } else {
            echo "<script language='javascript'>";
            echo "alert('Operazione non andata a buon fine');";
            echo "</script>";
            // echo "Errore nella query: " . $sql . "<br>" . mysqli_error($conn);
            echo"<br><br>";
            // header("Refresh:0; url=prova-sessioni.php", true, 303);
            //  header("Location:prova-sessioni.php");
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
    header("Refresh:0; index.php", true, 303);
}
