<head>
    <title>Dettagli dell'osservazione selezionata</title>
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
    <div class="featured-heading">
        <h1>Dettagli osservazione selezionata</h1><br>
        <table class="table">
            <thead class="thead-default">
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
    </table>
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
