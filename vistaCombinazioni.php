<head>
    <title>Combinazioni telescopio - oculare</title>
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
# if ($_SESSION["tipo"] == "amministratore") {
# if (!isset($_POST["invio"])) {
$telescopi = array();
$oculari = array();



?>
<div class="featured-heading">
    <h1>combinazioni tra telescopi ed oculari</h1>
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
                        <option value="nome_telescopio">Nome telescopio </option>
                        <option value="nome_oculare">Nome Oculare </option>

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
    <?php
    $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');
    if(isset($_POST["invio_ricerca"]))
    { if($_POST["scelta_ricerca"]=="nome_telescopio")
    {
        $condizione=$_POST["scelta_ricerca"];
        $valore=$_POST["valore_ricerca"];
        $aux=$valore;
        $valore=strtoupper(substr($valore, 0,1)).substr($aux,1);
        echo "<h3 style='color:#d3b483;'>Risultati per '".$valore."'</h3><br>";
        $ricerca=true;

        $stmt = $conn->prepare("SELECT * FROM strumento WHERE tipo = \"Telescopio\" AND disponibilita = 1 AND nome='".$valore."';");
        $result = $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            $telescopi[] = $row;
        }

        $stmt = $conn->prepare("SELECT * FROM oculare WHERE disponibilita = 1");
        $result = $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            $oculari[] = $row;
        }

    }

        if($_POST["scelta_ricerca"]=="nome_oculare")
        {
            $condizione=$_POST["scelta_ricerca"];
            $valore=$_POST["valore_ricerca"];
            $aux=$valore;
            $valore=strtoupper(substr($valore, 0,1)).substr($aux,1);
            echo "<h3 style='color:#d3b483;'>Risultati per '".$valore."'</h3><br>";
            $ricerca=true;
            $stmt = $conn->prepare("SELECT * FROM oculare WHERE disponibilita = 1 AND nome='".$valore."';");
            $result = $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
                $oculari[] = $row;
            }

            $stmt = $conn->prepare("SELECT * FROM strumento WHERE tipo = \"Telescopio\" AND disponibilita = 1");
            $result = $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
                $telescopi[] = $row;
            }

        }

        $ricerca=true;
    }
    else
    {
        $stmt = $conn->prepare("SELECT * FROM strumento WHERE tipo = \"Telescopio\" AND disponibilita = 1");
        $result = $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            $telescopi[] = $row;
        }

        $stmt = $conn->prepare("SELECT * FROM oculare WHERE disponibilita = 1");
        $result = $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            $oculari[] = $row;
        }
        $ricerca=false;
    }
    ?>

    <?php

    echo "<div class='row'>";
    echo "<div class='col-lg-8' style=' padding-bottom: 10px;'><label id=\"label-open\"> Telescopio</label> </div>";
    echo "<div class='col-lg-4' style='padding-right: 120px !important; ' id='div-col'><label id=\"label-open\">Oculare</label></div>";
    echo "</div>";
    $counter = 1;
    foreach ($telescopi as $telescopio) {

        foreach ($oculari as $oculare) {

            $ingrandimentiPossibili = $telescopio['lunghezza_focale'] / $oculare['lunghezza_focale'];
            $pupillaUscita = $oculare['lunghezza_focale'] / $telescopio['focal_ratio'];
            $campoReale = $oculare['campo_visione_apparente'] / $ingrandimentiPossibili;
            /*
             * echo "<th id='combinazioni'>". $oculare['nome'] ."</th>";
                echo "<th id='combinazioni'>". $telescopio['nome'] ."</th>";
             * echo "<td>";

            echo "Ingrandimenti possibili: <label id='comblabel' style='font-style: italic'>". round($ingrandimentiPossibili, 2) ."</label><br>";
            echo "Pupilla di uscita: <label id='comblabel' style='font-style: italic'>". round($pupillaUscita, 2) ."</label><br>";
            echo "Campo reale di visione: <label id='comblabel' style='font-style: italic'>". round($campoReale, 2)."</label>";
            echo "</td>";*/
            echo "<div id='p-open' class='col-lg-12'>";
            # Devo passare l'ID per pescarlo come GET nell'altra pagina, può dare problemi?
            echo "<div class='row' style=' padding-left: 30px; margin-left: 0'>";
            //echo "<div class='col-lg-2'></div>";
            echo "<div class='col-lg-8' style=' padding-bottom: 10px;'><a class='btn btn-default' id=\"icon_$counter\" onclick=\"toggleTab(this)\" style='margin-bottom: 2px; margin-left: 6px; margin-right: 6px;'><em class='fa fa-eye'></em></a>". $telescopio['nome'] ."</div>";
            echo "<div class='col-lg-4' id='div-col'>". $oculare['nome']. "</div>";
            echo "</div>";
            //echo "</div>";
            echo "<div id='div-open' style='padding-left: 110px;'>";
            echo "<div style=\"display: none\" id=\"tab_$counter\">";
            echo "<p><label id=\"label-open\"> Ingrandimenti possibili:</label>". round($ingrandimentiPossibili, 2) ."</p>";
            echo "<p><label id=\"label-open\"> Pupilla di uscita:</label>". round($pupillaUscita, 2) ."</p>";
            echo "<p><label id=\"label-open\"> Campo reale di visione:</label>". round($campoReale, 2)."</p>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            $counter = $counter + 1;
        }
    }
    if((empty($oculari)|| empty($telescopi)) && $ricerca)
    {
        echo "<h3 style='color:#d3b483;'>Nessun risultato ottenuto  per '".$valore."'</h3><br>";
    }
        ?>
</div>
<?php

}  else
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
