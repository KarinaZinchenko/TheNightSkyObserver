<?php
session_start();
include("config.php");
if (isset($_SESSION["autenticato"]) && isset($_SESSION["tipo"])) {
    if ($_SESSION["tipo"] == "amministratore") {
        if (!isset($_POST["invio"])) {
        ?>
        <html>
        <head>
          <title>Inserimento nuovo sito osservativo </title>
         </head>
         <body>
           <center>
             <h1>Inserisci i dati del sito osservativo in questione:</h1>  <br><br>
             <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" >
               Nome: <input type="text" name="nome"><br><br>
               Note: <input type="text" name="note"><br><br>
               Tipo: <input type="text" name="tipo"><br><br>
               Marca: <input type="text" name="marca"><br><br>
               Disponibilit&agrave;: <input type="text" name="disponibilita"><br><br>
               Apertura: <input type="text" name="apertura"><br><br>
               Campo focale: <input type="text" name="campoFocale"><br><br>
               Ingrandimenti: <input type="text" name="ingrandimenti"><br><br>
               Lunghezza focale: <input type="text" name="lunghezzaFocale"><br><br>
               Montatura: <input type="text" name="montatura"><br><br>
               Focal Ratio: <input type="text" name="focalRatio"><br><br>
               Campo del cercatore: <input type="text" name="campoCercatore"><br><br>
               Tipo di telescopio: <input type="text" name="tipoTelescopio"><br><br>
               Apertura (in millimetri): <input type="text" name="aperturaMillimetri"><br><br>
               Apertura (in pollici): <input type="text" name="aperturaPollici"><br><br>
               Risoluzione angolare: <input type="text" name="risoluzioneAngolare"><br><br>
               Stima potere risolutivo: <input type="text" name="stimaPotereRisolutivo"><br><br>
                 <input type="submit" name="invio" value="inserisci">
             </form>
           </center>
         </body>
         </html>
        <?php
        } else {// chiudo if per verificare se accedo alla pagina prima volta o se ho gia inserito dati
            $nome = "";
            $note = "";
            $tipo = "";
            $marca = "";
            $disponibilita = "";
            $apertura = "";
            $campoFocale = "";
            $ingrandimenti = "";
            $lunghezzaFocale = "";
            $montatura = "";
            $focalRatio = "";
            $campoCercatore = "";
            $tipoTelescopio = "";
            $aperturaMillimetri = "";
            $aperturaPollici = "";
            $risoluzioneAngolare = "";
            $stimaPotereRisolutivo = "";
            if ($_REQUEST["nome"] != "" & $_REQUEST["tipo"] != "" & $_REQUEST["marca"] != "" & $_REQUEST != ["disponibilita"]) {
                $nome = $_REQUEST["nome"];
                $note = $_REQUEST["note"];
                $tipo = $_REQUEST["tipo"];
                $marca = $_REQUEST["marca"];
                $disponibilita = $_REQUEST["disponibilita"];
                $apertura = $_REQUEST["apertura"];
                $campoFocale = $_REQUEST["campoFocale"];
                $ingrandimenti = $_REQUEST["ingrandimenti"];
                $lunghezzaFocale = $_REQUEST["lunghezzaFocale"];
                $montatura = $_REQUEST["montatura"];
                $focalRatio = $_REQUEST["focalRatio"];
                $campoCercatore = $_REQUEST["campoCercatore"];
                $tipoTelescopio = $_REQUEST["tipoTelescopio"];
                $aperturaMillimetri = $_REQUEST["aperturaMillimetri"];
                $aperturaPollici = $_REQUEST["aperturaPollici"];
                $risoluzioneAngolare = $_REQUEST["risoluzioneAngolare"];
                $stimaPotereRisolutivo = $_REQUEST["stimaPotereRisolutivo"];

                $nome = nl2br(htmlentities($nome, ENT_QUOTES, 'UTF-8'));
                $note = nl2br(htmlentities($note, ENT_QUOTES, 'UTF-8'));
                $tipo = nl2br(htmlentities($tipo, ENT_QUOTES, 'UTF-8'));
                $marca = nl2br(htmlentities($marca, ENT_QUOTES, 'UTF-8'));
                $disponibilita = nl2br(htmlentities($disponibilita, ENT_QUOTES, 'UTF-8'));
                $apertura = nl2br(htmlentities($apertura, ENT_QUOTES, 'UTF-8'));
                $campoFocale = nl2br(htmlentities($campoFocale, ENT_QUOTES, 'UTF-8'));
                $ingrandimenti = nl2br(htmlentities($ingrandimenti, ENT_QUOTES, 'UTF-8'));
                $lunghezzaFocale = nl2br(htmlentities($lunghezzaFocale, ENT_QUOTES, 'UTF-8'));
                $montatura = nl2br(htmlentities($montatura, ENT_QUOTES, 'UTF-8'));
                $focalRatio = nl2br(htmlentities($focalRatio, ENT_QUOTES, 'UTF-8'));
                $campoCercatore = nl2br(htmlentities($campoCercatore, ENT_QUOTES, 'UTF-8'));
                $tipoTelescopio = nl2br(htmlentities($tipoTelescopio, ENT_QUOTES, 'UTF-8'));
                $aperturaMillimetri = nl2br(htmlentities($aperturaMillimetri, ENT_QUOTES, 'UTF-8'));
                $aperturaPollici = nl2br(htmlentities($aperturaPollici, ENT_QUOTES, 'UTF-8'));
                $risoluzioneAngolare = nl2br(htmlentities($risoluzioneAngolare, ENT_QUOTES, 'UTF-8'));
                $stimaPotereRisolutivo = nl2br(htmlentities($stimaPotereRisolutivo, ENT_QUOTES, 'UTF-8'));

                /*
                $sql = "INSERT INTO strumento(nome, note, tipo, marca, disponibilita, apertura, campo_focale, ingrandimenti, lunghezza_focale, montatura, focal_ratio, campo_cercatore, tipo_telescopio, apertura_millimetri, apertura_pollici, risoluzione_angolare, stima_potere_risolutivo) VALUES ('".addslashes($nome)."','".addslashes($note)."','".addslashes($tipo)."','".addslashes($marca)."',".addslashes($disponibilita).",".addslashes($apertura).",".addslashes($campoFocale).",".addslashes($ingrandimenti).",".addslashes($lunghezzaFocale).",".addslashes($montatura).",".addslashes($focalRatio).",".addslashes($campoCercatore).",'".addslashes($tipoTelescopio)."',".addslashes($aperturaMillimetri).",".addslashes($aperturaPollici).",".addslashes($risoluzioneAngolare).",".addslashes($stimaPotereRisolutivo).");";
                */
                /*
                  Nel caso volessimo usare PDO invece di questo mostro qui sopra
                */
                $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');
                $stmt = $conn->prepare("INSERT INTO strumento(nome, note, tipo, marca, disponibilita, apertura, campo_focale, ingrandimenti, lunghezza_focale, montatura, focal_ratio, campo_cercatore, tipo_telescopio, apertura_millimetri, apertura_pollici, risoluzione_angolare, stima_potere_risolutivo) VALUES (:nome, :note, :tipo, :marca, :disponibilita, :apertura, :campoFocale, :ingrandimenti, :lunghezzaFocale, :montatura, :focalRatio, :campoCercatore, :tipoTelescopio, :aperturaMillimetri, :aperturaPollici, :risoluzioneAngolare, :stimaPotereRisolutivo)");
                $stmt->bindValue(":nome", $nome, PDO::PARAM_STR);
                $stmt->bindValue(":note", $note, PDO::PARAM_NULL);
                $stmt->bindValue(":tipo", $tipo, PDO::PARAM_STR);
                $stmt->bindValue(":marca", $marca, PDO::PARAM_STR);
                $stmt->bindValue(":disponibilita", $disponibilita, PDO::PARAM_INT);
                $stmt->bindValue(":apertura", $apertura, PDO::PARAM_INT);
                $stmt->bindValue(":campoFocale", $campoFocale, PDO::PARAM_INT);
                $stmt->bindValue(":ingrandimenti", $ingrandimenti, PDO::PARAM_INT);
                $stmt->bindValue(":lunghezzaFocale", $lunghezzaFocale, PDO::PARAM_INT);
                // Sicuri che montatura sia un numero?
                $stmt->bindValue(":montatura", $montatura, PDO::PARAM_INT);
                $stmt->bindValue(":focalRatio", $focalRatio, PDO::PARAM_INT);
                $stmt->bindValue(":campoCercatore", $campoCercatore, PDO::PARAM_INT);
                $stmt->bindValue(":tipoTelescopio", $tipoTelescopio, PDO::PARAM_STR);
                $stmt->bindValue(":aperturaMillimetri", $aperturaMillimetri, PDO::PARAM_INT);
                $stmt->bindValue(":aperturaPollici", $aperturaPollici, PDO::PARAM_INT);
                $stmt->bindValue(":risoluzioneAngolare", $risoluzioneAngolare, PDO::PARAM_INT);
                $stmt->bindValue(":stimaPotereRisolutivo", $stimaPotereRisolutivo, PDO::PARAM_INT);
                $result = $stmt->execute();
                if ($result) {
                    echo "<script language='javascript'>";
                    echo "alert('Inserimento effettuato');";
                    echo "</script>";
                    header("Refresh:0; url=prova-sessioni.php", true, 303);
                } else {
                    echo "<script language='javascript'>";
                    echo "alert('Errore nella query');";
                    echo "</script>";
                    header("Refresh:0; url=inserisciArea.php", true, 303);
                }
                $conn = null;
                $stmt = null;
                /*
                if (mysqli_query($conn, $sql)) {
                    echo "<script language='javascript'>";
                    echo "alert('Inserimento effettuato');";
                    echo "</script>";
                    header("Refresh:0; url=prova-sessioni.php", true, 303);
                } else {
                    die("Errore nella query: ". $sql ."\n" . mysqli_error($conn));
                }
                mysqli_close($conn);
                */
            } else { //chiudo if per verificare che i campi siano stati inseriti
                echo "<script language='javascript'>";
                echo "alert('I campi nome, tipo, marca e disponibilità sono obbligatori');";
                echo "</script>";
                header("Refresh:0; url=inserisciStrumento.php", true, 303);
            }
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
?>
