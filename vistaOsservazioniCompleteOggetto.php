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
        if (isset($_POST["invio_ricerca"])) {
        ?>
        <div class="featured-heading">
                <h1>Oggetti celesti osservati</h1><br>
                <table class="table">
                    <thead class="thead-default">
                    <tr>
                        <th>Osservazione</th>
                        <th>Ora inizio</th>
                        <th>Ora fine</th>
                        <th>Rating</th>
                        <th>Immagine</th>
                        <th>Descrizione</th>
                        <th>Note</th>
                        <th>Strumento</th>
                        <th>Oculare</th>
                        <th>Filtro</th>
                    </tr>
                    </thead>
        <?php
            $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');

            $stmt = $conn->prepare("SELECT d_oss.id_osservazioni, d_oss.rating, d_oss.descrizione, d_oss.immagine, d_oss.note, d_oss.ora_fine, d_oss.ora_inizio, s.nome AS strumento, o.nome AS oculare, f.nome AS filtro
                            FROM datiosservazione AS d_oss
                            JOIN strumento AS s ON s.id=d_oss.id_strumento
                            LEFT JOIN oculare AS o ON (d_oss.id_oculare IS NOT NULL AND d_oss.id_oculare=o.id)
                            LEFT JOIN filtro_altro AS f ON (d_oss.id_filtro IS NOT NULL AND d_oss.id_filtro=f.id)
                            WHERE d_oss.id_oggettoceleste = :idOggetto AND d_oss.stato = :stato ORDER BY d_oss.ora_fine DESC ");
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
                    echo "<tr>";
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
                    echo "</tr>";
                }
                echo "</tbody>";
            } ?>
                </table><br>
                 <input id="contact-submit" class="btn" type="submit" value="Stampa" onclick="printPage()">
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

            <label>Tipo oggetto &nbsp;&nbsp; </label><select id="soflow-color" name="tipo_oggetto" onchange="fetch_select(this.value);">
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

            <label>Oggetto celeste &nbsp;&nbsp;</label><select id="soflow-color" name="id_oggetto">
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

