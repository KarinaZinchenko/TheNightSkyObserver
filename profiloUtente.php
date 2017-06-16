<head>
	<title>Profilo Utente</title>
</head>

<?php
session_start();
include("config.php");
include("header.php");
include("navbar.php");
echo "<div class='container'>";
echo "<div class='row-fluid'>";
echo "<div class='span10 offset1'>";

if(isset($_SESSION["autenticato"]))
{

$user=$_SESSION["login"];
$tipo=$_SESSION["tipo"];
$numero_socio=$_SESSION["numero_socio"];
$scadenza_tessera=$_SESSION["scadenza_tessera"];
  $conn = new PDO('mysql:host=localhost; dbname=my_teamzatopek; charset=utf8', 'root', '');

  if($tipo != "amministratore" && strtotime($scadenza_tessera) < strtotime(date("Y-m-d"))){
    $stmt = $conn->prepare("UPDATE anagrafica SET tipo='insolvente' WHERE numero_socio=".$numero_socio.";");
    $result = $stmt->execute();
    $tipo="insolvente";
  }


if(in_array($tipo, $tipo_utenti)){

if($tipo=="regolare" || $tipo=="amministratore"){
//echo "<a href='vistaOsservazioniUtente.php?id=".$numero_socio."'> click </a>";


/*$stmt = $conn->prepare("SELECT d_oss.descrizione, d_oss.note, d_oss.ora_fine, d_oss.ora_inizio
    FROM datiosservazione AS d_oss
    WHERE d_oss.stato = :stato
");
*/
$stmt = $conn->prepare("SELECT d_oss.descrizione, d_oss.note, d_oss.ora_fine, d_oss.ora_inizio, d_oss.immagine ,ogg.nome AS oggetto, ogg.id AS idOgg, s.nome AS strumento, o.nome AS oculare, f.nome AS filtro, oss.categoria AS categoria, oss.id AS idOss, ar.nome AS area, an.nome AS nome, an.cognome AS cognome
				FROM datiosservazione AS d_oss
				JOIN oggettoceleste AS ogg ON ogg.id=d_oss.id_oggettoceleste
				JOIN strumento AS s ON s.id=d_oss.id_strumento
				LEFT JOIN oculare AS o ON (d_oss.id_oculare IS NOT NULL AND d_oss.id_oculare=o.id)
				LEFT JOIN filtro_altro AS f ON (d_oss.id_filtro IS NOT NULL AND d_oss.id_filtro=f.id)
				LEFT JOIN
				(
				osservazioni AS oss
				JOIN areageografica AS ar ON ar.id=oss.id_area_geografica
				JOIN anagrafica AS an ON an.numero_socio=oss.id_anagrafica
				)ON oss.id=d_oss.id_osservazioni
				WHERE d_oss.stato = :stato AND an.numero_socio= $numero_socio
				");


# Salvo in una variabile se la query può non andare a buon fine ma può non andare a buon fine?
$result = $stmt->execute(array(':stato' => 'pianificata'));
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$row_count = $stmt->rowCount();

if ($row_count > 0) {
?>
<div class="featured-heading">
	<h1>Osservazioni programmate
		<a id="add" class="btn icon-btn btn-success" href="inserisciOsservazione.php"><span class="glyphicon btn-glyphicon glyphicon-plus img-circle text-success"></span>Add</a>
	</h1><br>

	<table class="table">
		<thead class="thead-default">
		<tr>
			<th><em class="fa fa-cog"></em></th>
			<th>Sito</th>
			<th>Categoria</th>
			<th>Oggetto celeste</th>
			<th>Ora inizio</th>
			<th>Ora fine</th>
            <th>Immagine</th>
			<th>Strumento</th>
			<th>Oculare</th>
			<th>Filtro</th>
			<th>Descrizione</th>
			<th>Note</th>
		</tr>
		</thead>
		<?php
		echo "<tbody>";
		foreach ($rows as $row) {
			echo "<tr>";
			echo "<td align='center'><a class='btn btn-default' href='modificaEliminaOsservazioneDaProfiloUtente.php?idOss=".$row['idOss']."&idOgg=".$row['idOgg']."' style='margin-bottom: 2px;'><em class='fa fa-pencil'></em></a></td>";
			echo "<td>". $row['area'] ."</td>";
			echo "<td>". $row['categoria'] ."</td>";
			echo "<td>". $row['oggetto'] ."</td>";
			echo "<td>". $row['ora_inizio'] ."</td>";
			echo "<td>". $row['ora_fine'] ."</td>";
            if(file_exists($row['immagine'])){
            	echo "<td><a href=\"". $row['immagine'] ."\"> <img src=\"" .$row['immagine']."\" width=\"70\" height= \"50\"/>"." </a></td>";
            }
            else{
            	echo "<td><img src=\"immagini/noimagefound.jpg\" width=\"70\" height= \"50\"/>"." </td>";
            }
			echo "<td>". $row['strumento'] ."</td>";
			echo "<td>". $row['oculare'] ."</td>";
			echo "<td>". $row['filtro'] ."</td>";
			echo "<td>". $row['descrizione'] ."</td>";
			echo "<td>". $row['note'] ."</td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		echo "</div>";
		}
		else{ ?>
			<div class="featured-heading">
				<h3> Non hai ancora pianificato nessuna osservazione? </h3> <br>
				<h4> Fallo ora, cosa aspetti...</h4> <br>
				<a class="btn icon-btn btn-success" href="inserisciOsservazione.php"><span class="glyphicon btn-glyphicon glyphicon-plus img-circle text-success"></span>Add</a>
			</div>
			<?php
		}


		}

		else {
			?>
			<script>
				swal({title:"Oops...!",text:"La tua tessera socio è scaduta. Per accedere a tutte le funzionalità devi rinnovare la tua iscrizione!",type:"error",showConfirmButton:true}
                  ,function(){
                      window.location.href = "logout.php";
                  }
                );
			</script>
			<?php			
		}
		}
		else
		{
			echo "l'utente è di una tipologia sbagliata";
		}
		}
		else
		{?>
			<script>
				swal({title:"Oops...!",text:"Non sei autorizzato.",type:"error",showConfirmButton:false});
			</script>
			<?php
			header("Refresh:3; index.php", true, 303);

		}
		echo "</div>";
		echo "</div>";
		echo "</div>";

		include("footer.php");
		?>
								