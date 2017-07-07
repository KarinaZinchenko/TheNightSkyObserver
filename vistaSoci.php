<head>
    <title>Vista soci</title>
    <script src="/js/jquery-1.9.1.js"></script>
    <script>
        function printPage() {
            window.print();
        }

        function toggleTab(elem) {
            var id = $(elem).attr("id");
            var number = id.split("_")[1];
            var selected = "tab_" + number;
            $('#' + selected).toggle();
        }
    </script>
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
            <h1>Soci dell'osservatorio</h1><br>
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
                          <option value="cognome">Cognome </option>
                          <option value="numero_socio">Numero Socio </option>
                          <?php
                              if ($_SESSION["tipo"] == "amministratore"){
                                ?>
                                <option value="tipo">Tipo Socio </option>
                                <?php
                              }
                          ?>
                      </select>
                	</div>                     
                    <div class="col-xs-12 col-sm-2 col-md-2 form-group" style="top:20px;">
                		<input id="contact-submit" class="btn" type="submit" name="invio_ricerca" value="Cerca">
                    </div> 
                    <div class="col-xs-12 col-sm-2 col-md-2 form-group">                    
                    </div>
                </form>                
                </div>
			</div>
           <br>
           <br>

                <?php
                $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');
                if(isset($_POST["invio_ricerca"]))
                {
                   $condizione=$_POST["scelta_ricerca"];
                   $valore=$_POST["valore_ricerca"];
                   $aux=$valore;
                   $valore=strtoupper(substr($valore, 0,1)).substr($aux,1);
                   echo "<h3 style='color:#d3b483;'>Risultati per '".$valore."'</h3><br>";
                   $ricerca=true;
                $stmt = $conn->prepare("SELECT * FROM anagrafica WHERE LOWER(".$condizione.")=LOWER('".$valore."');");
                }
                else
                {
                $stmt = $conn->prepare("SELECT * FROM anagrafica");
                $ricerca=false;
                }

                # Salvo in una variabile se la query può non andare a buon fine ma può non andare a buon fine?
                $result = $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $row_count = $stmt->rowCount();
                if ($row_count > 0) {
                    $counter = 1;
                    foreach ($rows as $row) {
                        if ($row['tipo'] != "amministratore"){
                        	if(strtotime($row['scadenza_tessera']) < strtotime(date("Y-m-d"))) {
                                $stmt = $conn->prepare("UPDATE anagrafica SET tipo='insolvente' WHERE numero_socio=".$row['numero_socio'].";");
                                $result = $stmt->execute();
                                $row['tipo']="insolvente";
                            }
                            else{
                            	$stmt = $conn->prepare("UPDATE anagrafica SET tipo='regolare' WHERE numero_socio=".$row['numero_socio'].";");
                              	$result = $stmt->execute();
                              	$row['tipo']="regolare";
                            }                            
                        }

                        echo "<div id='p-open' class='col-lg-12'>";
                        # Devo passare l'ID per pescarlo come GET nell'altra pagina, può dare problemi?
                        echo "<div class='row' style=' padding-left: 30px; margin-left: 0'>";
                        echo "<div class='col-lg-2'></div>";
                        echo "<div class='col-lg-3' style=' padding-bottom: 10px;'><a class='btn btn-default' id=\"icon_$counter\" onclick=\"toggleTab(this)\" style='margin-bottom: 2px; margin-left: 6px; margin-right: 6px;'><em class='fa fa-eye'></em></a><label id=\"label-open\">Nome:</label> ". $row['nome'] ."</div>";
                        echo "<div class='col-lg-3' id='div-col'><label id=\"label-open\"> Cognome:</label> ". $row['cognome']. "</div>";
                        if ($_SESSION["tipo"] == "amministratore") {
                            echo "<div class='col-lg-3' id='div-col'><label id=\"label-open\"> Tipo:</label> " . $row['tipo'] . "</div>";
                        }
                        echo "</div>";
                        echo "<div id='div-open' style='padding-left: 240px;'>";
                        echo "<div style=\"display: none\" id=\"tab_$counter\">";
                        echo "<p><label id=\"label-open\"> Numero socio:</label> ". $row['numero_socio']."</p>";
                        echo "<p><label id=\"label-open\"> Data di nascita:</label> ". $row['data_nascita']."</p>";
                        if ($_SESSION["tipo"] == "amministratore"){
                            echo "<p><label id=\"label-open\"> Data di scadenza tessera:</label> ". $row['scadenza_tessera']."</p>";
                        }
                        echo "<br>";
                        echo "</div>";

                        echo "</div>";
                        echo "</div>";
                        $counter = $counter + 1;

                    }
                    

                }

                ?>

            <?php
            if($row_count <= 0 && $ricerca)
                      {  
                             echo "<h3 style='color:#d3b483;'>Nessun risultato ottenuto  per '".$valore."'</h3><br>";
                        }
                        ?>
        </div>
        <?php
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
