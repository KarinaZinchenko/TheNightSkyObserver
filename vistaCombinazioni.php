<?php
session_start();
include("config.php");
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
    <html>
    <head>
      <title>Combinazioni telescopio - oculare</title>
    </head>
    <body>
      <center>
        <h1>Tabella combinazioni</h1><br><br>
        <table>
          <tr>
            <?php
            echo "<th>Telescopio | Oculare</th>";
            foreach ($oculari as $oculare) {
                echo "<td>". $oculare['nome'] ."</td>";
            }
            echo "</tr>";
            foreach ($telescopi as $telescopio) {
                echo "<tr>";
                echo "<td>". $telescopio['nome'] ."</td>";
                foreach ($oculari as $oculare) {
                    $ingrandimentiPossibili = $telescopio['lunghezza_focale'] / $oculare['lunghezza_focale'];
                    $pupillaUscita = $oculare['lunghezza_focale'] / $telescopio['focal_ratio'];
                    $campoReale = $oculare['campo_visione_apparente'] / $ingrandimentiPossibili;
                    echo "<td>";
                    echo "Ingrandimenti possibili: ". round($ingrandimentiPossibili, 2) ."<br>";
                    echo "Pupilla di uscita: ". round($pupillaUscita, 2) ."<br>";
                    echo "Campo reale di visione: ". round($campoReale, 2);
                    echo "</td>";
                }
                echo "</tr>";
            }
            ?>
          </table>
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
