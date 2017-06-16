<?php
//session_start();
include("config.php");
if (isset($_SESSION["autenticato"]) && isset($_SESSION["tipo"])) {
    $idUser = $_GET['id'];
    # if ($_SESSION["tipo"] == "amministratore")|| $_SESSION["tipo"] == "regolare") {
        # if (!isset($_POST["invio"])) {
        ?>

             <h1>Osservazioni programmate</h1><br><br>
             <table>
               <thead>
                 <tr>
                   <th>Descrizione</th>
                   <th>Note</th>
                   <th>Ora inizio</th>
                   <th>Ora fine</th>
                     <th>Oggetto celeste</th>
                     <th>Strumento</th>
                     <th>Oculare</th>
                     <th>Filtro</th>
                     <th>Categoria</th>
                     <th>Sito</th>
                     <th>Osservatore</th>
                 </tr>
               </thead>
                <?php
                $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');

                $stmt = $conn->prepare("SELECT d_oss.descrizione, d_oss.note, d_oss.ora_fine, d_oss.ora_inizio, ogg.nome AS oggetto, s.nome AS strumento, o.nome AS oculare, f.nome AS filtro, oss.categoria AS categoria, ar.nome AS area, an.nome AS nome, an.cognome AS cognome
                                        FROM datiosservazione AS d_oss
                                        JOIN oggettoceleste AS ogg ON ogg.id=d_oss.id_oggettoceleste
                                        JOIN strumento AS s ON s.id=d_oss.id_strumento
                                        LEFT JOIN oculare AS o ON (d_oss.id_oculare IS NOT NULL AND d_oss.id_oculare=o.id)
                                        LEFT JOIN filtro_altro AS f ON (d_oss.id_filtro IS NOT NULL AND d_oss.id_filtro=f.id)
                                        LEFT JOIN
                                        (
                                             osservazioni AS oss
                                             JOIN areageografica AS ar ON ar.id=oss.id_area_geografica
                                             JOIN anagrafica AS an ON an.numero_socio=oss.id_anagrafica AND an.numero_socio=:idUser
                                        )ON oss.id=d_oss.id_osservazioni
                                        WHERE d_oss.stato = :stato
                                        ");


                # Salvo in una variabile se la query può non andare a buon fine ma può non andare a buon fine?
                $stmt->bindValue(":idUser", $idUser, PDO::PARAM_INT);
                $stmt->bindValue(":stato", "programmata", PDO::PARAM_STR);
                $result = $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $row_count = $stmt->rowCount();

                if ($row_count > 0) {
                    echo "<tbody>";
                    foreach ($rows as $row) {
                        echo "<tr>";
                        # Devo passare l'ID per pescarlo come GET nell'altra pagina, può dare problemi?
                        echo "<td>". $row['descrizione'] ."</td>";
                        echo "<td>". $row['note'] ."</td>";
                        echo "<td>". $row['ora_inizio'] ."</td>";
                        echo "<td>". $row['ora_fine'] ."</td>";
                        echo "<td>". $row['oggetto'] ."</td>";
                        echo "<td>". $row['strumento'] ."</td>";
                        echo "<td>". $row['oculare'] ."</td>";
                        echo "<td>". $row['filtro'] ."</td>";
                        echo "<td>". $row['categoria'] ."</td>";
                        echo "<td>". $row['area'] ."</td>";
                        echo "<td>". $row['nome'].' '. $row['cognome'] ."</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                }
                ?>
        <?php
} else {
    echo "<script language='javascript'>";
    echo "alert('Non sei autorizzato ');";
    echo "</script>";
    header("Refresh:0; index.php", true, 303);
}
?>
