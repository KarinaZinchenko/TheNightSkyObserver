<head>
    <title>Vista soci insolventi</title>
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
    if ($_SESSION["tipo"] == "amministratore") {
    # if (!isset($_POST["invio"])) {
    ?>
        <div class="featured-heading">
            <h1>Soci insolventi dell'osservatorio</h1><br>            
                <?php
                $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');
                $stmt = $conn->prepare("SELECT * FROM anagrafica WHERE scadenza_tessera < CURRENT_DATE ");
                # Salvo in una variabile se la query può non andare a buon fine ma può non andare a buon fine?
                $result = $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $row_count = $stmt->rowCount();
                if ($row_count > 0) {
                ?>
                  <table class="table">
                  <thead class="thead-default">
                      <tr>
                          <th>Nome</th>
                          <th>Cognome</th>
                          <th>Data di nascita</th>
                          <th>Numero socio</th>                        
                          <th>Data di scadenza tessera</th>
                      </tr>
                  </thead>
                  <?php
                    echo "<tbody>";
                    foreach ($rows as $row) {
                        echo "<tr>";
                        # Devo passare l'ID per pescarlo come GET nell'altra pagina, può dare problemi?
                        echo "<td>". $row['nome'] ."</td>";
                        echo "<td>". $row['cognome'] ."</td>";
                        echo "<td>". $row['data_nascita'] ."</td>";
                        echo "<td>". $row['numero_socio'] ."</td>";                       
                        echo "<td>". $row['scadenza_tessera'] ."</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                }
                else{ ?>                  
                    <h3> Fiuh, non ci sono soci insolventi. </h3> <br>
                    <h4> Sono tutti in regola con il pagamento della quota annuale.</h4> <br>                   
                                   
                    <?php
                }
                ?>
            
        </div>
        <?php
    }else
    {
         ?>
         <script>
             swal({title:"Oops...!",text:"Non sei autorizzato.",type:"error",showConfirmButton:false});
         </script>
         <?php
         header("Refresh:2; profiloUtente.php", true, 303);
    }
}
else
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