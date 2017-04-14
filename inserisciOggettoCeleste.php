<?php
session_start();
include("config.php");
if (isset($_SESSION["autenticato"])&& isset($_SESSION["tipo"])) {
    if ($_SESSION["tipo"]=="amministratore") {
        if (!isset($_POST["invio"])) {
        ?>
        <html>
        <head>
          <title>Inserimento nuovo Oggetto Celeste</title>
        </head>
        <body>
          <center>
            <h1> Inserisci i dati dell'oggetto celeste: </h1>  <br><br>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" >
            Nome: <input type="text" name="nome"><br><br>
            Costellazione: <input type="text" name="costellazione"><br><br>
            Tipo oggetto: <input type="text" name="tipo_oggetto"><br><br>
            Ascensione retta: <input type="number" name="ascensione_retta"><br><br>
            Dimensione: <input type="number" name="dimensione"><br><br>
            Declinazione: <input type="number" name="declinazione"><br><br>
            Magnitudine I: <input type="number" name="magnitudineI"><br><br>
            Magnitudine II: <input type="number" name="magnitudineII"><br><br>
            Separazione: <input type="number" name="separazione"><br><br>
            Numero mappa: <input type="number" name="numero_mappa"><br><br>
              <input type="submit" name="invio" value="inserisci">
            </form>
          </center>
        </body>
        </html>
        <?php
        } else { // chiudo if per verificare se accedo alla pagina prima volta o se ho gia inserito dati
            $nome = "";
            $costellazine = "";
            $tipo_oggetto = "";
            $ascensione_retta = 0;
            $dimensione = 0;
            $declinazione = 0;
            $magnitudineI = 0;
            $magnitudineII = "";
            $separazione = 0;
            $numero_mappa = 0;

            if ($_REQUEST["nome"]!="" && $_REQUEST["tipo_oggetto"]!="" && $_REQUEST["ascensione_retta"]!="" && $_REQUEST["dimensione"]!="" && $_REQUEST["declinazione"]!="" && $_REQUEST["magnitudineI"]!="" && $_REQUEST["separazione"]!="" && $_REQUEST["numero_mappa"]!="") {
                $nome = $_REQUEST["nome"];

                $costellazione = $_REQUEST["costellazione"];
                $tipo_oggetto = $_REQUEST["tipo_oggetto"];
                $ascensione_retta = $_REQUEST["ascensione_retta"];
                $dimensione = $_REQUEST["dimensione"];
                $declinazione = $_REQUEST["declinazione"];
                $magnitudineI = $_REQUEST["magnitudineI"];
                $magnitudineII = $_REQUEST["magnitudineII"];
                $separazione = $_REQUEST["separazione"];
                $numero_mappa = $_REQUEST["numero_mappa"];

                $nome = nl2br(htmlentities($nome, ENT_QUOTES, 'UTF-8'));
                $costellazione = nl2br(htmlentities($costellazione, ENT_QUOTES, 'UTF-8'));
                $tipo_oggetto = nl2br(htmlentities($tipo_oggetto, ENT_QUOTES, 'UTF-8'));
                $ascensione_retta = nl2br(htmlentities($ascensione_retta, ENT_QUOTES, 'UTF-8'));
                $dimensione = nl2br(htmlentities($dimensione, ENT_QUOTES, 'UTF-8'));
                $declinazione = nl2br(htmlentities($declinazione, ENT_QUOTES, 'UTF-8'));
                $magnitudineI = nl2br(htmlentities($magnitudineI, ENT_QUOTES, 'UTF-8'));
                $magnitudineII = nl2br(htmlentities($magnitudineII, ENT_QUOTES, 'UTF-8'));
                $separazione = nl2br(htmlentities($separazione, ENT_QUOTES, 'UTF-8'));
                $numero_mappa = nl2br(htmlentities($numero_mappa, ENT_QUOTES, 'UTF-8'));

                if (empty($magnitudineII)) {
                    $magnitudineII = 0;
                }

                $sql = "INSERT INTO oggettoceleste(magnitudineI,magnitudineII,declinazione,dimensione,ascensione_retta,tipo_oggetto,costellazione,nome,numero_mappa,separazione) VALUES (".addslashes($magnitudineI).",".addslashes($magnitudineII).",".addslashes($declinazione).",".addslashes($dimensione).",".addslashes($ascensione_retta).",'".addslashes($tipo_oggetto)."','".addslashes($costellazione)."','".addslashes($nome)."',".addslashes($numero_mappa).",".addslashes($separazione).");";
                if (mysqli_query($conn, $sql)) {
                    echo "<script language='javascript'>";
                    echo "alert('Inserimento effettuato');";
                    echo "</script>";
                    header("Refresh:0; url=prova-sessioni.php", true, 303);
                } else {
                    die("Errore nella query: ". $sql ."\n". mysqli_error($conn));
                }
                mysqli_close($conn);
            } else { //chiudo if per verificre che i campi siano stati inseriti
                echo "<script language='javascript'>";
                echo "alert('tutti i campi tranne costellazione e magnitudineII sono obbligatori ');";
                echo "</script>";
                header("Refresh:0; url=inserisciOggettoCeleste.php", true, 303);
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
