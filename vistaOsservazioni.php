<head>
    <title>Vista osservazioni</title>
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
    # if ($_SESSION["tipo"] == "amministratore") {
        # if (!isset($_POST["invio"])) {
        ?>
        <div class="featured-heading">
             <h1>Osservazioni</h1>
           <div id ="contact-info-ricerca" class="contact-info">
              <div id="panel-body-ricerca" class="panel-body">
                 <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                  <div class="col-xs-12 col-sm-2 col-md-2 form-group">
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3 form-group">
                        <label  id="label-ricerca">Valore da cercare</label>
                        <input style="margin-bottom: 0; margin-right:0; min-height: 34px;" type="text" name="valore_ricerca" placeholder="Cosa vuoi cercare?">
                    </div>
                  <div class="col-xs-12 col-sm-3 col-md-3 form-group">
                      <label id="label-ricerca">Campo di ricerca</label>
                      <select style="margin-bottom: 0;" class="soflow-color" name="scelta_ricerca">
                          <option value="id_osservazioni">ID </option>
                          <option value="stato">Stato</option>
                      </select>
                  </div>
                    <div class="col-xs-12 col-sm-2 col-md-2 form-group" style="top:20px;">
                    <input id="contact-submit" class="btn" type="submit" name="invio_ricerca" value="Cerca">
                    </div>
                    <div class="col-xs-12 col-sm-2 col-md-2 form-group">
                    </div>
                </form>
                </div>
            </div>
             <br>
            <table class="table">
                <thead class="thead-default">
                 <tr>
                   <th></th>
                   <th>Stato</th>
                 </tr>
               </thead>
                <?php
                $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');
                #$stmt = $conn->prepare("SELECT d_oss.stato, ogg.nome, d_oss.id_osservazioni FROM datiosservazione AS d_oss JOIN oggettoceleste AS ogg ON ogg.id = d_oss.id_oggettoceleste");
                if (isset($_POST["invio_ricerca"])) {
                    $condizione = $_POST["scelta_ricerca"];
                    $valore = $_POST["valore_ricerca"];
                    $aux = $valore;
                    $valore = strtoupper(substr($valore, 0, 1)).substr($aux, 1);
                    echo "<h3 style='color:#d3b483;'>Risultati per '".$valore."'</h3><br>";
                    $stmt = $conn->prepare("SELECT DISTINCT stato, id_osservazioni FROM datiosservazione WHERE  LOWER(".$condizione.")=LOWER('".$valore."');");
                    $ricerca = true;
                } else {
                    $ricerca = false;
                    # $stmt = $conn->prepare("SELECT d_oss.stato, ogg.nome, d_oss.id_osservazioni FROM datiosservazione AS d_oss JOIN oggettoceleste AS ogg ON ogg.id = d_oss.id_oggettoceleste");
                    $stmt = $conn->prepare("SELECT DISTINCT d_oss.id_osservazioni, d_oss.stato, d_oss.ora_inizio, ar.nome AS area, an.nome AS nome, an.cognome AS cognome
                        FROM datiosservazione AS d_oss
                        JOIN
                            (
                            osservazioni AS oss
                            JOIN areageografica AS ar ON ar.id=oss.id_area_geografica
                            JOIN anagrafica AS an ON an.numero_socio=oss.id_anagrafica
                            ) ON oss.id=d_oss.id_osservazioni
                        ");
                }

                # Salvo in una variabile se la query può non andare a buon fine ma può non andare a buon fine?
                $result = $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $row_count = $stmt->rowCount();
                if ($row_count > 0) {
                    echo "<tbody>";
                    $first_row = true;
                    $temp_id = $rows[0]['id_osservazioni'];
                    foreach ($rows as $row) {
                        if ($row['id_osservazioni'] != $temp_id || $first_row) {
                            $first_row = false;
                            # $stmt = $conn->prepare("SELECT * FROM oggettoceleste WHERE ID = :idOggettoCeleste");
                            # $stmt->bindValue(":idOggettoCeleste", $row['id_oggettoceleste'], PDO::PARAM_INT);
                            # $result = $stmt->execute();
                            # $oggettoceleste = $stmt->fetch();
                            # $nomeOggettoceleste = $row['nome'];
                            echo "<tr>";
                            # Devo passare l'ID per pescarlo come GET nell'altra pagina, può dare problemi?
                            # echo "<td><a href=\"vistaOsservazione.php?id=". $row['id_osservazioni'] ."\">Osservazione numero: ".     $row['id_osservazioni'] ."</td>";
                            $luogo = $row['area'];
                            $ora = $row['ora_inizio'];
                            $nome = $row['nome'];
                            $cognome = $row['cognome'];
                            $id_osservazioni = $row['id_osservazioni'];
                            if (empty($ora)) {
                                echo "<td><a href=\"vistaOsservazione.php?id=". $row['id_osservazioni'] ."\">Osservazione di $nome $cognome a $luogo</a></td>";
                            } else {
                                $ora_date = date('d-m-Y', strtotime(str_replace('-', '/', $ora)));
                                echo "<td><a href=\"vistaOsservazione.php?id=". $row['id_osservazioni'] ."\">Osservazione di $nome $cognome a $luogo del $ora_date</a></td>";
                            }
                            /*
                            echo "<td>". $id_osservazioni ."</td>";
                            echo "<td>". $luogo . "</td>";
                            echo "<td>$nome $cognome</td>";
                            echo "<td>". $ora_date ."</td>";
                            */
                            if ($row['stato'] == 'conclusa') {
                                $stato = "Conclusa";
                            } else {
                                $stato = "Pianificata";
                            }
                            echo "<td>". $stato ."</td>";
                            # echo "<td><a href=\"vistaOsservazione.php?id=". $row['id_osservazioni'] ."\"><img     src=\"http://lorempixel.com/40/40/cats/\"></a></td>";
                            echo "</tr>";
                        }
                        $temp_id = $row['id_osservazioni'];
                    }
                    echo "</tbody>";
                }
                ?>
           </table>
            <?php
            if ($row_count <= 0 && $ricerca) {
                echo "<h3 style='color:#d3b483;'>Nessun risultato ottenuto  per '".$valore."'</h3><br>";
            }
            ?>
         </div>

        <?php
} else {?>
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
