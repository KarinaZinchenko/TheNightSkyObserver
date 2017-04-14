<?php
//session_destroy();
session_start();
include("config.php");
?>

<html>
<head>
	<title>Log-in </title>
</head>
<body>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
	<center><br><br>
	username: <input type="text" name="username"><br><br>
	password: <input type="password" name="password"><br><br>
	<input type="submit" name="invia" value="Entra">
	</center>
</form>


<?php
if ($_SERVER["REQUEST_METHOD"]=="POST") {
  $username="";
  $password="";
if(isset($_REQUEST["username"]) && isset($_REQUEST["password"])) 
 {
    $username=$_REQUEST["username"];
    $password=$_REQUEST["password"];

 } 

 if($username=="" || $password=="")
 {
         echo "<script language='javascript'>"; 
         echo "alert('I campi user e password sono obbligatori');";
        echo " </script>";
          exit();
 }

  $sql="SELECT password,nome,cognome,tipo FROM anagrafica WHERE username='".addslashes($username)."';";                     
  $risposta=mysqli_query($conn,$sql)or die("Errore nella query: " . $sql . "\n" . mysqli_error($conn));
  if(mysqli_num_rows($risposta)!=0)
  {
     while ($tupla = mysqli_fetch_array($risposta))
    	{
    		if($tupla["password"]==$password)
        {
    		echo "i dati di log-in sono corretti per l'utente ".$tupla["nome"]." ".$tupla["cognome"];
         $_SESSION["autenticato"]=true;
         $_SESSION["login"]=$username;
         $_SESSION["tipo"]=$tupla["tipo"];
       
         header("Location: prova-sessioni.php");
       }
    	    else
    	    echo "User e/o password non esistenti o errati";
    	}
     
  }
  else
  	echo "User e/o password non esistenti o errati";
  	
/*  if($_SERVER["REQUEST_METHOD"]=="POST")
  {
  	$nome="";
  	$cognome="";
  	$username="";
  	$password="";
  	if(isset($_POST["nome"]))
  	{
  		$nome=$_POST["nome"];
  	}
  	  	if(isset($_POST["cognome"]))
  	{
  		$cognome=$_POST["cognome"];
  	}
  	  	if(isset($_POST["username"]))
  	{
  		$username=$_POST["username"];
  	}
  	  	if(isset($_POST["password"]))
  	{
  		$password=$_POST["password"];
  	}
  	 $nome=nl2br(htmlentities($nome,ENT_QUOTES,'UTF-8'));
  	  $cognome=nl2br(htmlentities($cognome,ENT_QUOTES,'UTF-8'));
  	   $username=nl2br(htmlentities($username,ENT_QUOTES,'UTF-8'));
  	    $password=nl2br(htmlentities($password,ENT_QUOTES,'UTF-8'));

  	$sql=" INSERT INTO utenti (nome,cognome,username,password) VALUES ('".addslashes($nome)."','".addslashes($cognome)."','".addslashes($username)."','".addslashes(md5($password))."');";
  	if(mysqli_query($conn, $sql) )
  {
     echo "<script language='javascript'>"; 
       	 echo "alert('Inserimento effettuato');";
          echo " </script>";
  } 
  else {die("Errore nella query: "     . $sql . "\n" . mysqli_error($conn));}

 	
  }
*/

  mysqli_close($conn);
}
  
 ?>
  </body>
</html>
