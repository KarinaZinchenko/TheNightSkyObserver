<head>
    <title>Vista osservazioni programmate</title>
    <script src="/js/jquery-1.9.1.js"></script>
    <script>
        function printPage() {
            window.print();
        }

        function toggleTab(elem) {
          var id = $(elem).attr("id");
          var number = id.split("_")[1];
          var selected = "tab_" + number;
          $('#' + selected).toggle();
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
    # if ($_SESSION["tipo"] == "amministratore")|| $_SESSION["tipo"] == "regolare") {
        # if (!isset($_POST["invio"])) {
        ?>
        <div class="featured-heading">
             <h1>Osservazioni programmate</h1><br>
            <!--<table class="table">
                <thead class="thead-default">
                 <tr>
                   <th>Descrizione</th>
                   <th>Note</th>
                   <th>Ora inizio</th>
                   <th>Ora fine</th>
                   <th>Immagine</th>
                     <th>Oggetto celeste</th>
                     <th>Strumento</th>
                     <th>Oculare</th>
                     <th>Filtro</th>
                     <th>Categoria</th>
                     <th>Sito</th>
                     <th>Osservatore</th>
                 </tr>
               </thead>-->
                <?php
                $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');

                /*$stmt = $conn->prepare("SELECT d_oss.descrizione, d_oss.note, d_oss.ora_fine, d_oss.ora_inizio
                                        FROM datiosservazione AS d_oss
                                        WHERE d_oss.stato = :stato
                                        ");
                */
                $stmt = $conn->prepare("SELECT d_oss.descrizione, d_oss.note, d_oss.ora_fine, d_oss.ora_inizio, d_oss.immagine , ogg.nome AS oggetto, s.nome AS strumento, o.nome AS oculare, f.nome AS filtro, oss.categoria AS categoria, ar.nome AS area, an.nome AS nome, an.cognome AS cognome
                                        FROM datiosservazione AS d_oss
                                        JOIN oggettoceleste AS ogg ON ogg.id=d_oss.id_oggettoceleste
                                        JOIN strumento AS s ON s.id=d_oss.id_strumento
                                        LEFT JOIN oculare AS o ON (d_oss.id_oculare IS NOT NULL AND d_oss.id_oculare=o.id)
                                        LEFT JOIN filtro_altro AS f ON (d_oss.id_filtro IS NOT NULL AND d_oss.id_filtro=f.id)
                                        LEFT JOIN
                                        (
                                             osservazioni AS oss
                                             JOIN areageografica AS ar ON ar.id=oss.id_area_geografica
                                             JOIN anagrafica AS an ON an.numero_socio=oss.id_anagrafica
                                        )ON oss.id=d_oss.id_osservazioni
                                        WHERE d_oss.stato = :stato
                                        ORDER BY d_oss.ora_inizio ASC
                                        ");


                # Salvo in una variabile se la query può non andare a buon fine ma può non andare a buon fine?
                $result = $stmt->execute(array(':stato' => 'pianificata'));
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $row_count = $stmt->rowCount();

                if ($row_count > 0) {
                    $counter = 1;
                    foreach ($rows as $row) {
                        echo "<p><img src=\"http://lorempixel.com/40/40/cats/\" id=\"icon_$counter\" onclick=\"toggleTab(this)\" />";
                        echo $row['oggetto'];
                        echo "</p>";
                        echo "<div style=\"display: none\" id=\"tab_$counter\">";
                        echo "<p>Descrizione: ". $row['descrizione'] ."</p>";
                        echo "<p>Note: ". $row['note'] ."</p>";
                        echo "<p>Ora inizio: ". $row['ora_inizio'] ."</p>";
                        echo "<p>Ora fine: ". $row['ora_fine'] ."</p>";
                        if (file_exists($row['immagine'])) {
                            echo "<a href=\"". $row['immagine'] ."\"> <img src=\"" .$row['immagine']."\" width=\"70\" height= \"50\"/>"." </a>";
                        } else {
                            echo "<img src=\"immagini/noimagefound.jpg\" width=\"70\" height= \"50\"/>";
                        }
                        echo "</p>";
                        echo "<p>Oggetto celeste: ". $row['oggetto'] ."</p>";
                        echo "<p>Strumento: ". $row['strumento'] ."</p>";
                        echo "<p>Oculare: ". $row['oculare'] ."</p>";
                        echo "<p>Filtro: ". $row['filtro'] ."</p>";
                        echo "<p>Categoria: ". $row['categoria'] ."</p>";
                        echo "<p>Area geografica: ". $row['area'] ."</p>";
                        echo "<p>Autore: ". $row['nome'].' '. $row['cognome'] ."</p>";
                        echo "</div>";
                        $counter = $counter + 1;
                    }
                    /*echo "<tbody>";
                    foreach ($rows as $row) {
                        echo "<tr>";
                        # Devo passare l'ID per pescarlo come GET nell'altra pagina, può dare problemi?
                        echo "<td>". $row['descrizione'] ."</td>";
                        echo "<td>". $row['note'] ."</td>";
                        echo "<td>". $row['ora_inizio'] ."</td>";
                        echo "<td>". $row['ora_fine'] ."</td>";
                        if (file_exists($row['immagine'])) {
                            echo "<td><a href=\"". $row['immagine'] ."\"> <img src=\"" .$row['immagine']."\" width=\"70\" height= \"50\"/>"." </a></td>";
                        } else {
                            echo "<td><img src=\"immagini/noimagefound.jpg\" width=\"70\" height= \"50\"/>"." </td>";
                        }
                        echo "<td>". $row['oggetto'] ."</td>";
                        echo "<td>". $row['strumento'] ."</td>";
                        echo "<td>". $row['oculare'] ."</td>";
                        echo "<td>". $row['filtro'] ."</td>";
                        echo "<td>". $row['categoria'] ."</td>";
                        echo "<td>". $row['area'] ."</td>";
                        echo "<td>". $row['nome'].' '. $row['cognome'] ."</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";*/
                }
                ?>
         <!--</table>-->
         <br>
          <input id="contact-submit" class="btn" type="submit" value="Stampa" onclick="printPage()">
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
