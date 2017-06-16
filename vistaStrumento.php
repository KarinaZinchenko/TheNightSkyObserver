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
            <table class="table" >
                <tbody>
                 <tr>
                   <th id="verticaltable">Nome</th>
                     <?php echo "<td id='verticaltable'>". $nome ."</td>"; ?>
                 </tr>
                 <tr>
                   <th id="verticaltable">Tipo</th>
                     <?php echo "<td id='verticaltable'>". $tipo ."</td>";
                      ?>
                 </tr>
                 <tr>
                   <th id="verticaltable">Marca</th>
                     <?php echo "<td id='verticaltable'>". $marca ."</td>";
                      ?>
                 </tr>
                 <tr>
                   <th id="verticaltable">Campo focale</th>
                     <?php echo "<td id='verticaltable'>". $campoFocale ."</td>";
                      ?>
                 </tr>
                 <tr>
                   <th id="verticaltable">Ingrandimenti</th>
                     <?php echo "<td id='verticaltable'>". $ingrandimenti ."</td>";
                      ?>
                 </tr>
                 <tr>
                   <th id="verticaltable">Lunghezza focale</th>
                     <?php echo "<td id='verticaltable'>". $lunghezzaFocale ."</td>";
                      ?>
                 </tr>
                 <tr>
                   <th id="verticaltable">Montatura</th>
                     <?php echo "<td id='verticaltable'>". $montatura ."</td>";
                      ?>
                 </tr>
                 <tr>
                   <th id="verticaltable">Focal ratio</th>
                     <?php echo "<td id='verticaltable'>". $focalRatio ."</td>";
                      ?>
                 </tr>
                 <tr>
                   <th id="verticaltable">Campo cercatore</th>
                     <?php echo "<td id='verticaltable'>". $campoCercatore ."</td>";
                      ?>
                 </tr>
                 <tr>
                   <th id="verticaltable">Tipo telescopio</th>
                     <?php echo "<td id='verticaltable'>". $tipoTelescopio ."</td>";
                      ?>
                 </tr>
                 <tr>
                   <th id="verticaltable">Apertura in millimetri</th>
                     <?php echo "<td id='verticaltable'>". $aperturaMM ."</td>";
                      ?>
                 </tr>
                 <tr>
                   <th id="verticaltable">Apertura in pollici</th>
                     <?php echo "<td id='verticaltable'>". $aperturaPollici ."</td>";
                     ?>
                 </tr>
                 <tr>
                   <th id="verticaltable">Risoluzione angolare</th>
                     <?php  echo "<td id='verticaltable'>". $risoluzioneAngolare ."</td>";
                      ?>
                 </tr>
                 <tr>
                   <th id="verticaltable">Stima potere risolutivo</th>
                     <?php echo "<td id='verticaltable'>". $stimaPotereRisolutivo ."</td>";
                      ?>
                 </tr>
                 <tr>
                   <th id="verticaltable">Note</th>
                     <?php echo "<td id='verticaltable'>". $note ."</td>"; ?>
                 </tr>
               </tbody>

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