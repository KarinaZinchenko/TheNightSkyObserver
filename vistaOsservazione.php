<head>
    <title>Vista osservazione</title>
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
    # if ($_SESSION["tipo"] == "amministratore") {
        # if (!isset($_POST["invio"])) {
        $idOsservazione = $_GET['id'];
        $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');
        /*
        Così posso vedere tutti gli strumenti (anche i non disponibili) ma fin qui ci arrivo dalla lista degli
        strumenti disponibili a meno di non manomettere l'URL, sarà da gestire anche quel caso?
        */
        # $stmt = $conn->prepare("SELECT * FROM osservazioni WHERE id = :idOsservazione");
        $stmt = $conn->prepare("SELECT oss.categoria, oss.trasparenza, oss.seeing_antoniani, oss.seeing_pickering, area.nome AS nomeArea, anagrafica.nome, anagrafica.cognome FROM osservazioni AS oss JOIN areageografica AS area ON area.id = oss.id_area_geografica LEFT JOIN anagrafica ON anagrafica.numero_socio = oss.id_anagrafica WHERE oss.id = :idOsservazione");
        $stmt->bindValue(":idOsservazione", $idOsservazione, PDO::PARAM_INT);
        # Salvo in una variabile se la query può non andare a buon fine ma può non andare a buon fine?
        $result = $stmt->execute();
        $row = $stmt->fetch();
        $categoria = $row['categoria'];
        $trasparenza = $row['trasparenza'];
        $seeingAntoniani = $row['seeing_antoniani'];
        $seeingPickering = $row['seeing_pickering'];
        # $idAreaGeografica = $row['id_area_geografica'];
        # $idAnagrafica = $row['id_anagrafica'];
        # $stmt = $conn->prepare("SELECT nome FROM areageografica WHERE id = :idAreaGeografica");
        # $stmt->bindValue(":idAreaGeografica", $idAreaGeografica, PDO::PARAM_INT);
        # $result = $stmt->execute();
        # $row = $stmt->fetch();
        $nomeAreaGeografica = $row['nomeArea'];
        # $stmt = $conn->prepare("SELECT nome, cognome FROM anagrafica WHERE numero_socio = :idAnagrafica");
        # $stmt->bindValue(":idAnagrafica", $idAnagrafica, PDO::PARAM_INT);
        # $result = $stmt->execute();
        # $row = $stmt->fetch();
        $nomeUtente = $row['nome'];
        $cognomeUtente = $row['cognome'];
        ?>
        <div class="featured-heading">
                <h1>Dettagli osservazione</h1><br>
                <?php
                /*
                Hm, effettivamente sto usando variabili che non hanno subito modifiche e potrei usare direttamente
                il risultato della query ma magari può servire fare operazioni su di esse (ad esempio: non stampare il
                tipo del telescopio se si tratta di un altro tipo di strumento)
                C'erano anche delle formule da calcolare
                */
                echo "<div style='text-align: justify;'>";
                echo "<div class='row' style='padding-left: 225px;'>";
                echo "<div class='col-lg-6 col-md-6 col-sm-12'><p><label id=\"label-open\">Categoria:</label>". $categoria ."</p></div> ";
                echo "<div class='col-lg-6 col-md-6 col-sm-12'><p><label id=\"label-open\">Trasparenza:</label>". $trasparenza ."</p></div> ";
                echo "</div>";
                echo "<div class='row' style='padding-left: 225px;'>";
                echo "<div class='col-lg-6 col-md-6 col-sm-12'><p><label id=\"label-open\">Seeing (Antoniani):</label>". $seeingAntoniani ."</p></div> ";
                echo "<div class='col-lg-6 col-md-6 col-sm-12'><p><label id=\"label-open\">Seeing (Pickering): </label>". $seeingPickering ."</p></div> ";
                echo "</div>";
                echo "<div class='row' style='padding-left: 225px;'>";
                echo "<div class='col-lg-6 col-md-6 col-sm-12'><p><label id=\"label-open\">Area geografica:</label>". $nomeAreaGeografica ."</p></div> ";
                echo "<div class='col-lg-6 col-md-6 col-sm-12'><p><label id=\"label-open\">Utente:</label>". $nomeUtente ." ". $cognomeUtente ."</p></div> ";
                echo "</div>";
                echo "</div>";
                ?>

            <br>

            <h2 id="titolo2">Oggetti osservati</h2>
            <br>

            <!--<table class="table">
                <thead class="thead-default">
                <tr>
                  <th>Stato</th>
                  <th>Rating</th>
                  <th>Descrizione</th>
                  <th>Immagine</th>
                  <th>Note</th>
                  <th>Ora inizio</th>
                  <th>Ora fine</th>
                  <th>Oggetto</th>
                  <th>Strumento</th>
                  <th>Oculare</th>
                  <th>Filtro</th>
                </tr>
              </thead> -->
                <?php
                $stmt = $conn->prepare("SELECT d_oss.stato, d_oss.rating, d_oss.descrizione, d_oss.immagine, d_oss.note, d_oss.ora_inizio, d_oss.ora_fine, ogg.nome AS nomeOggettoceleste, s.nome AS nomeStrumento, o.nome AS nomeOculare, f.nome AS nomeFiltro
                  FROM datiosservazione AS d_oss
                  JOIN oggettoceleste AS ogg ON ogg.id = d_oss.id_oggettoceleste
                  LEFT JOIN strumento AS s ON d_oss.id_strumento = s.id
                  LEFT JOIN oculare AS o ON (d_oss.id_oculare IS NOT NULL AND d_oss.id_oculare=o.id)
                  LEFT JOIN filtro_altro AS f ON (d_oss.id_filtro IS NOT NULL AND d_oss.id_filtro=f.id)
                  WHERE d_oss.id_osservazioni = :idOsservazione
                  ORDER BY d_oss.ora_inizio ASC");
                $stmt->bindValue(":idOsservazione", $idOsservazione, PDO::PARAM_INT);
                $result = $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $row_count = $stmt->rowCount();
                if ($row_count > 0) {
                    $counter = 1;

                    foreach ($rows as $row) {
                        echo "<div class='col-lg-2'></div>";
                        echo "<div class='col-lg-10'>";
                        echo "<p id='p-open' style=' padding-left: 40px;'>";
                        //echo "<p id='p-open'>";
                        echo "<a class='btn btn-default' id=\"icon_$counter\" onclick=\"toggleTab(this)\" style='margin-bottom: 2px; margin-left: 6px; margin-right: 6px;'><em class='fa fa-eye'></em></a>";
                        echo "<label id=\"label-open\">Oggetto celeste:</label> ". $row['nomeOggettoceleste'];
                        echo "</p>";
                        echo "<div id='div-open' style='padding-left: 89px;'>";
                        //echo "<div id='div-open'>";
                        echo "<div style=\"display: none\" id=\"tab_$counter\">";
                        echo "<p><label id=\"label-open\">Stato:</label>". $row['stato'] ."</p>";
                        echo "<p><label id=\"label-open\">Rating:</label> ". $row['rating'] ."</p>";
                        echo "<p><label id=\"label-open\">Descrizione:</label> ". $row['descrizione'] ."</p>";
                        echo "<p><label id=\"label-open\">Immagine:</label> ";
                        if (file_exists($row['immagine'])) {
                            echo "<a href=\"". $row['immagine'] ."\"> <img src=\"" .$row['immagine']."\" width=\"70\" height= \"50\"/>"." </a>";
                        } else {
                            echo "<img src=\"immagini/noimagefound.jpg\" width=\"70\" height= \"50\"/>";
                        }
                        echo "</p>";
                        echo "<p><label id=\"label-open\">Note:</label> ". $row['note'] ."</p>";
                        echo "<p><label id=\"label-open\">Ora inizio:</label> ". $row['ora_inizio'] ."</p>";
                        echo "<p><label id=\"label-open\">Ora fine:</label> ". $row['ora_fine'] ."</p>";
                        echo "<p><label id=\"label-open\">Strumento:</label> ". $row['nomeStrumento'] ."</p>";
                        echo "<p><label id=\"label-open\">Oculare:</label> ". $row['nomeOculare'] ."</p>";
                        echo "<p><label id=\"label-open\">Filtro:</label> ". $row['nomeFiltro'] ."</p>";
                        echo "<br>";
                        echo "</div>";

                        echo "</div>";
                        echo "</div>";
                        $counter = $counter + 1;
                    }
                    /*echo "<tbody>";
                    foreach ($rows as $row) {
                        echo "<tr>";
                        echo "<td>". $row['stato'] ."</td>";
                        echo "<td>". $row['rating'] ."</td>";
                        echo "<td>". $row['descrizione'] ."</td>";
                        if (file_exists($row['immagine'])) {
                            echo "<td><a href=\"". $row['immagine'] ."\"> <img src=\"" .$row['immagine']."\" width=\"70\" height= \"50\"/>"." </a></td>";
                        } else {
                            echo "<td><img src=\"immagini/noimagefound.jpg\" width=\"70\" height= \"50\"/>"." </td>";
                        }
                        echo "<td>". $row['note'] ."</td>";
                        echo "<td>". $row['ora_inizio'] ."</td>";
                        echo "<td>". $row['ora_fine'] ."</td>";
                        echo "<td>". $row['nomeOggettoceleste'] ."</td>";
                        echo "<td>". $row['nomeStrumento'] ."</td>";
                        echo "<td>". $row['nomeOculare'] ."</td>";
                        echo "<td>". $row['nomeFiltro'] ."</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";*/
                }
                ?>
            <!--</table> -->

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
