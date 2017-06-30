<?php
$conn = mysqli_connect("localhost", "root", "") or die("Errore nella connessione al db: " . mysqli_connect_error());
  mysqli_select_db($conn,"my_teamzatopek") or die("Errore nella selezione del db: " . mysqli_error($conn));

$tipo_utenti=array("regolare","amministratore","insolvente");
// teamzatopek@localhost---> host
//my_teamzatopek---->nome database
// per alterviSTA
?>
