<?php
ob_start();
?>
<html>
<head> <title>Modifica/Elimina Oculare</title> </head>
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
	if($_SESSION["tipo"]=="amministratore" || $_SESSION["tipo"]=="regolare")
	{ 

		if(isset($_POST["invio_ricerca"]))
       {
             echo "<h1> Modifica/Elimina i dati dell'oculare </h1><br>";
            $sql="SELECT nome,marca,descrizione,disponibilita,note,dimensione,lunghezza_focale,campo_visione_apparente FROM oculare WHERE ID=".$_POST["id_oculare"].";";
             $risposta=mysqli_query($conn,$sql)or die("Errore nella query: " . $sql . "\n" . mysqli_error($conn));
            if(mysqli_num_rows($risposta)!=0)
                 {
                 	$tupla = mysqli_fetch_array($risposta);

            ?>
                <form method="post" action="modificaEliminaOculareEffettivo.php">
         <input type="hidden" name="id_oculare" value="<?php echo $_POST["id_oculare"];  ?>" />
         <div class="row">
             <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                 <label>Nome *</label>
                 <textarea name="nome"><?php echo $tupla['nome']; ?></textarea>
             </div>
             <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                 <label>Descrizione</label>
                 <textarea name="descrizione"><?php echo $tupla['descrizione'];?></textarea>
             </div>
             <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                 <label>Marca *</label>
                 <input type="text" name="marca" value="<?php echo $tupla['marca'];?>">
             </div>
             <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                 <label>Disponibilita *</label>
                 <input type="number" name="disponibilita" value="<?php echo $tupla['disponibilita'];?>" step=any>
             </div>
         </div>
         <div class="row">
             <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                 <label>Dimensione *</label>
                 <input type="number" name="dimensione" value="<?php echo $tupla['dimensione'];?>" step=any>
             </div>

             <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                 <label>Lunghezza_focale *</label>
                 <input type="number" name="lunghezza_focale" value="<?php echo $tupla['lunghezza_focale'];?>" step=any>
             </div>

             <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                 <label>Campo_visione_apparente *</label>
                 <input type="number" name="campo_visione_apparente" value="<?php echo $tupla['campo_visione_apparente'];?>" step=any>
             </div>
             <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                 <label>Note</label>
                 <textarea name="note"><?php echo $tupla['note'];?></textarea>
             </div>
         </div>
         <input id="contact-submit" class="btn" type="submit" name="scelta_operazione"
                value="modifica"> &nbsp;&nbsp;
         <input id="contact-submit" class="btn" type="submit" name="scelta_operazione" value="elimina">
 </form>

            <?php
        }
       } // fine if se sono arrivato scegliendo dalla tendina iniziale
       else
       {?>
          <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" >
            <h1>Selezionare l'oculare da modificare</h1>
            <select id="soflow-color" name="id_oculare">
              <?php
              $bho=$_SESSION['login'];
             ?> 
            <?php
            $sql="SELECT ID,nome FROM oculare ;";
            
         
            $risposta=mysqli_query($conn,$sql)or die("Errore nella query: " . $sql . "\n" . mysqli_error($conn));
            if(mysqli_num_rows($risposta)!=0)
                 {
                     while ($tupla = mysqli_fetch_array($risposta))
    	              {
                              $id_oculare=$tupla["ID"];
                              $nome=$tupla["nome"];
                              //$cognome=$tupla["cognome"];

                              ?>
                              <option value="<?php echo "$id_oculare";?>"><?php echo "$id_oculare - $nome";?> </option>
                              <?php
    	              }
    	              
    	          } //fine if per sapere se la query ha tornato qualcosa
    	          else
    	          {
    	          	echo"TROVATO NULLA";
    	          }
            ?>
            </select><br>
            <input id="contact-submit" class="btn" type="submit" name="invio_ricerca" value="Modifica/Elimina"/>
            </form>
       <?php
       }// fine else del menu a tendina iniziale
       


	} // fine 2° if
	else
{?>
        <script>
            swal({title:"Oops...!",text:"Non sei autorizzato.",type:"error",showConfirmButton:false});
        </script>
        <?php
        header("Refresh:2; url=profiloUtente.php", true, 303);
    }
} // fine primo if 
else {
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
