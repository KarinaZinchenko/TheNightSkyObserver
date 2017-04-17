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
               Altitudine: <input type="text" name="altitudine"><br><br>
               Latitudine: <input type="text" name="latitudine"><br><br>
               Longitudine: <input type="text" name="longitudine"><br><br>
               Qualit&agrave; cielo (Bortle): <input type="text" name="bortle"><br><br>
               Qualit&agrave; cielo (SQM): <input type="text" name="sqm"><br><br>
                 <input type="submit" name="invio" value="inserisci">
             </form>
           </center>
         </body>
         </html>
        <?php
        } else {// chiudo if per verificare se accedo alla pagina prima volta o se ho gia inserito dati
            $nome = "";
            $note = "";
            $altitudine = "";
            $latitudine = "";
            $longitudine = "";
            $bortle = "";
            $sqm = "";
            if ($_REQUEST["nome"] != "" & $_REQUEST["altitudine"] != "" & $_REQUEST["latitudine"] != "" & $_REQUEST != ["longitudine"]) {
                $nome = $_REQUEST["nome"];
                $note = $_REQUEST["note"];
                $altitudine = $_REQUEST["altitudine"];
                $latitudine = $_REQUEST["latitudine"];
                $longitudine = $_REQUEST["longitudine"];
                $bortle = $_REQUEST["bortle"];
                $sqm = $_REQUEST["sqm"];

                $nome = nl2br(htmlentities($nome, ENT_QUOTES, 'UTF-8'));
                $note = nl2br(htmlentities($note, ENT_QUOTES, 'UTF-8'));
                $altitudine = nl2br(htmlentities($altitudine, ENT_QUOTES, 'UTF-8'));
                $latitudine = nl2br(htmlentities($latitudine, ENT_QUOTES, 'UTF-8'));
                $longitudine = nl2br(htmlentities($longitudine, ENT_QUOTES, 'UTF-8'));
                $bortle = nl2br(htmlentities($bortle, ENT_QUOTES, 'UTF-8'));
                $sqm = nl2br(htmlentities($sqm, ENT_QUOTES, 'UTF-8'));

                if (empty($note)) {
                    $note = null;
                }
                if (empty($bortle)) {
                    $bortle = null;
                }
                if (empty($sqm)) {
                    $sqm = null;
                }
                /*
                $sql = "INSERT INTO areageografica(nome, note, altitudine, latitudine, longitudine, qualita_cielo_bortle, qualita_cielo_sqm) VALUES ('".addslashes($nome)."','".addslashes($note)."',".addslashes($altitudine).",".addslashes($latitudine).",".addslashes($longitudine).",".addslashes($bortle).",".addslashes($sqm).");";
                */
                /*
                  Nel caso volessimo usare PDO invece di questo mostro qui sopra
                */
                $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');
                $stmt = $conn->prepare("INSERT INTO areageografica(nome,note,altitudine, latitudine, longitudine, qualita_cielo_bortle, qualita_cielo_sqm) VALUES (:nome, :note, :altitudine, :latitudine, :longitudine, :bortle, :sqm)");
                $stmt->bindValue(":nome", $nome, PDO::PARAM_STR);
                $stmt->bindValue(":note", $note, PDO::PARAM_NULL);
                $stmt->bindValue(":altitudine", $altitudine, PDO::PARAM_INT);
                $stmt->bindValue(":latitudine", $latitudine, PDO::PARAM_INT);
                $stmt->bindValue(":longitudine", $longitudine, PDO::PARAM_INT);
                $stmt->bindValue(":bortle", $bortle, PDO::PARAM_INT);
                $stmt->bindValue(":sqm", $sqm, PDO::PARAM_INT);
                $result = $stmt -> execute();
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
                echo "alert('tutti i campi tranne note, qualità cielo Bortle e qualità cielo SQM sono obbligatori');";
                echo "</script>";
                header("Refresh:0; url=inserisciArea.php", true, 303);
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
