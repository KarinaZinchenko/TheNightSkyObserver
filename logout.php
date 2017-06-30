<?php
session_start(); // recupera il riferimento alla sessione
session_unset(); // elimina tutte le variabili di sessione
include("config.php");
// elimina il cookie PHPSESSID (SessionId)
if (ini_get("session.use_cookies")) {
$params = session_get_cookie_params();
setcookie(session_name(), '', time() - 86400,
$params["path"], $params["domain"],
$params["secure"], $params["httponly"]
);
}
session_destroy(); // distrugge la sessione
header("Location: index.php"); // redirige il browser
?>
