<?php
session_start();
include("config.php");
if (isset($_SESSION["autenticato"]) && isset($_SESSION["tipo"])) {
    if ($_SESSION["tipo"] == "amministratore") {
        if (!isset($_POST["invio"])) {
        ?>
        <html>
        <head>
          <title>Inserimento nuovo strumento</title>
          <script type="text/javascript" language="javascript">
            /* Codice abbastanza brutto */
            function mostraCampi(x) {
              if (x.value == "Binocolo") {
                document.getElementById("formCampoFocale").style.display = "none";
                document.getElementById("formLunghezzaFocale").style.display = "none";
                document.getElementById("formMontatura").style.display = "none";
                document.getElementById("formCampoCercatore").style.display = "none";
                document.getElementById("formMontatura").style.display = "none";
                document.getElementById("formTipoTelescopio").style.display = "none";
                document.getElementById("formAperturaPollici").style.display = "none";
                document.getElementById("formFocalRatio").style.display = "none";
                document.getElementById("formRisoluzioneAngolare").style.display = "none";
                document.getElementById("formStimaPotereRisolutivo").style.display = "none";
              } else {
                document.getElementById("formCampoFocale").style.display = "block";
                document.getElementById("formLunghezzaFocale").style.display = "block";
                document.getElementById("formMontatura").style.display = "block";
                document.getElementById("formCampoCercatore").style.display = "block";
                document.getElementById("formMontatura").style.display = "block";
                document.getElementById("formTipoTelescopio").style.display = "block";
                document.getElementById("formAperturaPollici").style.display = "block";
                document.getElementById("formFocalRatio").style.display = "block";
                document.getElementById("formRisoluzioneAngolare").style.display = "block";
                document.getElementById("formStimaPotereRisolutivo").style.display = "block";
              }
            }

            function calcolaFocalRatio() {
              lunghezzaFocale = document.getElementsByName("lunghezzaFocale")[0].value;
              aperturaMillimetri = document.getElementsByName("aperturaMillimetri")[0].value;
              campoFocalRatio = document.getElementsByName("focalRatio")[0];
              if (aperturaMillimetri != 0) {
                focalRatio = lunghezzaFocale/aperturaMillimetri;
                campoFocalRatio.value = focalRatio;
              } else {
                campoFocalRatio.value = "Apertura deve essere diverso da zero!";
              }
            }

            function calcolaStimaPotereRisolutivoI() {
              aperturaMillimetri = document.getElementsByName("aperturaMillimetri")[0].value;
              campoStimaPotereRisolutivo = document.getElementsByName("stimaPotereRisolutivo")[0];
              campoStimaPotereRisolutivo.value = 3.7 + 2.5 * Math.log(Math.pow(aperturaMillimetri, 2));
            }

            function calcolaStimaPotereRisolutivoII() {
              aperturaPollici = document.getElementsByName("aperturaPollici")[0].value;
              campoStimaPotereRisolutivo = document.getElementsByName("stimaPotereRisolutivo")[0];
              campoStimaPotereRisolutivo.value = 9.5 + 5 * Math.log(Math.pow(aperturaPollici, 2));
            }

            function calcolaRisoluzioneAngolare() {
              aperturaPollici = document.getElementsByName("aperturaPollici")[0].value;
              campoRisoluzioneAngolare = document.getElementsByName("risoluzioneAngolare")[0];
              campoRisoluzioneAngolare.value = 4.56/aperturaPollici;
            }
          </script>
        </head>
        <body>
          <center>
            <h1>Inserisci i dati dello strumento in questione:</h1>  <br><br>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" >
              <p id="formNome">Nome: <input type="text" name="nome"></p>
              <p id="formNote">Note: <input type="text" name="note"></p>
              <p id="formTipo">Tipo: <select name="tipo" onchange="mostraCampi(this)">
                <option value="Telescopio">Telescopio</option>
                <option value="Binocolo">Binocolo</option>
              </select></p>
              <p id="formMarca">Marca: <input type="text" name="marca"></p>
              <p id="formDisponibilita">Disponibilit&agrave;: <input type="text" name="disponibilita"></p>
              <p id="formApertura">Apertura: <input type="text" name="apertura"></p>
              <p id="formCampoFocale">Campo focale: <input type="text" name="campoFocale"></p>
              <p id="formIngrandimenti">Ingrandimenti: <input type="text" name="ingrandimenti"></p>
              <p id="formLunghezzaFocale">Lunghezza focale: <input type="text" name="lunghezzaFocale" oninput="calcolaFocalRatio()"></p>
              <p id="formMontatura">Montatura: <input type="text" name="montatura"></p>
              <p id="formCampoCercatore">Campo del cercatore: <input type="text" name="campoCercatore"></p>
              <p id="formTipoTelescopio">Tipo di telescopio: <select name="tipoTelescopio">
                <option value="Rifrattore">Rifrattore</option>
                <option value="Riflettore">Riflettore</option>
                <option value="Catadiottrico">Catadiottrico</option>
                <option value="Altro">Altro</option>
              </select></p>
              <p id="formAperturaMillimetri">Apertura (in millimetri): <input type="text" name="aperturaMillimetri" oninput="calcolaFocalRatio(); calcolaStimaPotereRisolutivoI()"></p>
              <p id="formAperturaPollici">Apertura (in pollici): <input type="text" name="aperturaPollici" oninput="calcolaRisoluzioneAngolare()"></p>
              <p id="formFocalRatio">Focal Ratio: <input type="text" name="focalRatio" readonly></p>
              <p id="formRisoluzioneAngolare">Risoluzione angolare: <input type="text" name="risoluzioneAngolare" readonly></p>
              <p id="formStimaPotereRisolutivo">Stima potere risolutivo: <input type="text" name="stimaPotereRisolutivo" readonly></p>
              <input type="submit" name="invio" value="inserisci">
            </form>
          </center>
        </body>
        </html>
        <?php
        } else { // chiudo if per verificare se accedo alla pagina prima volta o se ho gia inserito dati
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
                /* E se l'utente inserisce prima tutti i campi e poi il tipo di strumento? OK
                   Ci sono tre aperture: una in millimetri, una in pollici una in ?
                   Montatura non è un numero
                   Disponibilità è 0/1 (o true/false), non un numero
                   Mettere anche conversione millimetri pollici (e viceversa)?
                */
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
                $stmt->bindValue(":aperturaMillimetri", $aperturaMillimetri, PDO::PARAM_INT);
                $stmt->bindValue(":ingrandimenti", $ingrandimenti, PDO::PARAM_INT);
                if ($tipo == "Binocolo") {
                    $stmt->bindValue(":campoFocale", null, PDO::PARAM_NULL);
                    $stmt->bindValue(":lunghezzaFocale", null, PDO::PARAM_NULL);
                    $stmt->bindValue(":montatura", null, PDO::PARAM_NULL);
                    $stmt->bindValue(":focalRatio", null, PDO::PARAM_NULL);
                    $stmt->bindValue(":campoCercatore", null, PDO::PARAM_NULL);
                    $stmt->bindValue(":tipoTelescopio", null, PDO::PARAM_NULL);
                    $stmt->bindValue(":aperturaPollici", null, PDO::PARAM_NULL);
                    $stmt->bindValue(":risoluzioneAngolare", null, PDO::PARAM_NULL);
                    $stmt->bindValue(":stimaPotereRisolutivo", null, PDO::PARAM_NULL);
                } else {
                    $stmt->bindValue(":campoFocale", $campoFocale, PDO::PARAM_INT);
                    $stmt->bindValue(":lunghezzaFocale", $lunghezzaFocale, PDO::PARAM_INT);
                    $stmt->bindValue(":montatura", $montatura, PDO::PARAM_INT);
                    $stmt->bindValue(":focalRatio", $focalRatio, PDO::PARAM_INT);
                    $stmt->bindValue(":campoCercatore", $campoCercatore, PDO::PARAM_INT);
                    $stmt->bindValue(":tipoTelescopio", $tipoTelescopio, PDO::PARAM_STR);
                    $stmt->bindValue(":aperturaPollici", $aperturaPollici, PDO::PARAM_INT);
                    $stmt->bindValue(":risoluzioneAngolare", $risoluzioneAngolare, PDO::PARAM_INT);
                    $stmt->bindValue(":stimaPotereRisolutivo", $stimaPotereRisolutivo, PDO::PARAM_INT);
                }
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
