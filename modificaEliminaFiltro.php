<?php
ob_start();
?>
<html>
<head> <title>Modifica/Elimina Filtro</title> </head>
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

    echo "<h1> Modifica/Elimina i dati del filtro </h1><br>";
    $sql="SELECT nome,marca,descrizione,disponibilita,note FROM filtro_altro WHERE ID=".$_POST["id_filtro"].";";
    $risposta=mysqli_query($conn,$sql)or die("Errore nella query: " . $sql . "\n" . mysqli_error($conn));
if(mysqli_num_rows($risposta)!=0)
{
    $tupla = mysqli_fetch_array($risposta);

    ?>
    <form method="post" action="modificaEliminaFiltroEffettivo.php">
        <input type="hidden" name="id_filtro" value="<?php echo $_POST["id_filtro"];  ?>" />
        <div class="row">
            <div class="col-xs-6 col-sm-4 col-md-4 form-group">
                <label>Nome *</label>
                <textarea name="nome"><?php echo $tupla['nome']; ?></textarea>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-4 form-group">
                <label>Marca *</label>
                <input type="text" name="marca" value="<?php echo $tupla['marca'];?>">
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 form-group">
                <label>Disponibilita *</label>
                <input type="number" name="disponibilita" value="<?php echo $tupla['disponibilita'];?>" step=any>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                <label>Descrizione</label>
                <textarea name="descrizione"><?php echo $tupla['descrizione'];?></textarea>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 form-group">
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
}

else
{?>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" >
        <h1>Selezionare il filtro da modificare</h1>
        <select id="soflow-color" name="id_filtro">
            <?php
            $bho=$_SESSION['login'];
            ?>
            <?php
            $sql="SELECT ID,nome FROM filtro_altro ;";

            $risposta=mysqli_query($conn,$sql)or die("Errore nella query: " . $sql . "\n" . mysqli_error($conn));
            if(mysqli_num_rows($risposta)!=0)
            {
                while ($tupla = mysqli_fetch_array($risposta))
                {
                    $id_filtro=$tupla["ID"];
                    $nome=$tupla["nome"];
                    //$cognome=$tupla["cognome"];

                    ?>
                    <option value="<?php echo "$id_filtro";?>"><?php echo "$id_filtro - $nome";?> </option>
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
} // fine else menu a tendina

} // fine if controllo amministratore o regolare
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
