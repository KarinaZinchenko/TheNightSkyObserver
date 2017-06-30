<?php
ob_start();
?>
<html>
<head> <title>Modifica/Elimina Osservazione</title> </head>
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

if (isset($_SESSION["autenticato"])&& isset($_SESSION["tipo"])) {
    if ($_SESSION["tipo"]=="amministratore" || $_SESSION["tipo"]=="regolare") {
        $idOss = $_GET['idOss'];
        $idOgg= $_GET['idOgg'];
        echo "<h1> Modifica/Elimina Osservazione </h1>  <br>";
        $sql="SELECT * FROM datiosservazione,osservazioni WHERE osservazioni.ID=".$idOss." AND datiosservazione.id_osservazioni=".$idOss;
        $risposta=mysqli_query($conn, $sql)or die("Errore nella query: " . $sql . "\n" . mysqli_error($conn));
        if (mysqli_num_rows($risposta)!=0) {
            $tupla = mysqli_fetch_array($risposta);
            //if($tupla['stato']=="regolare")
            //{$regolare='selected="selected"';}elseif ($tupla["tipo"]){$amministratore='selected="selected"';}else{$insolvente='selected="selected"';}
            ?>
            <center>
            <form method="post" action="modificaEliminaOsservazioneEffettivoDaProfiloUtente.php" enctype="multipart/form-data">
            <div class="row">
                <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                    <label>Categoria *</label> <input type="text" name="categoria"
                                                    value="<?php echo $tupla["categoria"]; ?>">
                </div>
                <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                    <label>Trasparenza *</label> <input type="number" name="trasparenza" step=any
                                                      value="<?php echo $tupla["trasparenza"]; ?>">
                </div>

                <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                    <label>Seeing (scala antoniani)</label> <input type="number" name="seeing_antoniani" step=any
                                                                   value="<?php echo $tupla["seeing_antoniani"]; ?>">
                </div>

                <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                    <label>Seeing (scala pickering)</label> <input type="number" name="seeing_pickering" step=any
                                                                   value="<?php echo $tupla["seeing_pickering"]; ?>">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 form-group">
                    <label>Area osservazione *</label>
                    <select id="soflow-color" name="area_osservazione">
                        <?php
                        $sql2 = "SELECT ID,nome FROM areageografica;";
                        $risposta2 = mysqli_query($conn, $sql2) or die("Errore nella query: " . $sql2 . "\n" . mysqli_error($conn));
                        if (mysqli_num_rows($risposta2) != 0) {
                            while ($tupla2 = mysqli_fetch_array($risposta2)) {
                                $id = $tupla2["ID"];
                                $nome = $tupla2["nome"];
                                if ($id == $tupla["id_area_geografica"]) {
                                    $seleziona = 'selected="selected"';
                                } else {
                                    $seleziona = "";
                                }
                                ?>
                                <option
                                    value="<?php echo "$id"; ?>" <?php echo $seleziona; ?> ><?php echo "$id - $nome "; ?> </option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <?php
            $sql = "SELECT * FROM datiosservazione,osservazioni WHERE osservazioni.ID=" . $idOss . " AND datiosservazione.id_oggettoceleste=" . $idOgg . " AND datiosservazione.id_osservazioni=osservazioni.ID ;";
            $risposta = mysqli_query($conn, $sql) or die("Errore nella query: " . $sql . "\n" . mysqli_error($conn));
            if (mysqli_num_rows($risposta) != 0) {
                $tupla = mysqli_fetch_array($risposta);
                ?>
                <hr>
                <h1>dati dell'oggetto celeste selezionato</h1>
                <div class="row">
                    <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                        <label>Stato *</label> <select id="soflow-color" name="stato">
                            <option value="pianificata" selected="selected"> pianificata</option>
                            <option value="conclusa"> conclusa</option>
                        </select>
                    </div>
                    <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                        <label>Oggetto celeste *</label> <select id="soflow-color"
                                                                         name="oggetto_celeste">
                            <?php
                            $sql2 = "SELECT ID,nome FROM oggettoceleste;";
                            $risposta2 = mysqli_query($conn, $sql2) or die("Errore nella query: " . $sql2 . "\n" . mysqli_error($conn));
                            if (mysqli_num_rows($risposta2) != 0) {
                                while ($tupla2 = mysqli_fetch_array($risposta2)) {
                                    $id = $tupla2["ID"];
                                    $nome = $tupla2["nome"];
                                    if ($id == $tupla["id_oggettoceleste"]) {
                                        $seleziona = 'selected="selected"';
                                        $id_oggetto_celeste_interessato = $id; // mi serve in modificaEliminaEffettivo.php
                                    } else {
                                        $seleziona = "";
                                    }
                                    ?>
                                    <option
                                        value="<?php echo "$id"; ?>" <?php echo $seleziona; ?> ><?php echo "$id - $nome "; ?> </option>
                                    <?php
                                }
                            }

                            ?>
                        </select>
                    </div>
                    <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                        <label>Ora inizio</label> <input type="datetime-local" name="ora_inizio"
                                                         value="<?php echo date("Y-m-d\TH:i:s", strtotime($tupla["ora_inizio"])); ?>">
                    </div>
                    <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                        <label>Ora fine</label> <input type="datetime-local" name="ora_fine"
                                                       value="<?php echo date("Y-m-d\TH:i:s", strtotime($tupla["ora_fine"])); ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                        <?php
                        if ($tupla["rating"] == -1) {
                            ?>
                            <label>Rating</label><input type="number" name="rating" step=any
                                                        value=NULL>
                            <?php
                        } else {
                            ?>
                            <label>Rating</label><input type="number" name="rating" step=any
                                                        value="<?php echo $tupla["rating"]; ?>">
                            <?php
                        }
                        ?>
                    </div>
                    <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                        <label>Immagine</label>
                        <input type="file" name="immagine">
                        <?php
                        /*if(file_exists($tupla['immagine'])){
                            echo "<td><a href=\"". $tupla['immagine'] ."\"> <img src=\"" .$tupla['immagine']."\" width=\"70\" height= \"50\"/>"." </a></td>";
                        }
                        else{
                            echo "<td><img src=\"immagini/noimagefound.jpg\" width=\"70\" height= \"50\"/>"." </td>";
                        }*/
                        ?>
                        
                    </div>
                    <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                        <label>Descrizione</label>
                        <textarea name="descrizione"><?php echo $tupla["descrizione"]; ?>
                        </textarea>
                    </div>
                    <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                        <label>Note</label>
                        <textarea name="note"><?php echo $tupla["note"]; ?>
                        </textarea>
                    </div>
                </div>
                <div class="row form-group">
                    <label>Oculare</label>
                    <select id="soflow-color" name="oculare">
                        <?php
                        $sql2 = "SELECT ID,nome FROM oculare;";
                        $risposta2 = mysqli_query($conn, $sql2) or die("Errore nella query: " . $sql2 . "\n" . mysqli_error($conn));
                        if (mysqli_num_rows($risposta2) != 0) {
                            while ($tupla2 = mysqli_fetch_array($risposta2)) {
                                $id = $tupla2["ID"];
                                $nome = $tupla2["nome"];
                                $seleziona_null = "";
                                $seleziona = "";
                                if ($tupla["id_oculare"] == null) {
                                    $seleziona_null = 'selected="selected"';
                                } else {
                                    if ($id == $tupla["id_oculare"]) {
                                        $seleziona = 'selected="selected"';
                                    } else {
                                        $seleziona = "";
                                    }
                                }
                                ?>
                                <option
                                    value="<?php echo "$id"; ?>" <?php echo $seleziona; ?> ><?php echo "$id - $nome "; ?> </option>
                                <?php
                            }
                        }

                        ?>
                        <option value=NULL <?php echo $seleziona_null; ?> ></option>
                    </select>
                </div>
                <div class="row form-group">
                    <label>Filtro</label>
                    <select id="soflow-color" name="filtro">
                        <?php
                        $sql2 = "SELECT ID,nome FROM filtro_altro;";
                        $risposta2 = mysqli_query($conn, $sql2) or die("Errore nella query: " . $sql2 . "\n" . mysqli_error($conn));
                        if (mysqli_num_rows($risposta2) != 0) {
                            while ($tupla2 = mysqli_fetch_array($risposta2)) {
                                $id = $tupla2["ID"];
                                $nome = $tupla2["nome"];
                                $seleziona = "";
                                $seleziona_null = "";
                                if ($tupla["id_filtro"] == null) {
                                    $seleziona_null = 'selected="selected"';
                                } else {
                                    if ($id == $tupla["id_filtro"]) {
                                        $seleziona = 'selected="selected"';
                                    } else {
                                        $seleziona = "";
                                    }
                                }
                                ?>
                                <option
                                    value="<?php echo "$id"; ?>" <?php echo $seleziona; ?> ><?php echo "$id - $nome "; ?> </option>
                                <?php
                            }
                        }

                        ?>
                        <option value=NULL <?php echo $seleziona_null; ?> ></option>
                    </select>
                </div>
                <div class="row form-group">
                    <label>Strumento</label>
                    <select id="soflow-color" name="strumento">
                        <?php
                        $sql2 = "SELECT ID,nome FROM strumento;";
                        $risposta2 = mysqli_query($conn, $sql2) or die("Errore nella query: " . $sql2 . "\n" . mysqli_error($conn));
                        if (mysqli_num_rows($risposta2) != 0) {
                            while ($tupla2 = mysqli_fetch_array($risposta2)) {
                                $id = $tupla2["ID"];
                                $nome = $tupla2["nome"];
                                if ($id == $tupla["id_strumento"]) {
                                    $seleziona = 'selected="selected"';
                                } else {
                                    $seleziona = "";
                                }
                                ?>
                                <option
                                    value="<?php echo "$id"; ?>" <?php echo $seleziona; ?> ><?php echo "$id - $nome "; ?> </option>
                                <?php
                            }
                        }

                        ?>

                    </select>
                </div>


                <?php

                $sql4 = "SELECT datiosservazione.ID as ID FROM datiosservazione,osservazioni WHERE osservazioni.ID=" . $idOss . " AND datiosservazione.id_osservazioni=osservazioni.ID AND datiosservazione.stato='pianificata';";
                $risposta4 = mysqli_query($conn, $sql4) or die("Errore nella query: " . $sql4 . "\n" . mysqli_error($conn));
                if (mysqli_num_rows($risposta4) != 0) {
                    $i = 1;
                    while ($tupla4 = mysqli_fetch_array($risposta4)) {
                        ?>
                        <input type="hidden" name="id_datiosservazione2"
                               value="<?php echo $tupla4["ID"]; ?>"/>
                        <?php

                        $i++;
                    }
                }// chiudo il num_rows prima del for
                ?>
                <input type="hidden" name="id_osservazione2" value="<?php echo $tupla["id_osservazioni"]; ?>"/>
                <input type="hidden" name="numero_tuple" value="<?php echo $numero_osservazione; ?>"/>
                <input id="contact-submit" class="btn" type="submit" name="scelta_operazione"
                       value="modifica"> &nbsp;&nbsp;
                <input id="contact-submit" class="btn" type="submit" name="scelta_operazione" value="elimina">
                </form>
                </center>
                <?php
            }
        }
    } else { // fine if di controllo di accesso in sessione e amministratore o utente regolare (tipo)
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
