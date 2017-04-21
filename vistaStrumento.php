<?php
session_start();
include("config.php");
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
        $apertura = $row['apertura'];
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
        <html>
        <head>
          <title>Vista strumento</title>
         </head>
         <body>
           <center>
             <h1>Caratteristiche strumento</h1><br><br>
             <table>
               <thead>
                 <tr>
                   <th>Nome</th>
                   <th>Tipo</th>
                   <th>Marca</th>
                   <th>Apertura</th>
                   <th>Campo focale</th>
                   <th>Ingrandimenti</th>
                   <th>Lunghezza focale</th>
                   <th>Montatura</th>
                   <th>Focal ratio</th>
                   <th>Campo cercatore</th>
                   <th>Tipo telescopio</th>
                   <th>Apertura in millimetri</th>
                   <th>Apertura in pollici</th>
                   <th>Risoluzione angolare</th>
                   <th>Stima potere risolutivo</th>
                   <th>Note</th>
                 </tr>
               </thead>
               <tbody>
                 <tr>
                <?php
                /*
                Hm, effettivamente sto usando variabili che non hanno subito modifiche e potrei usare direttamente
                il risultato della query ma magari può servire fare operazioni su di esse (ad esempio: non stampare il
                tipo del telescopio se si tratta di un altro tipo di strumento)
                C'erano anche delle formule da calcolare
                */
                echo "<td>". $nome ."</td>";
                echo "<td>". $tipo ."</td>";
                echo "<td>". $marca ."</td>";
                echo "<td>". $apertura ."</td>";
                echo "<td>". $campoFocale ."</td>";
                echo "<td>". $ingrandimenti ."</td>";
                echo "<td>". $lunghezzaFocale ."</td>";
                echo "<td>". $montatura ."</td>";
                echo "<td>". $focalRatio ."</td>";
                echo "<td>". $campoCercatore ."</td>";
                echo "<td>". $tipoTelescopio ."</td>";
                echo "<td>". $aperturaMM ."</td>";
                echo "<td>". $aperturaPollici ."</td>";
                echo "<td>". $risoluzioneAngolare ."</td>";
                echo "<td>". $stimaPotereRisolutivo ."</td>";
                echo "<td>". $note ."</td>";
                ?>
                </tr>
              </tbody>
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
