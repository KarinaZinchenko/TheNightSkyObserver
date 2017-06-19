<head>
    <title>Combinazioni telescopio - oculare</title>
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
    $telescopi = array();
    $oculari = array();
    $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');
    $stmt = $conn->prepare("SELECT * FROM strumento WHERE tipo = \"Telescopio\" AND disponibilita = 1");
    $result = $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
        $telescopi[] = $row;
    }
    $stmt = $conn->prepare("SELECT * FROM oculare WHERE disponibilita = 1");
    $result = $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
        $oculari[] = $row;
    }
    ?>
    <div class="featured-heading">
        <h1>Tabella combinazioni</h1><br>
        <table class="table">
            <thead class="thead-default">
            <tr>
            <?php
            echo "<th style='color: #c47780; vertical-align: middle'>TELESCOPIO | OCULARE</th>";
            foreach ($oculari as $oculare) {
                echo "<th id='combinazioni'>". $oculare['nome'] ."</th>";
            }
            echo "</tr>";
            echo "</thead>";
            foreach ($telescopi as $telescopio) {
                echo "<tr>";
                echo "<th id='combinazioni'>". $telescopio['nome'] ."</th>";
                foreach ($oculari as $oculare) {
                    $ingrandimentiPossibili = $telescopio['lunghezza_focale'] / $oculare['lunghezza_focale'];
                    $pupillaUscita = $oculare['lunghezza_focale'] / $telescopio['focal_ratio'];
                    $campoReale = $oculare['campo_visione_apparente'] / $ingrandimentiPossibili;
                    echo "<td>";
                    echo "Ingrandimenti possibili: <label id='comblabel' style='font-style: italic'>". round($ingrandimentiPossibili, 2) ."</label><br>";
                    echo "Pupilla di uscita: <label id='comblabel' style='font-style: italic'>". round($pupillaUscita, 2) ."</label><br>";
                    echo "Campo reale di visione: <label id='comblabel' style='font-style: italic'>". round($campoReale, 2)."</label>";
                    echo "</td>";
                }
                echo "</tr>";
            }
            ?>
        </table>
    </div>
<?php
}  else
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
