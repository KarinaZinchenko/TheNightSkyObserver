<head>
    <title>Vista soci</title>
</head>
<?php
session_start();
include("config.php");
include("header.php");
include("navbar.php");
echo "<div class='container'>";
echo "<div class='row-fluid'>";
echo "<div class='span10 offset1'>";
if (isset($_SESSION["autenticato"]) && isset($_SESSION["tipo"])) {
    # if ($_SESSION["tipo"] == "amministratore")|| $_SESSION["tipo"] == "regolare") {
        # if (!isset($_POST["invio"])) {
        ?>

        <div class="featured-heading">
            <h1>Soci dell'osservatorio</h1><br>
 <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 form-group">
                 <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                    <label>Selezionare il campo su cui eseguire la ricerca</label>
                    <select class="soflow-color" name="scelta_ricerca">
                        <option value="nome">Nome </option>
                        <option value="cognome">Cognome </option>
                        <option value="numero_socio">Numero Socio </option>
                    </select>
                </div> 

                <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                    <label>Valore da cercare</label><input type="text" name="valore_ricerca" placeholder="Cosa vuoi cercare?">
                </div> 
                <input id="contact-submit" class="btn" type="submit" name="invio_ricerca" value="Cerca">
                </form>
</div>
            <table class="table">
                <thead class="thead-default">
                    <tr>
                        <th>Nome</th>
                        <th>Cognome</th>
                        <th>Numero socio</th>
                        <th>Data di nascita</th>
                    </tr>
                </thead>
                <?php
                $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');
                if(isset($_POST["invio_ricerca"]))
                {
                   $condizione=$_POST["scelta_ricerca"];
                   $valore=$_POST["valore_ricerca"];
                   $aux=$valore;
                   $valore=strtoupper(substr($valore, 0,1)).substr($aux,1);
                   echo $valore;

                $stmt = $conn->prepare("SELECT numero_socio, nome, cognome, data_nascita FROM anagrafica WHERE ".$condizione."='".$valore."';");
                }
                else
                {
                $stmt = $conn->prepare("SELECT numero_socio, nome, cognome, data_nascita FROM anagrafica");
                }

                # Salvo in una variabile se la query può non andare a buon fine ma può non andare a buon fine?
                $result = $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $row_count = $stmt->rowCount();
                if ($row_count > 0) {
                    echo "<tbody>";
                    foreach ($rows as $row) {
                        echo "<tr>";
                        # Devo passare l'ID per pescarlo come GET nell'altra pagina, può dare problemi?
                        echo "<td>". $row['nome'] ."</td>";
                        echo "<td>". $row['cognome'] ."</td>";
                        echo "<td>". $row['numero_socio'] ."</td>";
                        echo "<td>". $row['data_nascita'] ."</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                }
                ?>
            </table>
        </div>
        <?php
} else
{?>
    <script>
        swal({title:"Oops...!",text:"Non sei autorizzato.",type:"error",showConfirmButton:false});
    </script>
    <?php
    header("Refresh:2; index.php", true, 303);

}
echo "</div>";
echo "</div>";
echo "</div>";

include("footer.php");
?>
