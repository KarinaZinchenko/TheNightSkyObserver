<!-- 09/05/2017 21:00 - Codice indentato -->
<?php
ob_start();
?>
<html>
<head> <title>Inserimento nuovo filtro</title> </head>
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
            <h1>Inserisci i dati del filtro</h1><br>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 form-group">
                        <label>Nome *</label><input type="text" name="nome">
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 form-group">
                        <label>Marca *</label><input type="text" name="marca">
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 form-group">
                        <label>Disponibilit&agrave; *</label><input type="number" name="disponibilita">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 form-group">
                        <label>Note</label><textarea name="note"></textarea>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 form-group">
                        <label>Descrizione</label><textarea name="descrizione"></textarea>
                    </div>
                </div>
                <input id="contact-submit" class="btn" type="submit" name="invio" value="inserisci">
            </form>
        <?php
        } else {
            $nome = "";
            $marca = "";
            $descrizione = "";
            $disponibilita = "";
            $note = "";
            if ($_REQUEST["nome"] != "" && $_REQUEST["marca"] != "" && $_REQUEST["disponibilita"] != "") {
                $nome = $_REQUEST["nome"];
                $marca = $_REQUEST["marca"];
                $descrizione = $_REQUEST["descrizione"];
                $disponibilita = $_REQUEST["disponibilita"];
                $note = $_REQUEST["note"];

                $nome = nl2br(htmlentities($nome, ENT_QUOTES, 'UTF-8'));
                $marca = nl2br(htmlentities($marca, ENT_QUOTES, 'UTF-8'));
                $descrizione = nl2br(htmlentities($descrizione, ENT_QUOTES, 'UTF-8'));
                $disponibilita = nl2br(htmlentities($disponibilita, ENT_QUOTES, 'UTF-8'));
                $note = nl2br(htmlentities($note, ENT_QUOTES, 'UTF-8'));

                $sql="INSERT INTO filtro_altro(nome,marca,note,disponibilita,descrizione) VALUES ('".addslashes($nome)."','".addslashes($marca)."','".addslashes($note)."',".addslashes($disponibilita).",'".addslashes($descrizione)."');";
                if (mysqli_query($conn, $sql)) {
                    ?>
                    <script>
                        swal({title:"Inserimento effettuato!",type:"success",showConfirmButton:false});
                    </script>
                    <?php
                    header("Refresh:2; url=inserisciFiltro.php", true, 303);
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
                header("Refresh:3; url=inserisciFiltro.php", true, 303);
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

