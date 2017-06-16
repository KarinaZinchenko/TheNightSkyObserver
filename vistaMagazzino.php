<head>
    <title>Vista strumenti magazzino</title>
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
        ?>
        <div class="featured-heading">
            <h1>Strumenti disponibili in magazzino</h1>
            <br>
            <table class="table">
                <thead class="thead-default">
                <tr>
                   <th>Nome</th>
                   <th>Tipo</th>
                   <th>Marca</th>
                 </tr>
               </thead>
                <?php
                $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');
                $stmt = $conn->prepare("SELECT id, nome, tipo, marca FROM strumento WHERE disponibilita = 1");
                # Salvo in una variabile se la query può non andare a buon fine ma può non andare a buon fine?
                $result = $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $row_count = $stmt->rowCount();
                if ($row_count > 0) {
                    echo "<tbody>";
                    foreach ($rows as $row) {
                        echo "<tr>";
                        # Devo passare l'ID per pescarlo come GET nell'altra pagina, può dare problemi?
                        echo "<td><a href=\"vistaStrumento.php?id=". $row['id'] ."\">". $row['nome'] ."</td>";
                        echo "<td>". $row['tipo'] ."</td>";
                        echo "<td>". $row['marca'] ."</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    echo "</div>";
                }
} else
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