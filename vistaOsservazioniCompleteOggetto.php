<?php
ob_start();
?>

<head>
    <title>Vista oggetti celesti</title>
    <script type="text/javascript" src="js/jquery-1.9.1.js"></script>
    <script type="text/javascript">
        function fetch_select(val)
        {
            $.ajax({
                async: true,
                type: 'post',
                data: {
                    get_option:val
                },
                success: function (response) {
                    document.getElementsByName("id_oggetto")[0].innerHTML=response;

                }
            });
        }

    </script>
     <script>
        function printPage() {
            window.print();
        }
    </script>
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
        if (isset($_POST["invio_ricerca"]) || isset($_POST["invio_ricerca2"])) {
        ?>
        <div class="featured-heading">
                <h1>Osservazioni per oggetto celeste selezionato</h1>
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
                          <option value="an.cognome">Cognome osservatore </option>
                          <option value="ar.nome">Luogo</option>
                          <option value="d_oss.rating">Rating</option>
                      </select>
                  </div>
                    <div class="col-xs-12 col-sm-2 col-md-2 form-group" style="top:20px;">
                    <input id="contact-submit" class="btn" type="submit" name="invio_ricerca2" value="Cerca">
                    <?php
                    if(isset($_POST["invio_ricerca"]))
                        {?>
                    <input class="btn" type="hidden" id="idUtente" name="id_oggetto" value="<?php echo $POST_['id_oggetto']; ?>" />
                    <?php   } ?>
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
                      <th>Osservazioni</th>
                      <th>Stato</th>
                        <!--<th>Osservazione</th>
                        <th>Ora inizio</th>
                        <th>Ora fine</th>
                        <th>Rating</th>
                        <th>Immagine</th>
                        <th>Descrizione</th>
                        <th>Note</th>
                        <th>Strumento</th>
                        <th>Oculare</th>
                        <th>Filtro</th>-->
                    </tr>
                    </thead>
        <?php
            $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');
            if(isset($_POST["invio_ricerca"]))
            {
                $_SESSION["id_oggetto"]=$_POST["id_oggetto"];
            }
            if(isset($_POST["invio_ricerca2"]))
                {
                   $condizione=$_POST["scelta_ricerca"];
                   $valore=$_POST["valore_ricerca"];
                   //$aux=$valore;
                   //$valore=strtoupper(substr($valore, 0,1)).substr($aux,1);
                   echo "<h3 style='color:#d3b483;'>Risultati per '".$valore."'</h3><br>";

               $stmt = $conn->prepare("SELECT d_oss.id_osservazioni, d_oss.rating, d_oss.descrizione, d_oss.immagine, d_oss.note, d_oss.ora_fine, d_oss.ora_inizio, s.nome AS strumento, o.nome AS oculare, f.nome AS filtro
                            FROM anagrafica AS an, strumento AS s, areageografica AS ar,  osservazioni AS oss, datiosservazione AS d_oss
                            LEFT JOIN oculare AS o ON (d_oss.id_oculare IS NOT NULL AND d_oss.id_oculare=o.id)
                            LEFT JOIN filtro_altro AS f ON (d_oss.id_filtro IS NOT NULL AND d_oss.id_filtro=f.id)
                            WHERE s.id=d_oss.id_strumento AND oss.id=d_oss.id_osservazioni AND   d_oss.id_oggettoceleste =:idOggetto AND ar.id=oss.id_area_geografica AND an.numero_socio=oss.id_anagrafica AND d_oss.stato =:stato AND LOWER(".$condizione.")=LOWER('".$valore."') ORDER BY d_oss.ora_fine DESC ");
                $ricerca=true;


              } else {

            $stmt = $conn->prepare("SELECT d_oss.id_osservazioni, d_oss.rating, d_oss.descrizione, d_oss.immagine, d_oss.note, d_oss.ora_fine, d_oss.ora_inizio, d_oss.stato, s.nome AS strumento, o.nome AS oculare, f.nome AS filtro, an.nome as nome, an.cognome as cognome, ar.nome as area
                            FROM datiosservazione AS d_oss
                            JOIN
                              (
                                osservazioni as oss
                                JOIN areageografica AS ar ON ar.id=oss.id_area_geografica
                                JOIN anagrafica AS an ON an.numero_socio=oss.id_anagrafica
                              ) ON oss.id=d_oss.id_osservazioni
                            LEFT JOIN strumento AS s ON s.id=d_oss.id_strumento
                            LEFT JOIN oculare AS o ON (d_oss.id_oculare IS NOT NULL AND d_oss.id_oculare=o.id)
                            LEFT JOIN filtro_altro AS f ON (d_oss.id_filtro IS NOT NULL AND d_oss.id_filtro=f.id)
                            WHERE d_oss.id_oggettoceleste = :idOggetto AND d_oss.stato = :stato ORDER BY d_oss.ora_fine DESC ");
              }
            //echo '<script>console.log('.$_POST["id_oggetto"].')</script>';
            $stmt->bindValue(":idOggetto", $_POST["id_oggetto"], PDO::PARAM_INT);
            $stmt->bindValue(":stato", "conclusa", PDO::PARAM_STR);
            # Salvo in una variabile se la query può non andare a buon fine ma può non andare a buon fine?
            $result = $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $row_count = $stmt->rowCount();
            if ($row_count > 0) {
                echo "<tbody>";
                foreach ($rows as $row) {
                    $rating = $row['rating'];
                    $descrizione = $row['descrizione'];
                    $immagine = $row['immagine'];
                    $note = $row['note'];
                    $ora_fine = $row['ora_fine'];
                    $ora_inizio = $row['ora_inizio'];
                    $strumento = $row['strumento'];
                    $oculare = $row['oculare'];
                    $filtro = $row['filtro'];
                    $nome = $row['nome'];
                    $cognome = $row['cognome'];
                    $luogo = $row['area'];
                    $stato = $row['stato'];
                    echo "<tr>";
                    if (empty($ora_inizio)) {
                        echo "<td><a href=\"vistaOsservazione.php?id=". $row['id_osservazioni'] ."\">Osservazione di $nome $cognome a $luogo</a></td>";
                    } else {
                        $ora_date = date('d-m-Y', strtotime(str_replace('-', '/', $ora_inizio)));
                        echo "<td><a href=\"vistaOsservazione.php?id=". $row['id_osservazioni'] ."\">Osservazione di $nome $cognome a $luogo del $ora_date</a></td>";
                    }
                    echo "<td>". $stato ."</td>";
                    /*
                    echo "<td style='text-align: center'><a href=\"vistaDettagliOsservazioneCompletaOggetto.php?id=". $row['id_osservazioni'] ."\"> <span class=\"glyphicon glyphicon-search\"></span> </td>";
                    echo "<td>". $ora_inizio ."</td>";
                    echo "<td>". $ora_fine ."</td>";
                    echo "<td>". $rating ."</td>";
                    if(file_exists($row['immagine'])){
                        echo "<td><a href=\"". $row['immagine'] ."\"> <img src=\"" .$row['immagine']."\" width=\"70\" height= \"50\"/>"." </a></td>";
                    }
                    else{
                        echo "<td><img src=\"immagini/noimagefound.jpg\" width=\"70\" height= \"50\"/>"." </td>";
                    }
                    echo "<td>". $descrizione ."</td>";
                    echo "<td>". $note ."</td>";
                    echo "<td>". $strumento ."</td>";
                    echo "<td>". $oculare ."</td>";
                    echo "<td>". $filtro ."</td>";
                    */
                    echo "</tr>";
                }
                echo "</tbody>";
            } ?>
                </table><br>
                <?php
                if($row_count <= 0 && $ricerca)
                      {
                             echo "<h3 style='color:#d3b483;'>Nessun risultato ottenuto  per '".$valore."'</h3><br>";
                        }?>

        </div>
            <?php
        }
        else{

            ?>
        <div class="featured-heading">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" >
            <h1>Selezionare il tipo e l'oggetto celeste</h1>
                <h3 style="text-transform: none">per visualizzare le osservazioni complete su di esso</h3>
                <br>
            <?php
            if(isset($_POST['get_option']))
            {

                $tipo = $_POST['get_option'];
                echo '<script>console.log('.$tipo.')</script>';
                $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');
                $stmt = $conn->prepare("SELECT * FROM oggettoceleste WHERE tipo_oggetto='$tipo'");
                # Salvo in una variabile se la query può non andare a buon fine ma può non andare a buon fine?
                $result = $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $row_count = $stmt->rowCount();

                if ($row_count > 0) {
                    echo '<option value="">Selezionare oggetto</option>';
                    foreach ($rows as $row) {
                        $id_oggetto = $row['ID'];
                        $nome=$row['nome'];
                        ?>
                        <option
                            value="<?php echo "$id_oggetto"; ?>"><?php echo "$nome";?> </option>
                        <?php
                    }
                }
                exit;
            }
            ?>

            <label style="color: white">Tipo oggetto &nbsp;&nbsp; </label><select id="soflow-color" name="tipo_oggetto" onchange="fetch_select(this.value);">
                <option value="">Selezionare tipo</option>
                <?php
                $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');
                $stmt = $conn->prepare("SELECT * FROM oggettoceleste GROUP BY tipo_oggetto");
                # Salvo in una variabile se la query può non andare a buon fine ma può non andare a buon fine?
                $result = $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $row_count = $stmt->rowCount();
                if ($row_count > 0) {
                    foreach ($rows as $row) {
                        $id_oggetto = $row['ID'];
                        $tipo_oggetto = $row['tipo_oggetto'];
                        ?>
                        <option
                            value="<?php echo "$tipo_oggetto"; ?>"><?php echo "$tipo_oggetto";?> </option>
                        <?php
                    }
                }
                ?>
            </select>
                <br>

            <label style="color: white">Oggetto celeste &nbsp;&nbsp;</label><select id="soflow-color" name="id_oggetto">
                <option value="">Selezionare prima il tipo</option>
            </select>
            <br>
            <input id="contact-submit" class="btn" type="submit" name="invio_ricerca" value="Seleziona"/>

            </form>
            </div>
        <?php
        }
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
