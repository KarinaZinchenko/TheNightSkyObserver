<?php
session_start();
include("config.php");
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
        <html>
        <head>
          <title>Vista osservazione</title>
          <script>
              function printPage() {
                  window.print();
              }
         </script>
         </head>
         <body>
           <center>
             <h1>Dettagli osservazione</h1><br><br>
             <table>
               <thead>
                 <tr>
                   <th>Categoria</th>
                   <th>Trasparenza</th>
                   <th>Seeing (Antoniani)</th>
                   <th>Seeing (pickering)</th>
                   <th>Area geografica</th>
                   <th>Utente</th>
                 </tr>
               </thead>
               <tbody>
                 <tr>
                <?php
                /*
                Hm, effettivamente sto usando variabili che non hanno subito modifiche e potrei usare direttamente
                il risultato della query ma magari può servire fare operazioni su di esse (ad esempio: non stampare il
                tipo del telescopio se si tratta di un altro tipo di strumento)
                C'erano anche delle formule da calcolare
                */
                echo "<td>". $categoria ."</td>";
                echo "<td>". $trasparenza ."</td>";
                echo "<td>". $seeingAntoniani ."</td>";
                echo "<td>". $seeingPickering ."</td>";
                echo "<td>". $nomeAreaGeografica ."</td>";
                echo "<td>". $nomeUtente ." ". $cognomeUtente ."</td>";
                ?>
                </tr>
              </tbody>
            </table>
            <h2>Oggetti osservati</h2>
            <table>
              <thead>
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
              </thead>
                <?php
                $stmt = $conn->prepare("SELECT d_oss.stato, d_oss.rating, d_oss.descrizione, d_oss.immagine, d_oss.note, d_oss.ora_inizio, d_oss.ora_fine, ogg.nome AS nomeOggettoceleste, s.nome AS nomeStrumento, o.nome AS nomeOculare, f.nome AS nomeFiltro
                  FROM datiosservazione AS d_oss
                  JOIN oggettoceleste AS ogg ON ogg.id = d_oss.id_oggettoceleste
                  LEFT JOIN strumento AS s ON d_oss.id_strumento = s.id
                  LEFT JOIN oculare AS o ON (d_oss.id_oculare IS NOT NULL AND d_oss.id_oculare=o.id)
                  LEFT JOIN filtro_altro AS f ON (d_oss.id_filtro IS NOT NULL AND d_oss.id_filtro=f.id)
                  WHERE d_oss.id_osservazioni = :idOsservazione");
                $stmt->bindValue(":idOsservazione", $idOsservazione, PDO::PARAM_INT);
                $result = $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $row_count = $stmt->rowCount();
                if ($row_count > 0) {
                    echo "<tbody>";
                    foreach ($rows as $row) {
                        echo "<tr>";
                        echo "<td>". $row['stato'] ."</td>";
                        echo "<td>". $row['rating'] ."</td>";
                        echo "<td>". $row['descrizione'] ."</td>";
                        echo "<td>". $row['immagine'] ."</td>";
                        echo "<td>". $row['note'] ."</td>";
                        echo "<td>". $row['ora_inizio'] ."</td>";
                        echo "<td>". $row['ora_fine'] ."</td>";
                        echo "<td>". $row['nomeOggettoceleste'] ."</td>";
                        echo "<td>". $row['nomeStrumento'] ."</td>";
                        echo "<td>". $row['nomeOculare'] ."</td>";
                        echo "<td>". $row['nomeFiltro'] ."</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                }
                ?>
            </table>
           <button onclick="printPage()">Stampa</button>
           </center>
         </body>
         </html>
        <?php
} else {
    echo "<script language='javascript'>";
    echo "alert('Non sei autorizzato ');";
    echo "</script>";
    header("Refresh:0; index.php", true, 303);
}
?>
