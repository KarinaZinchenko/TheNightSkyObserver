<?php
ob_start();
?>
<html>
<head> <title>Inserimento nuovo strumento</title> </head>
<body>
<?php
session_start();
include("config.php");
include("header.php");
include("navbar.php");
echo "<div class='container'>";
echo "<div class='row-fluid'>";
echo "<div class='span10 offset1'>";
echo "<div class='contact-info'>";
echo "<div class='panel-body'>";

if (isset($_SESSION["autenticato"]) && isset($_SESSION["tipo"])) {
    if ($_SESSION["tipo"] == "amministratore") {
        if (!isset($_POST["invio"])) {
        ?>
          <script type="text/javascript" language="javascript">
            // Si può fare ancora meglio con jquery
            function mostraCampi(x) {
              var campiTelescopio = document.getElementsByClassName("telescopio");
              if (x.value == "Binocolo") {
                for (var i = 0; i < campiTelescopio.length; i++) {
                  campiTelescopio[i].style.display = "none";
                }
              } else {
                for (var i = 0; i < campiTelescopio.length; i++) {
                  campiTelescopio[i].style.display = "block";
                }
              }
            }

            function roundNumber(num, scale) {
              if (!("" + num).includes("e")) {
                return +(Math.round(num + "e+" + scale)  + "e-" + scale);
              } else {
                var arr = ("" + num).split("e");
                var sig = ""
                if(+arr[1] + scale > 0) {
                  sig = "+";
                }
                return +(Math.round(+arr[0] + "e" + sig + (+arr[1] + scale)) + "e-" + scale);
              }
            }

            function calcolaFocalRatio() {
              lunghezzaFocale = document.getElementsByName("lunghezzaFocale")[0].value;
              aperturaMillimetri = document.getElementsByName("aperturaMillimetri")[0].value;
              campoFocalRatio = document.getElementsByName("focalRatio")[0];
              if (aperturaMillimetri != 0) {
                focalRatio = lunghezzaFocale/aperturaMillimetri;
                roundedFocalRatio = roundNumber(focalRatio, 2);
                campoFocalRatio.value = roundedFocalRatio;
              } else {
                campoFocalRatio.value = "Apertura deve essere diverso da zero!";
              }
            }

            function calcolaStimaPotereRisolutivoI() {
              aperturaMillimetri = document.getElementsByName("aperturaMillimetri")[0].value;
              campoStimaPotereRisolutivo = document.getElementsByName("stimaPotereRisolutivo")[0];
              stimaPotereRisolutivo = 3.7 + 2.5 * Math.log(Math.pow(aperturaMillimetri, 2));
              roundedStimaPotereRisolutivo = roundNumber(stimaPotereRisolutivo, 2);
              campoStimaPotereRisolutivo.value = roundedStimaPotereRisolutivo;
            }

            function calcolaStimaPotereRisolutivoII() {
              aperturaPollici = document.getElementsByName("aperturaPollici")[0].value;
              campoStimaPotereRisolutivo = document.getElementsByName("stimaPotereRisolutivo")[0];
              stimaPotereRisolutivo = 9.5 + 5 * Math.log(Math.pow(aperturaPollici, 2));
              roundedStimaPotereRisolutivo = roundNumber(stimaPotereRisolutivo, 2);
              campoStimaPotereRisolutivo.value = roundedStimaPotereRisolutivo;
            }

            function calcolaRisoluzioneAngolare() {
              aperturaPollici = document.getElementsByName("aperturaPollici")[0].value;
              campoRisoluzioneAngolare = document.getElementsByName("risoluzioneAngolare")[0];
              risoluzioneAngolare = 4.56/aperturaPollici;
              roundedRisoluzioneAngolare = roundNumber(risoluzioneAngolare, 2);
              campoRisoluzioneAngolare.value = roundedRisoluzioneAngolare;
            }
          </script>

        <h1>Inserisci i dati dello strumento</h1>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" >
            <div class="row">
                <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                    <label>Nome *</label><input type="text" name="nome">
                </div>
                <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                    <label>Tipo *</label>
                    <select id="soflow-color" name="tipo" onchange="mostraCampi(this)">
                        <option value="Telescopio">Telescopio</option>
                        <option value="Binocolo">Binocolo</option>
                    </select>
                </div>
                <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                    <label>Marca *</label><input type="text" name="marca">
                </div>
                <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                    <label>Disponibilit&agrave; *</label><input type="text" name="disponibilita">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                    <label>Ingrandimenti</label><input type="text" name="ingrandimenti">
                </div>
                <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                    <label>Note</label><textarea name="note"></textarea>
                </div>
                <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                    <label>Apertura mm</label><input type="text" name="aperturaMillimetri" oninput="calcolaFocalRatio(); calcolaStimaPotereRisolutivoI()">
                </div>
                <div class="col-xs-6 col-sm-3 col-md-3 form-group telescopio">
                    <label>Apertura "</label><input type="text" name="aperturaPollici" oninput="calcolaRisoluzioneAngolare()">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-sm-3 col-md-3 form-group telescopio">
                    <label>Tipo di telescopio</label>
                    <select id="soflow-color" name="tipoTelescopio">
                        <option value="Rifrattore">Rifrattore</option>
                        <option value="Riflettore">Riflettore</option>
                        <option value="Catadiottrico">Catadiottrico</option>
                        <option value="Altro">Altro</option>
                    </select>
                </div>
                <div class="col-xs-6 col-sm-3 col-md-3 form-group telescopio">
                    <label>Campo focale</label><input type="text" name="campoFocale">
                </div>
                <div class="col-xs-6 col-sm-3 col-md-3 form-group telescopio">
                    <label>Lunghezza focale</label><input type="text" name="lunghezzaFocale" oninput="calcolaFocalRatio()">
                </div>
                <div class="col-xs-6 col-sm-3 col-md-3 form-group telescopio">
                    <label>Montatura</label><input type="text" name="montatura">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-sm-3 col-md-3 form-group telescopio">
                    <label>Campo del cercatore</label><input type="text" name="campoCercatore">
                </div>
                <div class="col-xs-6 col-sm-3 col-md-3 form-group telescopio">
                    <label>Focal Ratio</label><input type="text" name="focalRatio" readonly>
                </div>
                <div class="col-xs-6 col-sm-3 col-md-3 form-group telescopio">
                    <label>Stima potere risolutivo</label><input type="text" name="stimaPotereRisolutivo" readonly>
                </div>
                <div class="col-xs-6 col-sm-3 col-md-3 form-group telescopio">
                    <label>Risoluzione angolare</label><input type="text" name="risoluzioneAngolare" readonly>
                </div>
            </div>
            <input id="contact-submit" class="btn" type="submit" name="invio" value="inserisci">
        </form>

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
                ?>
                    <script>
                        swal({title:"Inserimento effettuato!",type:"success",showConfirmButton:false});
                    </script>
                    <?php
                    header("Refresh:2; url=inserisciStrumento.php", true, 303);
                } else {
                    ?>
                    <script>
                        swal({title:"Attenzione!",text:"errore nella query.",type:"warning",showConfirmButton:false});
                    </script>
                    <?php
                    header("Refresh:2; url=inserisciStrumento.php", true, 303);
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
                    ?>
                <script>
                    swal({title:"Attenzione!",text:"Tutti i campi obbligatori, contrassegnati da *, devono essere inseriti.",type:"warning",showConfirmButton:false});
                </script>
                <?php
                header("Refresh:3; url=inserisciStrumento.php", true, 303);
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
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";

include("footer.php");
?>
</body>
</html>
