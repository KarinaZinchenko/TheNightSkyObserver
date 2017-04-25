<?php
session_start();
include("config.php");
if (isset($_SESSION["autenticato"]) && isset($_SESSION["tipo"])) {
    # if ($_SESSION["tipo"] == "amministratore")|| $_SESSION["tipo"] == "regolare") {
        # if (!isset($_POST["invio"])) {
        ?>
        <html>
        <head>
          <title>Vista soci</title>
         </head>
         <body>
           <center>
             <h1>Soci dell'osservatorio</h1><br><br>
             <table>
               <thead>
                 <tr>
                   <th>Nome</th>
                   <th>Cognome</th>
                   <th>Numero socio</th>
                 </tr>
               </thead>
                <?php
                $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');
                $stmt = $conn->prepare("SELECT numero_socio, nome, cognome FROM anagrafica");
                # Salvo in una variabile se la query può non andare a buon fine ma può non andare a buon fine?
                $result = $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $row_count = $stmt->rowCount();
                if ($row_count > 0) {
                    echo "<tbody>";
                    foreach ($rows as $row) {
                        echo "<tr>";
                        # Devo passare l'ID per pescarlo come GET nell'altra pagina, può dare problemi?
                        echo "<td>". $row['nome'] ."</td>";
                        echo "<td>". $row['cognome'] ."</td>";
                        echo "<td>". $row['numero_socio'] ."</td>";
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
