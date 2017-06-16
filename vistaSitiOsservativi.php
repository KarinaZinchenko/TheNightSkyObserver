<head>
    <title>Vista siti osservativi</title>
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
    # if ($_SESSION["tipo"] == "amministratore")|| $_SESSION["tipo"] == "regolare") {
        # if (!isset($_POST["invio"])) {
?>
    <div class="featured-heading">
        <h1>Siti osservativi</h1><br>
        <table class="table">
            <thead class="thead-default">
                <tr>
                    <th>Nome</th>
                    <th>Latitudine</th>
                    <th>Longitudine</th>
                    <th>Altitudine</th>
                    <th>Qualit&agrave; del cielo: Bortle</th>
                    <th>Qualit&agrave; del cielo: SQM</th>
                    <th>Note</th>
                </tr>
            </thead>
            <?php
            $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');

            $stmt = $conn->prepare("SELECT nome, note, altitudine, latitudine, longitudine, qualita_cielo_bortle, qualita_cielo_sqm FROM areageografica ORDER BY qualita_cielo_bortle, qualita_cielo_sqm");

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
                  	echo "<td style='text-align: center;'>". $row['qualita_cielo_bortle']."</td>";
                    echo "<td style='text-align: center;'>". $row['qualita_cielo_sqm']."</td>";
                    echo "<td>". $row['note'] ."</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
            }
            ?>
        </table>
    </div>
        <?php
} else {
    ?>
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