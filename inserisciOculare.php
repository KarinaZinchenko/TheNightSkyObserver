<!-- 09/05/2017 21:30 - Codice indentato -->
<?php
ob_start();
?>
<html>
<head> <title>Inserimento nuovo Oculare</title> </head>
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
            <h1>Inserisci i dati dell'oculare</h1><br>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                <div class="row">
                    <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                        <label>Nome *</label><input type="text" name="nome">
                    </div>
                    <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                        <label>Marca *</label><input type="text" name="marca">
                    </div>
                    <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                        <label>Descrizione</label><textarea name="descrizione"></textarea>
                    </div>
                    <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                        <label>Disponibilit&agrave; *</label><input type="number" name="disponibilita">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                        <label>Dimensione *</label><input type="number" name="dimensione" step=any>
                    </div>
                    <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                        <label>Note</label><textarea name="note"></textarea>
                    </div>
                    <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                        <label>Lunghezza focale *</label><input type="number" name="lunghezza_focale" step=any>
                    </div>
                    <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                        <label>Campo visione apparente *</label><input type="number" name="campo_visione_apparente" step=any>
                    </div>
                </div>
              <input  id="contact-submit" class="btn" type="submit" name="invio" value="inserisci">
            </form>
        <?php
        } else {
            $nome = "";
            $marca = "";
            $descrizione = "";
            $disponibilita = "";
            $note = "";
            $dimensione = 0;
            $lunghezza_focale = 0;
            $campo_visione_apparente = 0;
            if ($_REQUEST["nome"] != "" && $_REQUEST["marca"] != "" && $_REQUEST["disponibilita"] != "" && $_REQUEST["dimensione"] != "" && $_REQUEST["lunghezza_focale"] != "" && $_REQUEST["campo_visione_apparente"]!="") {
                $nome = $_REQUEST["nome"];
                $marca = $_REQUEST["marca"];
                $descrizione = $_REQUEST["descrizione"];
                $disponibilita = $_REQUEST["disponibilita"];
                $note = $_REQUEST["note"];
                $dimensione = $_REQUEST["dimensione"];
                $lunghezza_focale = $_REQUEST["lunghezza_focale"];
                $campo_visione_apparente = $_REQUEST["campo_visione_apparente"];

                $nome = nl2br(htmlentities($nome, ENT_QUOTES, 'UTF-8'));
                $marca = nl2br(htmlentities($marca, ENT_QUOTES, 'UTF-8'));
                $descrizione = nl2br(htmlentities($descrizione, ENT_QUOTES, 'UTF-8'));
                $disponibilita = nl2br(htmlentities($disponibilita, ENT_QUOTES, 'UTF-8'));
                $note = nl2br(htmlentities($note, ENT_QUOTES, 'UTF-8'));
                $dimensione = nl2br(htmlentities($dimensione, ENT_QUOTES, 'UTF-8'));
                $lunghezza_focale = nl2br(htmlentities($lunghezza_focale, ENT_QUOTES, 'UTF-8'));
                $campo_visione_apparente = nl2br(htmlentities($campo_visione_apparente, ENT_QUOTES, 'UTF-8'));

                $sql="INSERT INTO oculare(nome,marca,descrizione,disponibilita,note,dimensione,lunghezza_focale,campo_visione_apparente) VALUES ('".addslashes($nome)."','".addslashes($marca)."','".addslashes($descrizione)."',".addslashes($disponibilita).",'".addslashes($note)."',".addslashes($dimensione).",".addslashes($lunghezza_focale).",".addslashes($campo_visione_apparente).");";
                if (mysqli_query($conn, $sql)) {
                ?>
                    <script>
                        swal({title:"Inserimento effettuato!",type:"success",showConfirmButton:false});
                    </script>
                    <?php
                    header("Refresh:2; url=inserisciOculare.php", true, 303);
                } else {
                    die("Errore nella query: ". $sql ."\n". mysqli_error($conn));
                }
                mysqli_close($conn);
            } else {
            ?>
                <script>
                    swal({title:"Attenzione!",text:"Tutti i campi obbligatori, contrassegnati da *, devono essere inseriti.",type:"warning",showConfirmButton:false});
                </script>
                <?php
                header("Refresh:3; url=inserisciOculare.php", true, 303);
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

