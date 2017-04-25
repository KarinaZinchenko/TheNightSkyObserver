<?php
session_start();
include("config.php");
if (isset($_SESSION["autenticato"]) && isset($_SESSION["tipo"])) {
    $idOggetto = $_GET['id'];
    $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');

    $stmt = $conn->prepare("SELECT d_oss.id_osservazioni, d_oss.rating, d_oss.descrizione, d_oss.immagine, d_oss.note, d_oss.ora_fine, d_oss.ora_inizio, s.nome AS strumento, o.nome AS oculare, f.nome AS filtro
                            FROM datiosservazione AS d_oss
                            JOIN strumento AS s ON s.id=d_oss.id_strumento
                            LEFT JOIN oculare AS o ON (d_oss.id_oculare IS NOT NULL AND d_oss.id_oculare=o.id)
                            LEFT JOIN filtro_altro AS f ON (d_oss.id_filtro IS NOT NULL AND d_oss.id_filtro=f.id)
                            WHERE d_oss.id_oggettoceleste = :idOggetto AND d_oss.stato = :stato ORDER BY d_oss.ora_fine DESC ");

    $stmt->bindValue(":idOggetto", $idOggetto, PDO::PARAM_INT);
    $stmt->bindValue(":stato", "conclusa", PDO::PARAM_STR);
    # Salvo in una variabile se la query può non andare a buon fine ma può non andare a buon fine?
    $result = $stmt->execute();
    $row = $stmt->fetch();
    $rating = $row['rating'];
    $descrizione = $row['descrizione'];
    $immagine = $row['immagine'];
    $note = $row['note'];
    $ora_fine = $row['ora_fine'];
    $ora_inizio = $row['ora_inizio'];
    $strumento = $row['strumento'];
    $oculare = $row['oculare'];
    $filtro = $row['filtro'];
    ?>
    <html>
    <head>
        <title>Vista osservazioni sull'oggetto</title>
    </head>
    <body>
    <center>
        <h1>Osservazioni concluse sull'oggetto selezionato</h1><br><br>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Ora fine</th>
                <th>Ora inizio</th>
                <th>Rating</th>
                <th>Immagine</th>
                <th>Descrizione</th>
                <th>Note</th>
                <th>Strumento</th>
                <th>Oculare</th>
                <th>Filtro</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <?php
                echo "<td><a href=\"vistaOsservazioneOggetto.php?id=". $row['id_osservazioni'] ."\">". $row['id_osservazioni'] ."</td>";
                echo "<td>". $ora_fine ."</td>";
                echo "<td>". $ora_inizio ."</td>";
                echo "<td>". $rating ."</td>";
                echo "<td>". $immagine ."</td>";
                echo "<td>". $descrizione ."</td>";
                echo "<td>". $note ."</td>";
                echo "<td>". $strumento ."</td>";
                echo "<td>". $oculare ."</td>";
                echo "<td>". $filtro ."</td>";
                ?>
            </tr>
            </tbody>
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
