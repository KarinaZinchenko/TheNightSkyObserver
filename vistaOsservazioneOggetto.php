<?php
session_start();
include("config.php");
if (isset($_SESSION["autenticato"]) && isset($_SESSION["tipo"])) {
    # if ($_SESSION["tipo"] == "amministratore") {
    # if (!isset($_POST["invio"])) {
    $idOsservazione = $_GET['id'];
    $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');

    $stmt = $conn->prepare("SELECT oss.categoria, oss.trasparenza, oss.seeing_antoniani, oss.seeing_pickering, ar.nome AS area, an.nome AS nome, an.cognome AS cognome
                            FROM osservazioni AS oss
                            JOIN areageografica AS ar ON ar.id=oss.id_area_geografica
                            JOIN anagrafica AS an ON an.numero_socio=oss.id_anagrafica
                            WHERE oss.id = :idOsservazione");

    $stmt->bindValue(":idOsservazione", $idOsservazione, PDO::PARAM_INT);
    # Salvo in una variabile se la query può non andare a buon fine ma può non andare a buon fine?
    $result = $stmt->execute();
    $row = $stmt->fetch();
    $categoria = $row['categoria'];
    $trasparenza = $row['trasparenza'];
    $seeing_antoniani = $row['seeing_antoniani'];
    $seeing_pickering= $row['seeing_pickering'];
    $area = $row['area'];
    $nome = $row['nome'];
    $cognome = $row['cognome'];
    ?>
    <html>
    <head>
        <title>Vista osservazione</title>
    </head>
    <body>
    <center>
        <h1>Osservazione conclusa</h1><br><br>
        <table>
            <thead>
            <tr>
                <th>Categoria</th>
                <th>Trasparenza</th>
                <th>Seeing Antoniani</th>
                <th>Seeing Pickering</th>
                <th>Luogo</th>
                <th>Osservatore</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <?php
                echo "<td>". $categoria ."</td>";
                echo "<td>". $trasparenza ."</td>";
                echo "<td>". $seeing_antoniani ."</td>";
                echo "<td>". $seeing_pickering ."</td>";
                echo "<td>". $area ."</td>";
                echo "<td>". $nome . ' '. $cognome ."</td>";
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
