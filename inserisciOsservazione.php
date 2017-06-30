<?php
ob_start();
?>
<html>
<head> <title>Inserimento nuova osservazione</title>
 <script>
        function printPage() {
            window.print();
        }
    </script> </head>
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

if (isset($_SESSION['autenticato']) && isset($_SESSION['tipo'])) {
    if ($_SESSION['tipo'] == "regolare" || $_SESSION['tipo'] == "amministratore") {
        ?>
          <script type="text/javascript" language="javascript">
            function aggiungiOsservazione() {
              var formInserimento = document.getElementById("formInserimento");

              // Crea nuovo campo 'stato'
              var stato = document.createElement("select");
              stato.setAttribute("name", "stato[]");
              stato.setAttribute("class","soflow-color");
              var statoEsistente = document.getElementById("stato");
              var statoEsistenteOptions = statoEsistente.innerHTML;
              stato.innerHTML = statoEsistenteOptions;

              // Crea nuovo campo rating
              var rating = document.createElement("input");
              rating.setAttribute("type", "number");
              rating.setAttribute("name", "rating[]");
              rating.setAttribute("step", "any");

              // Crea nuovo campo descrizione
              var descrizione = document.createElement("input");
              descrizione.setAttribute("type", "text");
              descrizione.setAttribute("name", "descrizione[]");

              // Crea nuovo campo immagine
              var immagine = document.createElement("input");
              immagine.setAttribute("type", "file");
              immagine.setAttribute("name", "immagine[]");

              // Crea nuovo campo note
              var note = document.createElement("input");
              note.setAttribute("type", "text");
              note.setAttribute("name", "note[]");

              // Crea nuovo campo ora inizio
              var ora_inizio = document.createElement("input");
              ora_inizio.setAttribute("type", "text");
              ora_inizio.setAttribute("name", "ora_inizio[]");

              // Crea nuovo campo ora fine
              var ora_fine = document.createElement("input");
              ora_fine.setAttribute("type", "text");
              ora_fine.setAttribute("name", "ora_fine[]");

              // Crea nuovo campo oggetto celeste
              var oggettoCeleste = document.createElement("select");
              oggettoCeleste.setAttribute("name", "oggetto_celeste[]");
              oggettoCeleste.setAttribute("class","soflow-color");
              var oggettoCelesteEsistente = document.getElementById("oggettoCeleste");
              var oggettoCelesteEsistenteOptions = oggettoCelesteEsistente.innerHTML;
              oggettoCeleste.innerHTML = oggettoCelesteEsistenteOptions;

              // Crea nuovo campo strumento
              var strumento = document.createElement("select");
              strumento.setAttribute("name", "strumento[]");
              strumento.setAttribute("class","soflow-color");
              var strumentoEsistente = document.getElementById("strumentoUsato");
              var strumentoEsistenteOptions = strumentoEsistente.innerHTML;
              strumento.innerHTML = strumentoEsistenteOptions;

              // Crea nuovo campo oculare
              var oculare = document.createElement("select");
              oculare.setAttribute("name", "oculare[]");
              oculare.setAttribute("class","soflow-color");
              var oculareEsistente = document.getElementById("oculareUsato");
              var oculareEsistenteOptions = oculareEsistente.innerHTML;
              oculare.innerHTML = oculareEsistenteOptions;

              // Crea nuovo campo filtro
              var filtro = document.createElement("select");
              filtro.setAttribute("name", "filtro[]");
              filtro.setAttribute("class","soflow-color");
              var filtroEsistente = document.getElementById("filtroUsato");
              var filtroEsistenteOptions = filtroEsistente.innerHTML;
              filtro.innerHTML = filtroEsistenteOptions;

              // Crea nuovo campo id utente
              var id_utente = document.createElement("input");
              id_utente.setAttribute("type", "hidden");
              var id_utenteEsistente = document.getElementById("idUtente");
              var id_utenteEsistenteValue = id_utenteEsistente.getAttribute("value");
              id_utente.setAttribute("name", "id_utente[]");
              id_utente.setAttribute("value", id_utenteEsistenteValue);

              // Aggiungi linea di separazione
              formInserimento.appendChild(document.createElement("hr"));
              var row1 = formInserimento.appendChild(document.createElement("div"));
              row1.setAttribute("class","row");
              var col1 = row1.appendChild(document.createElement("div"));
              col1.setAttribute("class","col-xs-6 col-sm-3 col-md-3 form-group");
              // Aggiungi nuovo campo 'stato'
              var lab = col1.appendChild(document.createElement("label"));
              lab.appendChild(document.createTextNode("Stato *"));
              col1.appendChild(stato);
              var col2 = row1.appendChild(document.createElement("div"));
              col2.setAttribute("class","col-xs-6 col-sm-3 col-md-3 form-group");
              // Aggiungi nuovo campo 'rating'
              lab = col2.appendChild(document.createElement("label"));
              lab.appendChild(document.createTextNode("Rating"));
              col2.appendChild(rating);
              var col3 = row1.appendChild(document.createElement("div"));
              col3.setAttribute("class","col-xs-6 col-sm-3 col-md-3 form-group");
              // Aggiungi nuovo campo 'immagine'
              lab = col3.appendChild(document.createElement("label"));
              lab.appendChild(document.createTextNode("Immagine"));
              col3.appendChild(immagine);
              var col4 = row1.appendChild(document.createElement("div"));
              col4.setAttribute("class","col-xs-6 col-sm-3 col-md-3 form-group");
              // Aggiungi nuovo campo 'descrizione'
              lab = col4.appendChild(document.createElement("label"));
              lab.appendChild(document.createTextNode("Descrizione"));
              col4.appendChild(descrizione);


              var row2 = formInserimento.appendChild(document.createElement("div"));
              row2.setAttribute("class","row");
              col1 =row2.appendChild(document.createElement("div"));
              col1.setAttribute("class","col-xs-6 col-sm-3 col-md-3 form-group");
              // Aggiungi nuovo campo 'ora inizio'
              lab = col1.appendChild(document.createElement("label"));
              lab.appendChild(document.createTextNode("Ora inizio"));
              col1.appendChild(ora_inizio);
              col2 =row2.appendChild(document.createElement("div"));
              col2.setAttribute("class","col-xs-6 col-sm-3 col-md-3 form-group");
              // Aggiungi nuovo campo 'ora fine'
              lab = col2.appendChild(document.createElement("label"));
              lab.appendChild(document.createTextNode("Ora fine"));
              col2.appendChild(ora_fine);
              col3 =row2.appendChild(document.createElement("div"));
              col3.setAttribute("class","col-xs-6 col-sm-3 col-md-3 form-group");
              // Aggiungi nuovo campo 'note'
              lab = col3.appendChild(document.createElement("label"));
              lab.appendChild(document.createTextNode("Note"));
              col3.appendChild(note);
              col4 =row2.appendChild(document.createElement("div"));
              col4.setAttribute("class","col-xs-6 col-sm-3 col-md-3 form-group");
              // Aggiungi nuovo campo 'oggetto celeste'
              lab = col4.appendChild(document.createElement("label"));
              lab.appendChild(document.createTextNode("Oggetto celeste *"));
              col4.appendChild(oggettoCeleste);

              var row3 = formInserimento.appendChild(document.createElement("div"));
              row3.setAttribute("class","row");
              col1 = row3.appendChild(document.createElement("div"));
              col1.setAttribute("class","col-xs-12 col-sm-12 col-md-12 form-group");
              // Aggiungi nuovo campo 'strumento'
              lab = col1.appendChild(document.createElement("label"));
              lab.appendChild(document.createTextNode("Strumento"));
              col1.appendChild(strumento);
              col2 = row3.appendChild(document.createElement("div"));
              col2.setAttribute("class","col-xs-12 col-sm-12 col-md-12 form-group");
              // Aggiungi nuovo campo 'oculare'
              lab = col2.appendChild(document.createElement("label"));
              lab.appendChild(document.createTextNode("Oculare"));
              col2.appendChild(oculare);
              col3 = row3.appendChild(document.createElement("div"));
              col3.setAttribute("class","col-xs-12 col-sm-12 col-md-12 form-group");
              // Aggiungi nuovo campo 'filtro'
              lab = col3.appendChild(document.createElement("label"));
              lab.appendChild(document.createTextNode("Filtro"));
              col3.appendChild(filtro);
              // Aggiungi nuovo campo 'id_utente'
              formInserimento.appendChild(id_utente);
            }
          </script>
            <h1>Inserisci i dati dell'osservazione</h1>
            <form method="post" action="inserisciOsservazioneEffettivo.php" enctype="multipart/form-data">

            <div class="row">
                <div class="col-xs-6 col-sm-4 col-md-4 form-group">
                    <label>Categoria *</label><input type="text" name="categoria">
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 form-group">
                    <label>Trasparenza *</label><input type="number" name="trasparenza" step="any">
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 form-group">
                    <label>Area osservazione *</label><select id="soflow-color" name="area_osservazione">
                        <?php
                        $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');
                        $stmt = $conn->prepare("SELECT id, nome FROM areageografica");
                        $result = $stmt->execute();
                        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        $row_count = $stmt->rowCount();
                        if ($row_count > 0) {
                            foreach ($rows as $row) {
                                $id = $row['id'];
                                $nome = $row['nome'];
                                echo "<option value=\"$id\">$id - $nome</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 form-group">
                    <label>Seeing (scala Antoniani)</label><input type="number" name="seeing_antoniani" step="any">
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 form-group">
                    <label>Seeing (scala pickering)</label><input type="number" name="seeing_pickering" step="any">
                </div>
            </div>
            <hr>
          <div id="formInserimento">
              <div class="row">
                  <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                      <label>Stato *</label><select id="stato" name="stato[]" class="soflow-color">
                          <option value="pianificata" selected="selected">Pianificata</option>
                          <option value="conclusa">Conclusa</option>
                          <option value="non_conclusa">Non conclusa</option>
                      </select>
                  </div>
                  <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                      <label>Rating</label><input type="number" name="rating[]" step="any">
                  </div>
                  <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                      <label>Immagine</label><input type="file" name="immagine[]">
                  </div>
                  <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                      <label>Descrizione</label><textarea name="descrizione[]"></textarea>
                  </div>
              </div>
              <div class="row">
                  <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                      <label>Ora inizio</label><input type="datetime-local" name="ora_inizio[]">
                  </div>
                  <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                      <label>Ora fine</label><input type="datetime-local" name="ora_fine[]">
                  </div>
                  <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                      <label>Note</label><textarea name="note[]"></textarea>
                  </div>
                  <div class="col-xs-6 col-sm-3 col-md-3 form-group">
                      <label>Oggetto celeste *</label><select class="soflow-color" id="oggettoCeleste" name="oggetto_celeste[]">
                          <?php
                          $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');
                          $stmt = $conn->prepare("SELECT id, nome FROM oggettoceleste");
                          $result = $stmt->execute();
                          $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                          $row_count = $stmt->rowCount();
                          if ($row_count > 0) {
                              foreach ($rows as $row) {
                                  $id = $row['id'];
                                  $nome = $row['nome'];
                                  echo "<option value=\"$id\">$id - $nome</option>";
                              }
                          }
                          ?>
                      </select>
                  </div>
              </div>
              <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 form-group">
                      <label>Strumento</label><select class="soflow-color" id="strumentoUsato" name="strumento[]">
                          <?php
                          $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');
                          $stmt = $conn->prepare("SELECT id, nome FROM strumento");
                          $result = $stmt->execute();
                          $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                          $row_count = $stmt->rowCount();
                          if ($row_count > 0) {
                              foreach ($rows as $row) {
                                  $id = $row['id'];
                                  $nome = $row['nome'];
                                  echo "<option value=\"$id\">$id - $nome</option>";
                              }
                          }
                          ?>
                      </select>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12 form-group">
                      <label>Oculare</label><select class="soflow-color" id="oculareUsato" name="oculare[]">
                          <option value="NULL"></option>
                          <?php
                          $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');
                          $stmt = $conn->prepare("SELECT id, nome FROM oculare");
                          $result = $stmt->execute();
                          $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                          $row_count = $stmt->rowCount();
                          if ($row_count > 0) {
                              foreach ($rows as $row) {
                                  $id = $row['id'];
                                  $nome = $row['nome'];
                                  echo "<option value=\"$id\">$id - $nome</option>";
                              }
                          }
                          ?>
                      </select>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12 form-group">
                      <label>Filtro</label><select class="soflow-color" id="filtroUsato" name="filtro[]">
                          <option value="NULL"></option>
                          <?php
                          $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');
                          $stmt = $conn->prepare("SELECT id, nome FROM filtro_altro");
                          $result = $stmt->execute();
                          $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                          $row_count = $stmt->rowCount();
                          if ($row_count > 0) {
                              foreach ($rows as $row) {
                                  $id = $row['id'];
                                  $nome = $row['nome'];
                                  echo "<option value=\"$id\">$id - $nome</option>";
                              }
                          }
                          ?>
                      </select>
                  </div>
              </div>
            <input class="btn" type="hidden" id="idUtente" name="id_utente[]" value="<?php echo $_SESSION['numero_socio']; ?>" />
          </div>
          <input id="contact-submit" class="btn" type="submit" name="invio" value="salva">
          <button id="contact-submit" class="btn" type="button" name="aggiungi" onclick="aggiungiOsservazione()">Aggiungi un altro oggetto</button>
          <input id="contact-submit" class="btn" type="submit" value="Stampa" onclick="printPage()"><br><br>
        </form>
        <?php
        } else {
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
