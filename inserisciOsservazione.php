 <html>
         <head>
          <title>Inserimento nuova osservazione</title>
           
         </head>
         <body>
<?php
session_start();
include("config.php");

if(isset($_SESSION["autenticato"])&& isset($_SESSION["tipo"]))
{
	if($_SESSION["tipo"]=="regolare" || $_SESSION["tipo"]=="amministratore")
	{ 
    if(isset($_POST["invio_numero_oggetti_osservati"]))
    {
         $numero_osservazione=$_POST["numero_osservazioni"];
       ?>
         <center> 
          <h1> Inserisci i dati dell'osservazione: </h1>  <br><br>
         <form method="post" action="inserisciOsservazioneEffettivo.php">
        
         categoria: <input type="text" name="categoria"><br><br>
        Trasparenza: <input type="number" name="trasparenza" step=any><br><br>
        Seeing (scala antoniani): <input type="number" name="seeing_antoniani" step=any><br><br>
        Seeing (scala pickering): <input type="number" name="seeing_pickering" step=any><br><br>
        Area osservazione: &nbsp; <select name="area_osservazione">
        <?php 
           $sql="SELECT ID,nome FROM areageografica;";
            $risposta=mysqli_query($conn,$sql)or die("Errore nella query: " . $sql . "\n" . mysqli_error($conn));
            if(mysqli_num_rows($risposta)!=0)
                 {
                   while ($tupla = mysqli_fetch_array($risposta))
                    {
                              $id=$tupla["ID"];
                              $nome=$tupla["nome"];
                              ?>
                              <option value="<?php echo "$id";?>"><?php echo "$id - $nome ";?> </option>
                              <?php
                    }
                 }

        ?>

       </select> <br><br>
        <?php
        for($i=1;$i<=$numero_osservazione;$i++)
          { echo "<hr>";
        ?>
         stato: &nbsp; <select name="stato<?php echo $i; ?>" >
        <option value="pianificata" selected="selected"> pianificata </option>
        <option value="conclusa"> conclusa </option>
         </select><br><br>
     <?php //fino a qui relativo a tabella osservazione  ?>

        rating: <input type="number" name="rating<?php echo $i ?>" step=any><br><br>
        descrizione: <input type="text" name="descrizione<?php echo $i ?>"><br><br>
        immagine: <input type="text" name="immagine<?php echo $i ?>"><br><br>
         note: <input type="text" name="note<?php echo $i ?>"><br><br>
        ora  inizio: <input type="text" name="ora_inizio<?php echo $i ?>"><br><br>
        ora fine: <input type="text" name="ora_fine<?php echo $i ?>"><br><br>
       Oggetto celeste osservato: &nbsp; <select name="oggetto_celeste<?php echo $i ?>">
       <?php 
           $sql="SELECT ID,nome FROM oggettoceleste;";
            $risposta=mysqli_query($conn,$sql)or die("Errore nella query: " . $sql . "\n" . mysqli_error($conn));
            if(mysqli_num_rows($risposta)!=0)
                 {
                 	 while ($tupla = mysqli_fetch_array($risposta))
    	              {
                              $id=$tupla["ID"];
                              $nome=$tupla["nome"];
                              ?>
                              <option value="<?php echo "$id";?>"><?php echo "$id - $nome ";?> </option>
                              <?php
    	              }
                 }

        ?>

       </select>  <br><br>

      Oculare Usato: &nbsp; <select name="oculare<?php echo $i ?>">
       <?php 
           $sql="SELECT ID,nome FROM oculare;";
            $risposta=mysqli_query($conn,$sql)or die("Errore nella query: " . $sql . "\n" . mysqli_error($conn));
            if(mysqli_num_rows($risposta)!=0)
                 {
                 	 while ($tupla = mysqli_fetch_array($risposta))
    	              {
                              $id=$tupla["ID"];
                              $nome=$tupla["nome"];
                              ?>
                              <option value="<?php echo "$id";?>"><?php echo "$id - $nome ";?> </option>
                              <?php
    	              }
                 }

        ?>

       </select> <br><br>

         Filtro usato: &nbsp; <select name="filtro<?php echo $i ?>">
       <?php 
           $sql="SELECT ID,nome FROM filtro_altro;";
            $risposta=mysqli_query($conn,$sql)or die("Errore nella query: " . $sql . "\n" . mysqli_error($conn));
            if(mysqli_num_rows($risposta)!=0)
                 {
                 	 while ($tupla = mysqli_fetch_array($risposta))
    	              {
                              $id=$tupla["ID"];
                              $nome=$tupla["nome"];
                              ?>
                              <option value="<?php echo "$id";?>"><?php echo "$id - $nome ";?> </option>
                              <?php
    	              }
                 }

        ?>

       </select> <br><br>

        Strumento Usato: &nbsp; <select name="strumento<?php echo $i ?>">
       <?php 
           $sql="SELECT ID,nome FROM strumento;";
            $risposta=mysqli_query($conn,$sql)or die("Errore nella query: " . $sql . "\n" . mysqli_error($conn));
            if(mysqli_num_rows($risposta)!=0)
                 {
                 	 while ($tupla = mysqli_fetch_array($risposta))
    	              {
                              $id=$tupla["ID"];
                              $nome=$tupla["nome"];
                              ?>
                              <option value="<?php echo "$id";?>"><?php echo "$id - $nome ";?> </option>
                              <?php
    	              }
                 }

        ?>

       </select> <br><br>
     
        <?php 
         }// chiudo il for
         $_SESSION["numero_osservazione"]=$numero_osservazione;
      ?>
         <input type="hidden" name="id_utente" value="<?php echo $_SESSION["numero_socio"];  ?>" />
        
	     <input type="submit" name="invio">
         </form>
         
         </center>
         </body>
         </html>

       <?php
     }
     else
     {
         ?> <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" >
            inserire il numero di osservazioni che si intende fare: &nbsp; <input type="number" name="numero_osservazioni"/>&nbsp;
            <input type="submit" name="invio_numero_oggetti_osservati" value="scegli" />
            </form>
            <?php
     } //fine controllo se devo inserire numero di oss!


     }
      else
    {
      echo "<script language='javascript'>"; 
         echo "alert('Non sei autorizzato ');";
        echo " </script>";
        header( "Refresh:0; url=prova-sessioni.php", true, 303);
    }
 }
 else
{
    echo "<script language='javascript'>"; 
         echo "alert('Non sei autorizzato ');";
        echo " </script>";
        header( "Refresh:0; index.php", true, 303);
}
?>