<?php
session_start();
include("config.php");
if (isset($_SESSION["autenticato"]) && isset($_SESSION["tipo"])) {
    # if ($_SESSION["tipo"] == "amministratore") {
        # if (!isset($_POST["invio"])) {
        $idOsservazione = $_GET['id'];
        $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');
        /*
        Così posso vedere tutti gli strumenti (anche i non disponibili) ma fin qui ci arrivo dalla lista degli
        strumenti disponibili a meno di non manomettere l'URL, sarà da gestire anche quel caso?
        */
        $stmt = $conn->prepare("SELECT * FROM osservazioni WHERE id = :idOsservazione");
        $stmt->bindValue(":idOsservazione", $idOsservazione, PDO::PARAM_INT);
        # Salvo in una variabile se la query può non andare a buon fine ma può non andare a buon fine?
        $result = $stmt->execute();
        $row = $stmt->fetch();
        $categoria = $row['categoria'];
        $trasparenza = $row['trasparenza'];
        $seeingAntoniani = $row['seeing_antoniani'];
        $seeingPickering = $row['seeing_pickering'];
        $idAreaGeografica = $row['id_area_geografica'];
        $idAnagrafica = $row['id_anagrafica'];
        $stmt = $conn->prepare("SELECT nome FROM areageografica WHERE id = :idAreaGeografica");
        $stmt->bindValue(":idAreaGeografica", $idAreaGeografica, PDO::PARAM_INT);
        $result = $stmt->execute();
        $row = $stmt->fetch();
        $nomeAreaGeografica = $row['nome'];
        $stmt = $conn->prepare("SELECT nome, cognome FROM anagrafica WHERE numero_socio = :idAnagrafica");
        $stmt->bindValue(":idAnagrafica", $idAnagrafica, PDO::PARAM_INT);
        $result = $stmt->execute();
        $row = $stmt->fetch();
        $nomeUtente = $row['nome'];
        $cognomeUtente = $row['cognome'];
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
                   <th>Categoria</th>
                   <th>Trasparenza</th>
                   <th>Seeing (Antoniani)</th>
                   <th>Seeing (pickering)</th>
                   <th>Area geografica</th>
                   <th>Utente</th>
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
                echo "<td>". $categoria ."</td>";
                echo "<td>". $trasparenza ."</td>";
                echo "<td>". $seeingAntoniani ."</td>";
                echo "<td>". $seeingPickering ."</td>";
                echo "<td>". $nomeAreaGeografica ."</td>";
                echo "<td>". $nomeUtente ." ". $cognomeUtente ."</td>";
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
