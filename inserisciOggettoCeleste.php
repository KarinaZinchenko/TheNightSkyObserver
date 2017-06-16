<?php
ob_start();
?>
<html>
<head> <title>Inserimento nuovo oggetto celeste</title> </head>
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

if (isset($_SESSION["autenticato"])&& isset($_SESSION["tipo"])) {
    if ($_SESSION["tipo"]=="amministratore") {
        if (!isset($_POST["invio"])) {
        ?>

            <h1> Inserisci i dati dell'oggetto celeste</h1>  <br>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" >
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 form-group">
                    <label>Nome *</label><input type="text" name="nome">
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 form-group">
                    <label>Costellazione</label><input type="text" name="costellazione">
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 form-group">
                    <label>Tipo oggetto *</label><input type="text" name="tipo_oggetto">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 form-group">
                    <label>Ascensione retta *</label><input type="number" name="ascensione_retta"><br><br>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 form-group">
                    <label>Dimensione *</label><input type="number" name="dimensione"><br><br>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 form-group">
                    <label>Declinazione *</label><input type="number" name="declinazione"><br><br>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                    <label>Magnitudine I *</label><input type="number" name="magnitudineI"><br><br>
                </div>
                <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                    <label>Magnitudine II</label><input type="number" name="magnitudineII"><br><br>
                </div>
                <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                    <label>Separazione *</label><input type="number" name="separazione"><br><br>
                </div>
                <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                    <label>Numero mappa *</label><input type="number" name="numero_mappa"><br><br>
                </div>
            </div>
                    <input id="contact-submit" class="btn" type="submit" name="invio" value="inserisci">
            </form>

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
                ?>
                    <script>
                        swal({title:"Inserimento effettuato!",type:"success",showConfirmButton:false});
                    </script>
                    <?php
                    header("Refresh:2; url=inserisciOggettoCeleste.php", true, 303);
                } else {
                    die("Errore nella query: ". $sql ."\n". mysqli_error($conn));
                }
                mysqli_close($conn);
            } else {
            ?>
                <script>
                    swal({title:"Attenzione!",text:"Tutti i campi tranne costellazione e magnitudine II sono obbligatori.",type:"warning",showConfirmButton:false});
                </script>
                <?php
                header("Refresh:3; url=inserisciOggettoCeleste.php", true, 303);
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