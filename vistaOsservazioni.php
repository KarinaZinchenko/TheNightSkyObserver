<?php
session_start();
include("config.php");
if (isset($_SESSION["autenticato"]) && isset($_SESSION["tipo"])) {
    # if ($_SESSION["tipo"] == "amministratore") {
        # if (!isset($_POST["invio"])) {
        ?>
        <html>
        <head>
          <title>Vista osservazioni</title>
         </head>
         <body>
           <center>
             <h1>Osservazioni compiute</h1><br><br>
             <table>
               <thead>
                 <tr>
                   <th>Oggetto</th>
                   <th>Stato</th>
                 </tr>
               </thead>
                <?php
                $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');
                #$stmt = $conn->prepare("SELECT d_oss.stato, ogg.nome, d_oss.id_osservazioni FROM datiosservazione AS d_oss JOIN oggettoceleste AS ogg ON ogg.id = d_oss.id_oggettoceleste");
                $stmt = $conn->prepare("SELECT DISTINCT stato, id_osservazioni FROM datiosservazione");
                # Salvo in una variabile se la query può non andare a buon fine ma può non andare a buon fine?
                $result = $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $row_count = $stmt->rowCount();
                if ($row_count > 0) {
                    echo "<tbody>";
                    foreach ($rows as $row) {
                        # $stmt = $conn->prepare("SELECT * FROM oggettoceleste WHERE ID = :idOggettoCeleste");
                        # $stmt->bindValue(":idOggettoCeleste", $row['id_oggettoceleste'], PDO::PARAM_INT);
                        # $result = $stmt->execute();
                        # $oggettoceleste = $stmt->fetch();
                        # $nomeOggettoceleste = $row['nome'];
                        echo "<tr>";
                        # Devo passare l'ID per pescarlo come GET nell'altra pagina, può dare problemi?
                        echo "<td><a href=\"vistaOsservazione.php?id=". $row['id_osservazioni'] ."\">Osservazione numero: ". $row['id_osservazioni'] ."</td>";
                        if ($row['stato'] == 'conclusa') {
                            $stato = "Conclusa";
                        } else {
                            $stato = "Pianificata";
                        }
                        echo "<td>". $stato ."</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                }
                ?>
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
