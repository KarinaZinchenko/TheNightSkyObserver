<?php
session_start();
include("config.php");
if (isset($_SESSION["autenticato"]) && isset($_SESSION["tipo"])) {
    if ($_SESSION["tipo"] == "amministratore") {
        if (isset($_POST["invio_ricerca"])) {
            echo "<center><h1> Modifica/Elimina i dati dello strumento:</h1></center> <br><br>";
            $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');
            $stmt = $conn->prepare("SELECT * FROM strumento WHERE ID = :IDStrumento");
            $stmt->bindValue(":IDStrumento", $_POST["IDStrumento"], PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count > 0) {
                $tupla = $stmt->fetch(PDO::FETCH_ASSOC);
            /*$sql = "SELECT nome,cognome,username,password,tipo,scadenza_tessera,data_nascita FROM anagrafica WHERE numero_socio=".$_POST["tipo_utente"].";";
            $risposta = mysqli_query($conn, $sql)or die("Errore nella query: " . $sql . "\n" . mysqli_error($conn));
            if (mysqli_num_rows($risposta)!=0) {
                $tupla = mysqli_fetch_array($risposta);
            */
            ?>
        <html>
        <head>
          <title>Modifica/Elimina strumento</title>
          <script type="text/javascript" language="javascript">
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
            <form method="post" action="modificaEliminaStrumentoEffettivo.php">
              <input type="hidden" name="IDStrumento" value="<?php echo $_POST["IDStrumento"];  ?>" />
              <p>Nome: <input type="text" name="nome" value="<?php echo $tupla['nome']; ?>"></p>
              <p>Note: <input type="text" name="note" value="<?php echo $tupla['note']; ?>"></p>
              <p>Tipo: <input type="text" name="tipo" value="<?php echo $tupla['tipo'];?>"></p>
              <p>Marca: <input type="text" name="marca" value="<?php echo $tupla['marca'];?>"></p>
              <p>Disponibilit&agrave;: <input type="text" name="disponibilita" value="<?php echo $tupla['disponibilita'];?>"></p>
              <p>Apertura: <input type="text" name="apertura" value="<?php echo $tupla['apertura'];?>"></p>
                <?php
                if ($tupla['tipo'] == "Telescopio") {
                    $campoFocale = $tupla['campo_focale'];
                    echo "<p class=\"telescopio\">Campo focale: <input type=\"text\" name=\"campoFocale\" value=\"$campoFocale\"></p>";
                }
                ?>
              <p>Ingrandimenti: <input type="date" name="ingrandimenti" value="<?php echo $tupla['ingrandimenti'];?>"></p>
                <?php
                if ($tupla['tipo'] == "Telescopio") {
                    $lunghezzaFocale = $tupla['lunghezza_focale'];
                    $montatura = $tupla['montatura'];
                    $campoCercatore = $tupla['campo_cercatore'];
                    $tipoTelescopio = $tupla['tipo_telescopio'];
                    echo "<p class=\"telescopio\">Lunghezza focale: <input type=\"text\" name=\"lunghezzaFocale\" oninput=\"calcolaFocalRatio()\" value=\"$lunghezzaFocale\"></p>";
                    echo "<p class=\"telescopio\">Montatura: <input type=\"text\" name=\"montatura\" value=\"$montatura\"></p>";
                    echo "<p class=\"telescopio\">Campo del cercatore: <input type=\"text\" name=\"campoCercatore\" value=\"$campoCercatore\"></p>";
                    echo "<p class=\"telescopio\">Tipo di telescopio: <select name=\"tipoTelescopio\" value=\"$tipoTelescopio\"></p>";
                    echo "<option value=\"Rifrattore\"";
                    if ($tipoTelescopio == "Rifrattore") {
                        echo "selected = \"selected\"";
                    }
                    echo ">Rifrattore</option>";
                    echo "<option value=\"Riflettore\"";
                    if ($tipoTelescopio == "Riflettore") {
                        echo "selected = \"selected\"";
                    }
                    echo ">Riflettore</option>";
                    echo "<option value=\"Catadiottrico\"";
                    if ($tipoTelescopio == "Catadiottrico") {
                        echo "selected = \"selected\"";
                    }
                    echo ">Catadiottrico</option>";
                    echo "<option value=\"Altro\"";
                    if ($tipoTelescopio == "Altro") {
                        echo "selected = \"selected\"";
                    }
                    echo ">Altro</option>";
                    echo "</select>";
                }
                ?>
              <p>Apertura (in millimetri): <input type="date" name="aperturaMillimetri" oninput="calcolaFocalRatio(); calcolaStimaPotereRisolutivoI()" value="<?php echo $tupla['apertura_millimetri'];?>">
              </p>
                <?php
                if ($tupla['tipo'] == "Telescopio") {
                    $aperturaPollici = $tupla['apertura_pollici'];
                    $focalRatio = $tupla['focal_ratio'];
                    $risoluzioneAngolare = $tupla['risoluzione_angolare'];
                    $stimaPotereRisolutivo = $tupla['stima_potere_risolutivo'];
                    echo "<p class=\"telescopio\">Apertura (in pollici): <input type=\"text\" name=\"aperturaPollici\" value=\"$aperturaPollici\" oninput=\"calcolaRisoluzioneAngolare()\"></p>";
                    echo "<p class=\"telescopio\">Focal Ratio: <input type=\"text\" name=\"focalRatio\" value=\"$focalRatio\" readonly></p>";
                    echo "<p class=\"telescopio\">Risoluzione angolare: <input type=\"text\" name=\"risoluzioneAngolare\" value=\"$risoluzioneAngolare\" readonly></p>";
                    echo "<p class=\"telescopio\">Stima potere risolutivo: <input type=\"text\" name=\"stimaPotereRisolutivo\" value=\"$stimaPotereRisolutivo\" readonly></p>";
                }
                ?>
              <select name="scelta_operazione">
                <option value="modifica">Modifica</option>
                <option value="elimina">Elimina</option>
              </select>
                <input type="submit" name="invio" value="Esegui operazione">
            </form>
          </center>
        </body>
        </html>
            <?php
            $conn = null;
            $stmt = null;
            } else { //fine if per controllare se la tabella anagrafica torna qualcosa
                echo "errore nel recupero dei dati dal database <a herf='prova-sessioni.php'>Torna alla pagina personale </a>";
                exit();
            }
        } else { //fine if per capire se sono arrivato facendo una ricerca oppure no
    ?>
    <html>
    <head> <title>Modifica/Elimina </title> </head>
    <body>
      <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" >
        Scegliere lo strumento: &nbsp;<select name="IDStrumento">
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
        /*
        $sql = "SELECT numero_socio,nome,cognome FROM anagrafica;";
        $risposta=mysqli_query($conn, $sql)or die("Errore nella query: " . $sql . "\n" . mysqli_error($conn));
        if (mysqli_num_rows($risposta)!=0) {
            while ($tupla = mysqli_fetch_array($risposta)) {
                $numero_socio=$tupla["numero_socio"];
                $nome=$tupla["nome"];
                $cognome=$tupla["cognome"];
        */
                ?>
        <option value="<?php echo "$IDStrumento";?>"><?php echo "$tipoStrumento: $nomeStrumento " . ($disponibilitaStrumento == 0 ? "(Non disponibile)" : "(Disponibile)");?> </option>
        <?php
            }
        } //fine if per sapere se la query ha tornato qualcosa
        ?>
        </select> &nbsp;&nbsp;
          <input type="submit" name="invio_ricerca" value="Modifica/Elimina"/>
        </form>
        <?php
        }
    } else { //chiudo if se tipo amministratore
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
</body>
</html>
