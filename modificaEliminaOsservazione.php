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
                            
                     Categoria: <input type="text" name="categoria" value="<?php echo $tupla["categoria"];?>"><br><br>
                     Trasparenza: <input type="number" name="trasparenza" step=any value="<?php echo $tupla["trasparenza"];?>"><br><br>
                     Seeing (scala antoniani): <input type="number" name="seeing_antoniani" step=any value="<?php echo $tupla["seeing_antoniani"];?>"><br><br>
                     Seeing (scala pickering): <input type="number" name="seeing_pickering" step=any value="<?php echo $tupla["seeing_pickering"];?>"><br><br>
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
               }

        ?>
       </select> <br><br>
       <?php
           $sql="SELECT * FROM datiosservazione,osservazioni WHERE osservazioni.ID=".$_POST["id_osservazione"]." AND datiosservazione.id_osservazioni=osservazioni.ID AND datiosservazione.stato='pianificata';";
            $risposta=mysqli_query($conn,$sql)or die("Errore nella query: " . $sql . "\n" . mysqli_error($conn));
            if(mysqli_num_rows($risposta)!=0)
                 {
               $numero_osservazione=mysqli_num_rows($risposta);
                  for($i=1;$i<=$numero_osservazione;$i++)
                    {// devo chiuderlo
                        $tupla = mysqli_fetch_array($risposta);
                     echo "<hr>";
                     ?>
                      Stato: &nbsp; <select name="stato<?php echo $i; ?>" >
                            <option value="pianificata" selected="selected"> pianificata </option>
                            <option value="conclusa"> conclusa </option>
                            </select><br><br>
                            <?php
                            if($tupla["rating"]==-1)
                            {
                              ?>
                              Rating: <input type="number" name="rating<?php echo $i; ?>" step=any value=NULL><br><br>
                              <?php
                            }
                            else
                            {
                              ?>
                              Rating: <input type="number" name="rating<?php echo $i; ?>" step=any value="<?php echo $tupla["rating"];?>"><br><br>
                              <?php
                            }
                            ?>
                     Descrizione: <input type="text" name="descrizione<?php echo $i; ?>" value="<?php echo $tupla["descrizione"];?>"><br><br>
                     Immagine: <input type="text" name="immagine<?php echo $i; ?>" value="<?php echo $tupla["immagine"];?>"><br><br>
                     Note: <input type="text" name="note<?php echo $i; ?>" value="<?php echo $tupla["note"];?>"><br><br>
                     Ora  inizio: <input type="text" name="ora_inizio<?php echo $i; ?>" value="<?php echo $tupla["ora_inizio"];?>"><br><br>
                     Ora fine: <input type="text" name="ora_fine<?php echo $i; ?>" value="<?php echo $tupla["ora_fine"];?>"><br><br>
                      Oggetto celeste osservato: &nbsp; <select name="oggetto_celeste<?php echo $i; ?>">
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
                                $id_oggetto_celeste_interessato=$id; // mi serve in modificaEliminaEffettivo.php
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

       Oculare usato: &nbsp; <select name="oculare<?php echo $i; ?>">
       <?php 
           $sql2="SELECT ID,nome FROM oculare;";
            $risposta2=mysqli_query($conn,$sql2)or die("Errore nella query: " . $sql2 . "\n" . mysqli_error($conn));
            if(mysqli_num_rows($risposta2)!=0)
                 {
                 	 while ($tupla2 = mysqli_fetch_array($risposta2))
    	              {
                              $id=$tupla2["ID"];
                              $nome=$tupla2["nome"];
                               $seleziona_null="";
                              $seleziona="";
                              if($tupla["id_oculare"]==NULL){
                                $seleziona_null='selected="selected"';
                              }
                                else{
                              if($id==$tupla["id_oculare"] )
                              {
                                $seleziona='selected="selected"';
                              }
                              else
                              {
                                 $seleziona="";
                              }
                              }
                              ?>
                              <option value="<?php echo "$id";?>" <?php echo $seleziona; ?> ><?php echo "$id - $nome ";?> </option>
                              <?php
    	              }
                 }

        ?>
     <option value=NULL <?php echo $seleziona_null;?> > </option>
       </select> <br><br>

       Filtro usato: &nbsp; <select name="filtro<?php echo $i; ?>">
       <?php 
           $sql2="SELECT ID,nome FROM filtro_altro;";
            $risposta2=mysqli_query($conn,$sql2)or die("Errore nella query: " . $sql2 . "\n" . mysqli_error($conn));
            if(mysqli_num_rows($risposta2)!=0)
                 {
                 	 while ($tupla2 = mysqli_fetch_array($risposta2))
    	              {
                              $id=$tupla2["ID"];
                              $nome=$tupla2["nome"];
                              $seleziona="";
                              $seleziona_null="";
                              if($tupla["id_filtro"]==NULL){
                                $seleziona_null='selected="selected"';
                              }
                                else{
                              if($id==$tupla["id_filtro"])
                              {
                                $seleziona='selected="selected"';
                              }
                              else
                              {
                                 $seleziona="";
                              }
                              }
                              ?>
                              <option value="<?php echo "$id";?>" <?php echo $seleziona; ?> ><?php echo "$id - $nome ";?> </option>
                              <?php
    	              }
                 }

        ?>
  <option value=NULL <?php echo $seleziona_null;?> > </option>
       </select> <br><br>

      Strumento usato: &nbsp; <select name="strumento<?php echo $i; ?>">
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
       Selezionare per Modificare/Eliminare:&nbsp; <input type="checkbox" name="scelta_modifica_elimina<?php echo $i; ?>" value="si"/>  <br><br>
     

	  <?php
     

        }//chiudo il for

          $sql4="SELECT datiosservazione.ID as ID FROM datiosservazione,osservazioni WHERE osservazioni.ID=".$_POST["id_osservazione"]." AND datiosservazione.id_osservazioni=osservazioni.ID AND datiosservazione.stato='pianificata';";
            $risposta4=mysqli_query($conn,$sql4)or die("Errore nella query: " . $sql4 . "\n" . mysqli_error($conn));
            if(mysqli_num_rows($risposta4)!=0)
                 {
                     $i=1;
                     while($tupla4 = mysqli_fetch_array($risposta4))
                     {
                      ?>
                           <input type="hidden" name="id_datiosservazione2<?php echo $i; ?>" value="<?php echo $tupla4["ID"];  ?>" />
                      <?php

                      $i++;
                      }
                 }
           }// chiudo il num_rows prima del for
       ?>
        <input type="hidden" name="id_osservazione2" value="<?php echo $tupla["id_osservazioni"];  ?>" />
       <input type="hidden" name="numero_tuple" value="<?php echo $numero_osservazione; ?>" />
	     <input type="submit" name="scelta_operazione" value="modifica"> &nbsp;&nbsp;  <input type="submit" name="scelta_operazione" value="elimina">
                     </form>
                     </center>
                 	<?php
                 
            
       }// fine if per verificare se sono ancora sulla tendina di selezione o meno
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
            $sql="SELECT datiosservazione.id_osservazioni FROM datiosservazione,anagrafica,osservazioni WHERE datiosservazione.stato='pianificata' AND datiosservazione.id_osservazioni=osservazioni.ID AND anagrafica.numero_socio=osservazioni.id_anagrafica  AND anagrafica.username='".$_SESSION["login"]."' GROUP BY datiosservazione.id_osservazioni ;";
            
         
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
       }// fine else del menu a tendina iniziale

	} // fine if di controllo di accesso in sessione e amministratore o utente regolare (tipo)
	else
	{
         echo "<script language='javascript'>"; 
         echo "alert('Non sei autorizzato ');";
        echo " </script>";
        header( "Refresh:0; url=prova-sessioni.php", true, 303);
	}

} // fine if per controllo di accesso loggato in sessione
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