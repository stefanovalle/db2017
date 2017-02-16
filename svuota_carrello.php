<?php
// inizializziamo le sessioni
session_start();

unset($_SESSION['carrello']);

// rimando a pagina carrello
header ('location: carrello.php');
