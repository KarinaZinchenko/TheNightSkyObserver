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
        $idStrumento = $_GET['id'];
        $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');
        /*
        Così posso vedere tutti gli strumenti (anche i non disponibili) ma fin qui ci arrivo dalla lista degli
        strumenti disponibili a meno di non manomettere l'URL, sarà da gestire anche quel caso?
        */
        $stmt = $conn->prepare("SELECT * FROM strumento WHERE id = :idStrumento");
        $stmt->bindValue(":idStrumento", $idStrumento, PDO::PARAM_INT);
        # Salvo in una variabile se la query può non andare a buon fine ma può non andare a buon fine?
        $result = $stmt->execute();
        $row = $stmt->fetch();
        $nome = $row['nome'];
        $tipo = $row['tipo'];
        $marca = $row['marca'];
        $campoFocale = $row['campo_focale'];
        $ingrandimenti = $row['ingrandimenti'];
        $lunghezzaFocale = $row['lunghezza_focale'];
        $montatura = $row['montatura'];
        $focalRatio = $row['focal_ratio'];
        $campoCercatore = $row['campo_cercatore'];
        $tipoTelescopio = $row['tipo_telescopio'];
        $aperturaMM = $row['apertura_millimetri'];
        $aperturaPollici = $row['apertura_pollici'];
        $risoluzioneAngolare = $row['risoluzione_angolare'];
        $stimaPotereRisolutivo = $row['stima_potere_risolutivo'];
        $note = $row['note'];
        ?>
        <div class="featured-heading">
            <h1>Caratteristiche strumento</h1><br>

            <div id='div-open' style='padding-left: 140px;'>
                <?php echo "<p style='padding-left: 15px;'><label id=\"label-open\">Nome:</label>". $nome ."</p>"; ?>
                <div class='col-lg-6 col-md-6 col-sm-12'>

                     <?php echo "<p><label id=\"label-open\">Tipo:</label>". $tipo ."</p>";
                      ?>

                     <?php echo "<p><label id=\"label-open\">Marca:</label>". $marca ."</p>";
                      ?>

                     <?php echo "<p><label id=\"label-open\">Campo focale:</label>". $campoFocale ."</p>";
                      ?>

                     <?php echo "<p><label id=\"label-open\">Ingrandimenti:</label>". $ingrandimenti ."</p>";
                      ?>

                     <?php echo "<p><label id=\"label-open\">Lunghezza focale:</label>". $lunghezzaFocale ."</p>";
                      ?>

                     <?php echo "<p><label id=\"label-open\">Monatatura:</label>". $montatura ."</p>";
                      ?>

                     <?php echo "<p><label id=\"label-open\">Focal ratio:</label>". $focalRatio ."</p>";
                      ?>
                 </div>
                <div class='col-lg-6 col-md-6 col-sm-12'>
                     <?php echo "<p><label id=\"label-open\">Campo cercatore:</label>". $campoCercatore ."</p>";
                      ?>

                     <?php echo "<p><label id=\"label-open\">Tipo telescopio:</label>". $tipoTelescopio ."</p>";
                      ?>

                     <?php echo "<p><label id=\"label-open\">Apertura in millimetri:</label>". $aperturaMM ."</p>";
                      ?>

                     <?php echo "<p><label id=\"label-open\">Apertura in pollici:</label>". $aperturaPollici ."</p>";
                     ?>

                     <?php  echo "<p><label id=\"label-open\">Risoluzione angolare:</label>". $risoluzioneAngolare ."</p>";
                      ?>

                     <?php echo "<p><label id=\"label-open\">Stima potere risolutivo:</label>". $stimaPotereRisolutivo ."</p>";
                      ?>

                     <?php echo "<p><label id=\"label-open\">Note:</label>". $note ."</p>"; ?>
                </div>
             </div>
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
