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
        </head>
        <body>
          <center>
            <form method="post" action="modificaEliminaStrumentoEffettivo.php">
              <input type="hidden" name="IDStrumento" value="<?php echo $_POST["IDStrumento"];  ?>" />
              Nome: <input type="text" name="nome" value="<?php echo $tupla['nome']; ?>"><br><br>
              Note: <input type="text" name="note" value="<?php echo $tupla['note']; ?>"><br><br>
              Tipo: <input type="text" name="tipo" value="<?php echo $tupla['tipo'];?>"><br><br>
              Marca: <input type="text" name="marca" value="<?php echo $tupla['marca'];?>"><br><br>
              Disponibilit&agrave;: <input type="text" name="disponibilita" value="<?php echo $tupla['disponibilita'];?>"><br><br>
              Apertura: <input type="text" name="apertura" value="<?php echo $tupla['apertura'];?>"><br><br>
              Campo focale: <input type="text" name="campoFocale" value="<?php echo $tupla['campo_focale'];?>"><br><br>
              ingrandimenti: <input type="date" name="ingrandimenti" value="<?php echo $tupla['ingrandimenti'];?>"><br><br>
              Lunghezza focale: <input type="date" name="lunghezzaFocale" value="<?php echo $tupla['lunghezza_focale'];?>"><br><br>
              Montatura: <input type="date" name="montatura" value="<?php echo $tupla['montatura'];?>"><br><br>
              Focal ratio: <input type="date" name="focalRatio" value="<?php echo $tupla['focal_ratio'];?>"><br><br>
              Campo cercatore: <input type="date" name="campoCercatore" value="<?php echo $tupla['campo_cercatore'];?>"><br><br>
              Tipo telescopio: <input type="date" name="tipoTelescopio" value="<?php echo $tupla['tipo_telescopio'];?>"><br><br>
              Apertura millimetri: <input type="date" name="aperturaMillimetri" value="<?php echo $tupla['apertura_millimetri'];?>"><br><br>
              Apertura pollici: <input type="date" name="aperturaPollici" value="<?php echo $tupla['apertura_pollici'];?>"><br><br>
              Risoluzione angolare: <input type="date" name="risoluzioneAngolare" value="<?php echo $tupla['risoluzione_angolare'];?>"><br><br>
              Stima potere risolutivo: <input type="date" name="stimaPotereRisolutivo" value="<?php echo $tupla['stima_potere_risolutivo'];?>"><br><br>
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
