 <html>
<head> <title>Modifica/Elimina Osservazione</title> </head>
<body>
<?php
session_start();
include("config.php");
if(isset($_SESSION["autenticato"])&& isset($_SESSION["tipo"]))
{
	if($_SESSION["tipo"]=="amministratore" || $_SESSION["tipo"]=="regolare")
	{ 
		if(isset($_POST["invio_ricerca"]))
       {
         echo "<center> <h1> Modifica/Elimina i dati dell'utente: </h1> </center> <br><br>";
            $sql="SELECT * FROM datiosservazione,osservazioni WHERE osservazioni.ID=".$_POST["id_osservazione"]." AND datiosservazione.id_osservazioni=osservazioni.ID;";
            $risposta=mysqli_query($conn,$sql)or die("Errore nella query: " . $sql . "\n" . mysqli_error($conn));
            if(mysqli_num_rows($risposta)!=0)
                 {
                 	$tupla = mysqli_fetch_array($risposta);
                 	//if($tupla['stato']=="regolare")
	       	//{$regolare='selected="selected"';}elseif ($tupla["tipo"]){$amministratore='selected="selected"';}else{$insolvente='selected="selected"';}
                 	?>
                            <center>
                            <form method="post" action="modificaEliminaOsservazioneEffettivo.php">
                             stato: &nbsp; <select name="stato" >
                            <option value="non_completata" selected="selected"> non completata </option>
                            <option value="completata"> completata </option>
                            </select><br><br>
                     categoria: <input type="text" name="categoria" value="<?php echo $tupla["categoria"];?>"><br><br>
                     Trasparenza: <input type="number" name="trasparenza" step=any value="<?php echo $tupla["trasparenza"];?>"><br><br>
                     Seeing (scala antoniani): <input type="number" name="seeing_antoniani" step=any value="<?php echo $tupla["seeing_antoniani"];?>"><br><br>
                     Seeing (scala pickering): <input type="number" name="seeing_pickering" step=any value="<?php echo $tupla["seeing_pickering"];?>"><br><br>

                     rating: <input type="number" name="rating" step=any value="<?php echo $tupla["rating"];?>"><br><br>
                     descrizione: <input type="text" name="descrizione" value="<?php echo $tupla["descrizione"];?>"><br><br>
                     immagine: <input type="text" name="immagine" value="<?php echo $tupla["immagine"];?>"><br><br>
                     note: <input type="text" name="note" value="<?php echo $tupla["note"];?>"><br><br>
                     ora  inizio: <input type="text" name="ora_inizio" value="<?php echo $tupla["ora_inizio"];?>"><br><br>
                     ora fine: <input type="text" name="ora_fine" value="<?php echo $tupla["ora_fine"];?>"><br><br>
                      Oggetto celeste osservato: &nbsp; <select name="oggetto_celeste">
       <?php 
           $sql2="SELECT ID,nome FROM oggettoceleste;";
            $risposta2=mysqli_query($conn,$sql2)or die("Errore nella query: " . $sql2 . "\n" . mysqli_error($conn));
            if(mysqli_num_rows($risposta2)!=0)
                 {
                 	 while ($tupla2 = mysqli_fetch_array($risposta2))
    	              {
                              $id=$tupla2["ID"];
                              $nome=$tupla2["nome"];
                              if($id==$tupla["id_oggettoceleste"])
                              {
                                $seleziona='selected="selected"';
                              }
                              else
                              {
                                 $seleziona="";
                              }
                              ?>
                              <option value="<?php echo "$id";?>" <?php echo $seleziona; ?> ><?php echo "$id - $nome ";?> </option>
                              <?php
    	              }
                 }

        ?>

       </select> <br><br>

       Oculare usato: &nbsp; <select name="oculare">
       <?php 
           $sql2="SELECT ID,nome FROM oculare;";
            $risposta2=mysqli_query($conn,$sql2)or die("Errore nella query: " . $sql2 . "\n" . mysqli_error($conn));
            if(mysqli_num_rows($risposta2)!=0)
                 {
                 	 while ($tupla2 = mysqli_fetch_array($risposta2))
    	              {
                              $id=$tupla2["ID"];
                              $nome=$tupla2["nome"];
                              if($id==$tupla["id_oculare"])
                              {
                                $seleziona='selected="selected"';
                              }
                              else
                              {
                                 $seleziona="";
                              }
                              ?>
                              <option value="<?php echo "$id";?>" <?php echo $seleziona; ?> ><?php echo "$id - $nome ";?> </option>
                              <?php
    	              }
                 }

        ?>

       </select> <br><br>

       Filtro usato: &nbsp; <select name="filtro">
       <?php 
           $sql2="SELECT ID,nome FROM filtro_altro;";
            $risposta2=mysqli_query($conn,$sql2)or die("Errore nella query: " . $sql2 . "\n" . mysqli_error($conn));
            if(mysqli_num_rows($risposta2)!=0)
                 {
                 	 while ($tupla2 = mysqli_fetch_array($risposta2))
    	              {
                              $id=$tupla2["ID"];
                              $nome=$tupla2["nome"];
                              if($id==$tupla["id_filtro"])
                              {
                                $seleziona='selected="selected"';
                              }
                              else
                              {
                                 $seleziona="";
                              }
                              ?>
                              <option value="<?php echo "$id";?>" <?php echo $seleziona; ?> ><?php echo "$id - $nome ";?> </option>
                              <?php
    	              }
                 }

        ?>

       </select> <br><br>

      Strumento usato: &nbsp; <select name="strumento">
       <?php 
           $sql2="SELECT ID,nome FROM strumento;";
            $risposta2=mysqli_query($conn,$sql2)or die("Errore nella query: " . $sql2 . "\n" . mysqli_error($conn));
            if(mysqli_num_rows($risposta2)!=0)
                 {
                 	 while ($tupla2 = mysqli_fetch_array($risposta2))
    	              {
                              $id=$tupla2["ID"];
                              $nome=$tupla2["nome"];
                              if($id==$tupla["id_strumento"])
                              {
                                $seleziona='selected="selected"';
                              }
                              else
                              {
                                 $seleziona="";
                              }
                              ?>
                              <option value="<?php echo "$id";?>" <?php echo $seleziona; ?> ><?php echo "$id - $nome ";?> </option>
                              <?php
    	              }
                 }

        ?>

       </select> <br><br>
      Area osservazione: &nbsp; <select name="area_osservazione">
       <?php 
           $sql2="SELECT ID,nome FROM areageografica;";
            $risposta2=mysqli_query($conn,$sql2)or die("Errore nella query: " . $sql2 . "\n" . mysqli_error($conn));
            if(mysqli_num_rows($risposta2)!=0)
                 {
                 	 while ($tupla2 = mysqli_fetch_array($risposta2))
    	              {
                              $id=$tupla2["ID"];
                              $nome=$tupla2["nome"];
                              if($id==$tupla["id_area_geografica"])
                              {
                                $seleziona='selected="selected"';
                              }
                              else
                              {
                                 $seleziona="";
                              }
                              ?>
                              <option value="<?php echo "$id";?>" <?php echo $seleziona; ?> ><?php echo "$id - $nome ";?> </option>
                              <?php
    	              }
                 }

        ?>

       </select> <br><br>

       <select name="scelta_operazione">
          <option value="modifica">Modifica </option>
          <option value="elimina">Elimina </option>
	     </select>
	     <?php
	     $sql3="SELECT ID FROM datiosservazione WHERE id_osservazioni=".$tupla["id_osservazioni"].";";
            $risposta3=mysqli_query($conn,$sql3)or die("Errore nella query: " . $sql3 . "\n" . mysqli_error($conn));
                 	  $tupla3 = mysqli_fetch_array($risposta3);
    	              
     ?>
	     <input type="hidden" name="id_osservazione2" value="<?php echo $tupla["id_osservazioni"];  ?>" />
	     <input type="hidden" name="id_datiosservazione2" value="<?php echo $tupla3["ID"];  ?>" />
	     <input type="submit" name="invio" value="Esegui operazione">
                     </form>
                     </center>
                 	<?php
                 }
            
       }
       else
       {

          ?>
          
            <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" >
            Selezionare l'Osservazione: &nbsp; <select name="id_osservazione">
              <?php
              $bho=$_SESSION['login'];
            echo "miao miao";
             ?> 
            <?php
            $sql="SELECT datiosservazione.id_osservazioni FROM datiosservazione,anagrafica,osservazioni WHERE datiosservazione.stato='non_completata' AND datiosservazione.id_osservazioni=osservazioni.ID AND anagrafica.numero_socio=osservazioni.id_anagrafica  AND anagrafica.username='".$_SESSION["login"]."';";
            
         
            $risposta=mysqli_query($conn,$sql)or die("Errore nella query: " . $sql . "\n" . mysqli_error($conn));
            if(mysqli_num_rows($risposta)!=0)
                 {
                     while ($tupla = mysqli_fetch_array($risposta))
    	              {
                              $id_osservazione=$tupla["id_osservazioni"];
                              //$nome=$tupla["nome"];
                              //$cognome=$tupla["cognome"];

                              ?>
                              <option value="<?php echo "$id_osservazione";?>"><?php echo "$id_osservazione";?> </option>
                              <?php
    	              }
    	              
    	          } //fine if per sapere se la query ha tornato qualcosa
    	          else
    	          {
    	          	echo"TROVATO NULLA";
    	          }
            ?>
            </select> &nbsp;&nbsp;
            <input type="submit" name="invio_ricerca" value="Modifica/Elimina"/>
            </form>
       <?php
       }

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
</body>
</html>