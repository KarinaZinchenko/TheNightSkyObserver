<?php
ob_start();
?>
<html>
<head> <title>Modifica/Elimina Strumento</title> </head>
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
        if (isset($_POST["invio_ricerca"])) {
            echo "<h1> Modifica/Elimina i dati dello strumento</h1><br>";
            $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');
            $stmt = $conn->prepare("SELECT * FROM strumento WHERE ID = :IDStrumento");
            $stmt->bindValue(":IDStrumento", $_POST["IDStrumento"], PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count > 0) {
                $tupla = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
          <script type="text/javascript" language="javascript">
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
            <form method="post" action="modificaEliminaStrumentoEffettivo.php">
            <input type="hidden" name="IDStrumento" value="<?php echo $_POST["IDStrumento"];  ?>" />
            <div class="row">
                <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                    <label>Tipo *</label>
                    <?php
                    echo "<select id=\"soflow-color\" name=\"tipo\" value=\"".$tupla['tipo']."\">";
                    echo "<option value=\"Telescopio\"";
                    if (!strcasecmp($tupla['tipo'],"Telescopio")) {
                        echo "selected = \"selected\"";
                    }
                    echo ">Telescopio";
                    echo "</option>";
                    echo "<option value=\"Binocolo\"";
                    if (!strcasecmp($tupla['tipo'],"Binocolo")) {
                        echo "selected = \"selected\"";
                    }
                    echo ">Binocolo";
                    echo "</option>";
                    echo "</select>";
                    ?>
                </div>
                <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                    <label>Nome *</label><textarea name="nome"><?php echo $tupla['nome']; ?> </textarea>
                </div>
                <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                    <label>Marca *</label><input type="text" name="marca" value="<?php echo $tupla['marca'];?>">
                </div>
                <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                    <label>Disponibilit&agrave; *</label><input type="text" name="disponibilita" value="<?php echo $tupla['disponibilita'];?>">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                    <label>Ingrandimenti</label><input type="text" name="ingrandimenti" value="<?php echo $tupla['ingrandimenti'];?>">
                </div>
                <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                    <label>Note</label><textarea name="note"><?php echo $tupla['note']; ?></textarea>
                </div>
                <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                    <label>Apertura mm</label><input type="text" name="aperturaMillimetri" oninput="calcolaFocalRatio(); calcolaStimaPotereRisolutivoI()" value="<?php echo $tupla['apertura_millimetri'];?>">
                </div>
                <?php
                if ($tupla['tipo'] == "Telescopio") {
                $aperturaPollici = $tupla['apertura_pollici']; ?>
                <div class="col-xs-6 col-sm-3 col-md-3 form-group telescopio">
                    <label>Apertura "</label><input type="text" name="aperturaPollici" oninput="calcolaRisoluzioneAngolare()" value="<?php echo $aperturaPollici; ?>" >
                </div>
                <?php } ?>
            </div>
            <?php
            if ($tupla['tipo'] == "Telescopio") {
            $focalRatio = $tupla['focal_ratio'];
            $risoluzioneAngolare = $tupla['risoluzione_angolare'];
            $stimaPotereRisolutivo = $tupla['stima_potere_risolutivo'];
            $campoFocale = $tupla['campo_focale'];
            $lunghezzaFocale = $tupla['lunghezza_focale'];
            $montatura = $tupla['montatura'];
            $campoCercatore = $tupla['campo_cercatore'];
            $tipoTelescopio = $tupla['tipo_telescopio'];
            ?>
                <div class="row">
                    <div class="col-xs-6 col-sm-3 col-md-3 form-group telescopio">
                        <label>Campo focale</label><input type="text" name="campoFocale"
                                                          value=<?php echo $campoFocale; ?>>
                    </div>
                    <div class="col-xs-6 col-sm-3 col-md-3 form-group telescopio">
                        <label>Tipo di telescopio</label>
                        <?php
                        echo "<select id=\"soflow-color\" name=\"tipoTelescopio\" value=\"$tipoTelescopio\">";
                        echo "<option value=\"Rifrattore\"";
                            if (!strcasecmp($tipoTelescopio,"Rifrattore")) {
                                echo "selected = \"selected\"";
                            }
                        echo ">Rifrattore";
                        echo "</option>";
                        echo "<option value=\"Riflettore\"";
                                      if (!strcasecmp($tipoTelescopio,"Riflettore")) {
                        echo "selected = \"selected\"";
                        }
                        echo ">Riflettore";
                        echo "</option>";
                        echo "<option value=\"Catadiottrico\"";
                                      if (!strcasecmp($tipoTelescopio,"Catadiottrico")) {
                        echo "selected = \"selected\"";
                        }
                        echo ">Catadiottrico";
                        echo "</option>";
                        echo "<option value='Altro'";
                                      if (!strcasecmp($tipoTelescopio,"Altro")) {
                        echo "selected = \"selected\"";
                        }
                        echo ">Altro";
                        echo "</option>";
                        echo "</select>";
                        ?>
                    </div>
                    <div class="col-xs-6 col-sm-3 col-md-3 form-group telescopio">
                        <label>Montatura</label><input type="text" name="montatura" value="<?php echo $montatura; ?>">
                    </div>
                    <div class="col-xs-6 col-sm-3 col-md-3 form-group telescopio">
                        <label>Lunghezza focale</label><input type="text" name="lunghezzaFocale"
                                                              oninput="calcolaFocalRatio()"
                                                              value="<?php echo $lunghezzaFocale; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-3 col-md-3 form-group telescopio">
                        <label>Campo del cercatore</label><input type="text" name="campoCercatore"
                                                                 value="<?php echo $campoCercatore; ?>">
                    </div>
                    <div class="col-xs-6 col-sm-3 col-md-3 form-group telescopio">
                        <label>Focal Ratio</label><input type="text" name="focalRatio" readonly
                                                         value="<?php echo $focalRatio; ?>">
                    </div>
                    <div class="col-xs-6 col-sm-3 col-md-3 form-group telescopio">
                        <label>Stima potere risolutivo</label><input type="text" name="stimaPotereRisolutivo" readonly
                                                                     value="<?php echo $stimaPotereRisolutivo; ?>">
                    </div>
                    <div class="col-xs-6 col-sm-3 col-md-3 form-group telescopio">
                        <label>Risoluzione angolare</label><input type="text" name="risoluzioneAngolare" readonly
                                                                  value="<?php echo $risoluzioneAngolare; ?>">
                    </div>
                </div>
              <?php
            } ?>
                <input id="contact-submit" class="btn" type="submit" name="scelta_operazione"
                       value="modifica"> &nbsp;&nbsp;
                <input id="contact-submit" class="btn" type="submit" name="scelta_operazione" value="elimina">
            </form>

<?php
            $conn = null;
            $stmt = null;
            } else { //fine if per controllare se la tabella anagrafica torna qualcosa
            ?>
                <script>
                    swal({title:"Oops...!",text:"Si è verificato un errore nel recupero dei dati dal database.",type:"error",showConfirmButton:false});
                </script>
                <?php
                header("Refresh:2; url=profiloUtente.php", true, 303);
                exit();
            }
        } else { //fine if per capire se sono arrivato facendo una ricerca oppure no
                ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
            <h1>Selezionare lo strumento da modificare</h1><br>
            <select id="soflow-color" name="IDStrumento">
                <?php
                $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');
                $stmt = $conn->prepare("SELECT * FROM strumento");
                $stmt->execute();
                $count = $stmt->rowCount();
                if ($count > 0) {
                    $tupla = $stmt->fetchALL(PDO::FETCH_ASSOC);
                    foreach ($tupla as $row) {
                        $IDStrumento = $row['ID'];
                        $tipoStrumento = $row['tipo'];
                        $nomeStrumento = $row['nome'];
                        $disponibilitaStrumento = $row['disponibilita']
                        ?>
                        <option
                            value="<?php echo "$IDStrumento"; ?>"><?php echo "$tipoStrumento: $nomeStrumento " . ($disponibilitaStrumento == 0 ? "(Non disponibile)" : "(Disponibile)"); ?> </option>
                        <?php
                    }
                } //fine if per sapere se la query ha tornato qualcosa
                ?>
            </select> &nbsp;&nbsp;
            <br>
            <input id="contact-submit" class="btn" type="submit" name="invio_ricerca" value="Modifica/Elimina"/>
        </form>
    <?php
    }
    } else { //chiudo if se tipo amministratore
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