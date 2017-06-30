<?php
ob_start();
?>
<html>
<head> <title>Modifica/Elimina Utente</title> </head>
<body>
<?php
session_start();
include("config.php");
include("header.php");
include("navbar.php");
echo "<div class='container'>";
echo "<div class='row-fluid'>";
echo "<div class='span10 offset1'>";
echo "<div class='contact-info'>";
echo "<div class='panel-body'>";
if(isset($_SESSION["autenticato"])&& isset($_SESSION["tipo"]))
{
	if($_SESSION["tipo"]=="amministratore")
	{
       if(isset($_POST["invio_ricerca"]))
       {
            echo "<h1> Modifica/Elimina i dati dell'utente </h1><br>";
            $sql="SELECT nome,cognome,username,password,tipo,scadenza_tessera,data_nascita FROM anagrafica WHERE numero_socio=".$_POST["tipo_utente"].";";
            $risposta=mysqli_query($conn,$sql)or die("Errore nella query: " . $sql . "\n" . mysqli_error($conn));
            if(mysqli_num_rows($risposta)!=0)
                 {
                 	$tupla = mysqli_fetch_array($risposta);

                 

            ?>

     <form method="post" action="modificaEliminaUtenteEffettivo.php">
         <input type="hidden" name="id_utente" value="<?php echo $_POST["tipo_utente"];  ?>" />
          <input type="hidden" name="password_utente" value="<?php echo $_POST["password"];  ?>" />
         <div class="row">
             <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                 <label>Nome *</label>
                 <input type="text" name="nome" value="<?php echo $tupla['nome']; ?>">
             </div>
             <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                 <label>Cognome *</label>
                 <input type="text" name="cognome" value="<?php echo $tupla['cognome'];?>">
             </div>
             <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                 <label>Username *</label>
                 <input type="text" name="username" value="<?php echo $tupla['username'];?>">
             </div>
             <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                 <label>Password *</label>
                 <input type="password" name="password" value="<?php echo $tupla['password'];?>">
             </div>
         </div>
         <div class="row">
             <div class="col-xs-12 col-sm-4 col-md-4 form-group">
                 <label>Data scadenza tessera *</label>
                 <input type="datetime-local" name="scadenza_tessera" value="<?php echo date("Y-m-d\TH:i:s", strtotime($tupla["scadenza_tessera"])); ?>">
             </div>
             <div class="col-xs-12 col-sm-4 col-md-4 form-group">
                 <label>Data di nascita *</label>
                 <input type="datetime-local" name="data_nascita" value="<?php echo date("Y-m-d\TH:i:s", strtotime($tupla["data_nascita"])); ?>">
             </div>
             <div class="col-xs-12 col-sm-4 col-md-4 form-group">
                 <label>Tipo utente *</label>
                 <select class="soflow-color" name="tipo_utente" value="<?php echo $tupla['tipo'];?>">
                     <?php
                     $regolare="";
                     $amministratore="";
                     $insolvente="";
                     if ($tupla['tipo'] != "amministratore" && strtotime($tupla['scadenza_tessera']) < strtotime(date("Y-m-d"))) {
                         $stmt = $conn->prepare("UPDATE anagrafica SET tipo='insolvente' WHERE numero_socio=".$tupla['numero_socio'].";");
                         $result = $stmt->execute();
                         $tupla['tipo']="insolvente";
                     }
                     if($tupla['tipo']=="regolare")
                     {$regolare='selected="selected"';}
                     elseif ($tupla["tipo"]=="amministratore"){$amministratore='selected="selected"';}
                     	else{$insolvente='selected="selected"';}
                     ?>
                     <option value="<?php echo "$tipo_utenti[0]";?>"<?php echo $regolare; ?>><?php echo "$tipo_utenti[0]";?> </option>
                     <option value="<?php echo "$tipo_utenti[1]";?>" <?php echo $amministratore; ?>><?php echo "$tipo_utenti[1]";?> </option>
                     <option value="<?php echo "$tipo_utenti[2]";?>" <?php echo $insolvente; ?>><?php echo "$tipo_utenti[2]";?> </option>
                 </select>
             </div>
         </div>
         <input id="contact-submit" class="btn" type="submit" name="scelta_operazione" value="modifica"> &nbsp;&nbsp;
         <input id="contact-submit" class="btn" type="submit" name="scelta_operazione" value="elimina"> &nbsp;&nbsp;
         <?php
         //echo "<script>console.log('".date('Y-m-d',strtotime($tupla["scadenza_tessera"] . " - 7 day"))."');</script>";  
         //echo "<script>console.log('".date('Y-m-d')."');</script>";   
         if((date('Y-m-d')<=date('Y-m-d',strtotime($tupla["scadenza_tessera"] . " - 7 day")) && date('Y-m-d')>date('Y-m-d',strtotime($tupla["scadenza_tessera"] . " - 8 day"))) || (date('Y-m-d')>date('Y-m-d',strtotime($tupla["scadenza_tessera"])))){ 
         ?>
         	<input id="contact-submit" class="btn" type="submit" name="scelta_operazione" value="riattiva tessera">
         <?php
         }
         ?>

     </form>

            <?php             
            }//fine if per controllare se la tabella anagrafica torna qualcosa
            else
            { ?>
                <script>
                    swal({title:"Oops...!",text:"Si è verificato un errore nel recupero dei dati dal database.",type:"error",showConfirmButton:false});
                </script>
                <?php
                header("Refresh:2; url=profiloUtente.php", true, 303);
                exit();
            }
       }//fine if per capire se sono arrivato facendo una ricerca oppure no
       else
       {
       ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" >
        <h1>Selezionare l'utente di cui modificare i dati</h1><br>
        <select id="soflow-color" name="tipo_utente">
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
        <br>
        <input id="contact-submit" class="btn" type="submit" name="invio_ricerca" value="Modifica/Elimina"/>
        </form>


       <?php
        }

   } //chiudo if se tipo amministratore
   else
	{
       ?>
        <script>
            swal({title:"Oops...!",text:"Non sei autorizzato.",type:"error",showConfirmButton:false});
        </script>
        <?php
        header("Refresh:2; url=profiloUtente.php", true, 303);
	}
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
echo "</div>";
echo "</div>";

include("footer.php");
?>
</body>
</html>
