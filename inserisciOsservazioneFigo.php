<?php
session_start();
include("config.php");
if (isset($_SESSION['autenticato']) && isset($_SESSION['tipo'])) {
    if ($_SESSION['tipo'] == "regolare" || $_SESSION['tipo'] == "amministratore") {
        ?>
        <html>
        <head>
          <title>Inserimento nuova osservazione</title>
          <script type="text/javascript" language="javascript">
            function aggiungiOsservazione() {
              var formInserimento = document.getElementById("formInserimento");

              // Crea nuovo campo 'stato'
              var stato = document.createElement("select");
              stato.setAttribute("name", "stato[]");
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
              immagine.setAttribute("type", "text");
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
              var oggettoCelesteEsistente = document.getElementById("oggettoCeleste");
              var oggettoCelesteEsistenteOptions = oggettoCelesteEsistente.innerHTML;
              oggettoCeleste.innerHTML = oggettoCelesteEsistenteOptions

              // Crea nuovo campo strumento
              var strumento = document.createElement("select");
              strumento.setAttribute("name", "strumento[]");
              var strumentoEsistente = document.getElementById("strumentoUsato");
              var strumentoEsistenteOptions = strumentoEsistente.innerHTML;
              strumento.innerHTML = strumentoEsistenteOptions

              // Crea nuovo campo oculare
              var oculare = document.createElement("select");
              oculare.setAttribute("name", "oculare[]");
              var oculareEsistente = document.getElementById("oculareUsato");
              var oculareEsistenteOptions = oculareEsistente.innerHTML;
              oculare.innerHTML = oculareEsistenteOptions

              // Crea nuovo campo filtro
              var filtro = document.createElement("select");
              filtro.setAttribute("name", "filtro[]");
              var filtroEsistente = document.getElementById("filtroUsato");
              var filtroEsistenteOptions = filtroEsistente.innerHTML;
              filtro.innerHTML = filtroEsistenteOptions

              // Crea nuovo campo id utente
              var id_utente = document.createElement("input");
              id_utente.setAttribute("type", "hidden");
              var id_utenteEsistente = document.getElementById("idUtente");
              var id_utenteEsistenteValue = id_utenteEsistente.getAttribute("value");
              id_utente.setAttribute("name", "id_utente[]");
              id_utente.setAttribute("value", id_utenteEsistenteValue);

              // Aggiungi linea di separazione
              formInserimento.appendChild(document.createElement("hr"));
              // Aggiungi nuovo campo 'stato'
              formInserimento.appendChild(document.createTextNode("Stato: "));
              formInserimento.appendChild(stato);
              formInserimento.appendChild(document.createElement("br"));
              formInserimento.appendChild(document.createElement("br"));
              // Aggiungi nuovo campo 'rating'
              formInserimento.appendChild(document.createTextNode("Rating: "));
              formInserimento.appendChild(rating);
              formInserimento.appendChild(document.createElement("br"));
              formInserimento.appendChild(document.createElement("br"));
              // Aggiungi nuovo campo 'descrizione'
              formInserimento.appendChild(document.createTextNode("Descrizione: "));
              formInserimento.appendChild(descrizione);
              formInserimento.appendChild(document.createElement("br"));
              formInserimento.appendChild(document.createElement("br"));
              // Aggiungi nuovo campo 'immagine'
              formInserimento.appendChild(document.createTextNode("Immagine: "));
              formInserimento.appendChild(immagine);
              formInserimento.appendChild(document.createElement("br"));
              formInserimento.appendChild(document.createElement("br"));
              // Aggiungi nuovo campo 'note'
              formInserimento.appendChild(document.createTextNode("Note: "));
              formInserimento.appendChild(note);
              formInserimento.appendChild(document.createElement("br"));
              formInserimento.appendChild(document.createElement("br"));
              // Aggiungi nuovo campo 'ora inizio'
              formInserimento.appendChild(document.createTextNode("Ora inizio: "));
              formInserimento.appendChild(ora_inizio);
              formInserimento.appendChild(document.createElement("br"));
              formInserimento.appendChild(document.createElement("br"));
              // Aggiungi nuovo campo 'ora fine'
              formInserimento.appendChild(document.createTextNode("Ora fine: "));
              formInserimento.appendChild(ora_fine);
              formInserimento.appendChild(document.createElement("br"));
              formInserimento.appendChild(document.createElement("br"));
              // Aggiungi nuovo campo 'oggetto celeste'
              formInserimento.appendChild(document.createTextNode("Oggetto celeste osservato: "));
              formInserimento.appendChild(oggettoCeleste);
              formInserimento.appendChild(document.createElement("br"));
              formInserimento.appendChild(document.createElement("br"));
              // Aggiungi nuovo campo 'strumento'
              formInserimento.appendChild(document.createTextNode("Strumento usato: "));
              formInserimento.appendChild(strumento);
              formInserimento.appendChild(document.createElement("br"));
              formInserimento.appendChild(document.createElement("br"));
              // Aggiungi nuovo campo 'oculare'
              formInserimento.appendChild(document.createTextNode("Oculare usato: "));
              formInserimento.appendChild(oculare);
              formInserimento.appendChild(document.createElement("br"));
              formInserimento.appendChild(document.createElement("br"));
              // Aggiungi nuovo campo 'filtro'
              formInserimento.appendChild(document.createTextNode("Filtro usato: "));
              formInserimento.appendChild(filtro);
              formInserimento.appendChild(document.createElement("br"));
              formInserimento.appendChild(document.createElement("br"));
              // Aggiungi nuovo campo 'id_utente'
              formInserimento.appendChild(id_utente);
            }
          </script>
        </head>
        <body>
          <center>
            <h1>Inserisci i dati dell'osservazione</h1>
            <form method="post" action="inserisciOsservazioneEffettivoFigo.php">
              Categoria: <input type="text" name="categoria"><br><br>
              Trasparenza: <input type="number" name="trasparenza" step="any"><br><br>
              Seeing (scala Antoniani): <input type="number" name="seeing_antoniani" step="any"><br><br>
              Seeing (scala pickering): <input type="number" name="seeing_pickering" step="any"><br><br>
              Area osservazione: <select name="area_osservazione">
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
              <hr>
              <div id="formInserimento">
              Stato: <select id="stato" name="stato[]">
                <option value="pianificata" selected="selected">Pianificata</option>
                <option value="conclusa">Conclusa</option>
                <option value="non_conclusa">Non conclusa</option>
              </select><br><br>
              Rating: <input type="number" name="rating[]" step="any"><br><br>
              Descrizione: <input type="text" name="descrizione[]"><br><br>
              Immagine: <input type="text" name="immagine[]"><br><br>
              Note: <input type="text" name="note[]"><br><br>
              Ora inizio: <input type="text" name="ora_inizio[]"><br><br>
              Ora fine <input type="text" name="ora_fine[]"><br><br>
              Oggetto celeste osservato: <select id="oggettoCeleste" name="oggetto_celeste[]">
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
              </select><br><br>
              Strumento usato: <select id="strumentoUsato" name="strumento[]">
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
              </select><br><br>
              Oculare usato: <select id="oculareUsato" name="oculare[]">
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
              </select><br><br>
              Filtro usato: <select id="filtroUsato" name="filtro[]">
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
              </select><br><br>
              <input type="hidden" id="idUtente" name="id_utente[]" value="<?php echo $_SESSION['numero_socio']; ?>" />
              </div>
              <input type="submit" name="invio">
              <button type="button" name="aggiungi" onclick="aggiungiOsservazione()">Aggiungi osservazione</button>
            </form>
          </center>
        </body>
        </html>
        <?php
    } else {
          echo "<script language='javascript'>";
          echo "alert('Non sei autorizzato ');";
          echo "</script>";
          header("Refresh:0; url=prova-sessioni.php", true, 303);
    }
} else {
      echo "<script language='javascript'>";
      echo "alert('Non sei autorizzato ');";
      echo "</script>";
      header("Refresh:0; url=index.php", true, 303);
}
?>
