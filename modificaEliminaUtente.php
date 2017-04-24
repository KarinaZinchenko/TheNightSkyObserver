
<?php
session_start();
include("config.php");
if(isset($_SESSION["autenticato"])&& isset($_SESSION["tipo"]))
{
	if($_SESSION["tipo"]=="amministratore")
	{
       if(isset($_POST["invio_ricerca"]))
       {
            echo "<center> <h1> Modifica/Elimina i dati dell'utente: </h1> </center> <br><br>";
            $sql="SELECT nome,cognome,username,password,tipo,scadenza_tessera,data_nascita FROM anagrafica WHERE numero_socio=".$_POST["tipo_utente"].";";
            $risposta=mysqli_query($conn,$sql)or die("Errore nella query: " . $sql . "\n" . mysqli_error($conn));
            if(mysqli_num_rows($risposta)!=0)
                 {
                 	$tupla = mysqli_fetch_array($risposta);

                 

            ?>
               <html>
         <head>
         </head>
         <body>
         <center>
         <form method="post" action="modificaEliminaUtenteEffettivo.php">
          <input type="hidden" name="id_utente" value="<?php echo $_POST["tipo_utente"];  ?>" />
         nome: <input type="text" name="nome" value="<?php echo $tupla['nome']; ?>"><br><br>
         cognome: <input type="text" name="cognome" value="<?php echo $tupla['cognome'];?>"><br><br>
         username: <input type="text" name="username" value="<?php echo $tupla['username'];?>"><br><br>
	     password: <input type="password" name="password" value="<?php echo $tupla['password'];?>"><br><br>
	     tipo utente: &nbsp;<select name="tipo_utente" value="<?php echo $tupla['tipo'];?>">
	     <?php
           $regolare="";
	       $amministratore="";
	       $insolvente="";
	       if($tupla['tipo']=="regolare")
	       	{$regolare='selected="selected"';}elseif ($tupla["tipo"]){$amministratore='selected="selected"';}else{$insolvente='selected="selected"';}
	     ?>
         <option value="<?php echo "$tipo_utenti[0]";?>"<?php echo $regolare; ?>><?php echo "$tipo_utenti[0]";?> </option>
         <option value="<?php echo "$tipo_utenti[1]";?>" <?php echo $amministratore; ?>><?php echo "$tipo_utenti[1]";?> </option>
         <option value="<?php echo "$tipo_utenti[2]";?>" <?php echo $insolvente; ?>><?php echo "$tipo_utenti[2]";?> </option>
	      </select> <br><br>
	     data scadenza tessera: <input type="date" name="data_scadenza_tessera" value="<?php echo $tupla['scadenza_tessera'];?>"><br><br>
	     data nascita: <input type="date" name="data_nascita" value="<?php echo $tupla['data_nascita'];?>"><br><br>
	     <select name="scelta_operazione">
          <option value="modifica">Modifica </option>
          <option value="elimina">Elimina </option>
	     </select>
	     <input type="submit" name="invio" value="Esegui operazione">
         </form>
         </center>
         </body>
         </html>
            <?php
            }//fine if per controllare se la tabella anagrafica torna qualcosa
            else
            {
            	echo "errore nel recupero dei dati dal database <a herf='prova-sessioni.php'>Torna alla pagina personale </a>";
            	exit();
            }
       }//fine if per capire se sono arrivato facendo una ricerca oppure no
       else
       {
       ?>
           <html>
           <head> <title>Modifica/Elimina </title> </head>
           <body>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" >
            Scegliere l'utente: &nbsp;<select name="tipo_utente">
            <?php
            $sql="SELECT numero_socio,nome,cognome FROM anagrafica;";
            $risposta=mysqli_query($conn,$sql)or die("Errore nella query: " . $sql . "\n" . mysqli_error($conn));
            if(mysqli_num_rows($risposta)!=0)
                 {
                     while ($tupla = mysqli_fetch_array($risposta))
    	              {
                              $numero_socio=$tupla["numero_socio"];
                              $nome=$tupla["nome"];
                              $cognome=$tupla["cognome"];
                              ?>
                              <option value="<?php echo "$numero_socio";?>"><?php echo "$numero_socio - $nome $cognome";?> </option>
                              <?php
    	              }
    	          } //fine if per sapere se la query ha tornato qualcosa

            ?>
            
            </select> &nbsp;&nbsp;
            <input type="submit" name="invio_ricerca" value="Modifica/Elimina"/>
            </form>


       <?php
        }

   } //chiudo if se tipo amministratore
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
