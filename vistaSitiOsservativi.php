<?php
session_start();
include("config.php");
if (isset($_SESSION["autenticato"]) && isset($_SESSION["tipo"])) {
    # if ($_SESSION["tipo"] == "amministratore")|| $_SESSION["tipo"] == "regolare") {
        # if (!isset($_POST["invio"])) {
        ?>
        <html>
        <head>
          <title>Vista siti osservativi</title>
         </head>
         <body>
           <center>
             <h1>Luoghi in cui eseguire un'osservazione</h1><br><br>
             <table>
               <thead>
                 <tr>
                   <th>Nome</th>
                   <th>Latitudine</th>
                   <th>Longitudine</th>
                   <th>Altitudine</th>
                   <th>Qualit&agrave; del cielo</th>
                   <th>Note</th>
                 </tr>
               </thead>
                <?php
                $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');

                $stmt = $conn->prepare("SELECT nome, note, altitudine, latitudine, longitudine, qualita_cielo_bortle, qualita_cielo_sqm FROM areageografica ORDER BY qualita_cielo_bortle");

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
                        echo "<td>". $row['latitudine'] ."</td>";
                        echo "<td>". $row['longitudine'] ."</td>";
                        echo "<td>". $row['altitudine'] ."</td>";
                        if ( $row['qualita_cielo_sqm']!=null) {
                            echo "<td>". $row['qualita_cielo_sqm']. " SQM"."</td>";
                        }
                        else {
                            echo "<td>". $row['qualita_cielo_bortle']." Bortle"."</td>";
                        }
                        echo "<td>". $row['note'] ."</td>";
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
