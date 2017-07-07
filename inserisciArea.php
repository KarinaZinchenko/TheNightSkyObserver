<?php
ob_start();
?>
<html>
<head> <title>Inserimento nuovo sito osservativo</title> </head>
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
             <h1>Inserisci i dati del sito osservativo</h1>  <br>
             <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" >
                 <div class="row">
                     <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                         <label>Nome *</label><input type="text" name="nome">
                     </div>
                     <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                         <label>Altitudine *</label><input type="number" step=any name="altitudine">
                     </div>
                     <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                         <label>Latitudine *</label><input type="number" step=any name="latitudine">
                     </div>
                     <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                         <label>Longitudine *</label><input type="number" step=any name="longitudine">
                     </div>

                     <div class="col-xs-6 col-sm-4 col-md-4 form-group">
                         <label>Qualit&agrave; cielo (Bortle)</label><input type="number" step=any name="bortle">
                     </div>
                     <div class="col-xs-6 col-sm-4 col-md-4 form-group">
                         <label>Qualit&agrave; cielo (SQM)</label><input type="number" step=any name="sqm">
                     </div>
                     <div class="col-xs-12 col-sm-4 col-md-4 form-group">
                         <label>Note</label><textarea name="note"></textarea>
                     </div>
                 </div>
                         <input id="contact-submit" class="btn" type="submit" name="invio" value="inserisci">
             </form>
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

                //query per verificare che il sito osservativo non sia gia presente nel sistema
                $ok=true;
                $sql="SELECT altitudine,latitudine,longitudine FROM areageografica;";
                $risposta=mysqli_query($conn,$sql)or die("Errore nella query: " . $sql . "\n" . mysqli_error($conn));
               if(mysqli_num_rows($risposta)!=0)
             {
                  while ($tupla = mysqli_fetch_array($risposta))
                       { 
                         if($tupla["altitudine"]==$altitudine && $tupla["latitudine"]==$latitudine && $tupla["longitudine"]==$longitudine)
                         {
                             $ok=false;
                         }
                       }
             }
          if($ok)
          {
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
                    if (empty($sqm)) {
                        $bortle = null;
                    }
                    else {
                        $bortle = conversionToBortle($sqm);
                    }
                }
                if (empty($sqm)) {
                    $sqm = null;
                }
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
                ?>
                    <script>
                        swal({title:"Inserimento effettuato!",type:"success",showConfirmButton:false});
                    </script>
                    <?php
                    header("Refresh:2; url=inserisciArea.php", true, 303);
                } else {
                    ?>
                    <script>
                        swal({title:"Attenzione!",text:"errore nella query.",type:"warning",showConfirmButton:false});
                    </script>
                    <?php
                    header("Refresh:2; url=inserisciArea.php", true, 303);
                }
                $conn = null;
                $stmt = null;
            }// choudo if perverificare che quello che sto inserendo non sia gia presente
            else
            {
                ?>
                <script>
                    swal({title:"Attenzione!",text:"L'area inserita esiste già",type:"warning",showConfirmButton:false});
                </script>
                <?php
                header("Refresh:3; url=inserisciArea.php", true, 303);
            }

            } else { //chiudo if per verificare che i campi siano stati inseriti
                    ?>
                <script>
                    swal({title:"Attenzione!",text:"Tutti i campi obbligatori, contrassegnati da *, devono essere inseriti.",type:"warning",showConfirmButton:false});
                </script>
                <?php
                header("Refresh:3; url=inserisciArea.php", true, 303);
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

<?php
function conversionToBortle ($sqm){
    if($sqm <=22.00 && $sqm >= 21.99){
        return 1;
    }
    if($sqm <21.99 && $sqm >= 21.89){
        return 2;
    }
    if($sqm <21.89 && $sqm >= 21.69){
        return 3;
    }
    if($sqm <21.69 && $sqm >= 20.49){
        return 4;
    }
    if($sqm <20.49 && $sqm >= 19.5){
        return 5;
    }
    if($sqm <19.5 && $sqm >= 18.95){
        return 6;
    }
    if($sqm <18.95 && $sqm >= 18.38){
        return 7;
    }
    if($sqm <18.38 && $sqm >= 17.8){
        return 8;
    }
    if($sqm > 17.8){
        return 9;
    }
}
?>

