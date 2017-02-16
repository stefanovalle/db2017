<?php
// inizializziamo le sessioni
session_start();

// salviamo in sessione tutti i dati ricevuti via POST
$_SESSION['utente'] = $_POST;

// rimando a pagina carrello
header ('location: riepilogo.php');
