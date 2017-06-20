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
        <h1>Siti osservativi</h1>
          
            <div id ="contact-info-ricerca" class="contact-info"> 
              <div id="panel-body-ricerca" class="panel-body">
                 <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">  
                  <div class="col-xs-12 col-sm-2 col-md-2 form-group">                    
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3 form-group">
                        <label  id="label-ricerca">Valore da cercare</label>
                        <input style="margin-bottom: 0; margin-right:0; min-height: 34px;" type="text" name="valore_ricerca" placeholder="Cosa vuoi cercare?">
                    </div> 
                  <div class="col-xs-12 col-sm-3 col-md-3 form-group">
                      <label id="label-ricerca">Campo di ricerca</label>
                      <select style="margin-bottom: 0;" class="soflow-color" name="scelta_ricerca">
                          <option value="nome">Nome </option>
                          <option value="latitudine">Latitudine </option>
                          <option value="longitudine">Longitudine</option>
                           <option value="altitudine">Altitudine</option>
                          <option value="qualita_cielo_bortle">Qualità del cielo Bortle</option>
                          <option value="qualita_cielo_sqm">Qualità del cielo SQM</option>
                      </select>
                  </div>                     
                    <div class="col-xs-12 col-sm-2 col-md-2 form-group" style="top:20px;">
                    <input id="contact-submit" class="btn" type="submit" name="invio_ricerca" value="Cerca">
                    </div> 
                    <div class="col-xs-12 col-sm-2 col-md-2 form-group">                    
                    </div>
                </form>                
                </div>
        <br>
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

        if(isset($_POST["invio_ricerca"]))
                {
                   $condizione=$_POST["scelta_ricerca"];
                   $valore=$_POST["valore_ricerca"];
                   $aux=$valore;
                   $valore=strtoupper(substr($valore, 0,1)).substr($aux,1);
                   echo "<h3 style='color:#d3b483;'>Risultati per '".$valore."'</h3><br>";

                $stmt = $conn->prepare("SELECT nome, note, altitudine, latitudine, longitudine, qualita_cielo_bortle, qualita_cielo_sqm FROM areageografica WHERE LOWER(".$condizione.")=LOWER('".$valore."')  ORDER BY qualita_cielo_bortle, qualita_cielo_sqm");
                $ricerca=true;
              }
              else{
            $stmt = $conn->prepare("SELECT nome, note, altitudine, latitudine, longitudine, qualita_cielo_bortle, qualita_cielo_sqm FROM areageografica ORDER BY qualita_cielo_bortle, qualita_cielo_sqm");
               }

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
        <?php
         if($row_count <= 0 && $ricerca)
                      {  
                             echo "<h3 style='color:#d3b483;'>Nessun risultato ottenuto  per '".$valore."'</h3><br>";
                        }
                        ?>
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
