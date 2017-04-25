<?php
session_start();
include("config.php");
if (isset($_SESSION["autenticato"]) && isset($_SESSION["tipo"])) {
    # if ($_SESSION["tipo"] == "amministratore") {
        # if (!isset($_POST["invio"])) {
        ?>
        <html>
        <head>
          <title>Vista oggetti celesti</title>
         </head>
         <body>
           <center>
             <h1>Oggetti celesti osservati</h1><br><br>
             <table>
               <thead>
                 <tr>
                   <th>Nome</th>
                   <th>Tipo</th>
                 </tr>
               </thead>
                <?php
                $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');
                $stmt = $conn->prepare("SELECT id, nome, tipo_oggetto FROM oggettoceleste");
                # Salvo in una variabile se la query può non andare a buon fine ma può non andare a buon fine?
                $result = $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $row_count = $stmt->rowCount();
                if ($row_count > 0) {
                    echo "<tbody>";
                    foreach ($rows as $row) {
                        echo "<tr>";
                        # Devo passare l'ID per pescarlo come GET nell'altra pagina, può dare problemi?
                        echo "<td><a href=\"vistaOsservazioniCompleteOggetto.php?id=". $row['id'] ."\">". $row['nome'] ."</td>";
                        echo "<td>". $row['tipo_oggetto'] ."</td>";
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
