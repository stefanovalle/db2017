<?php
// inizializziamo le sessioni
session_start();

// lettura parametro da URL
$idVariante = $_GET['id_variante'];
$idProdotto = $_GET['id_prodotto'];

// esiste già un carrello?
$carrello = [];
if (isset($_SESSION['carrello'])) {
    $carrello = $_SESSION['carrello'];
}

// aggiungiamo il prodotto / variante al carrello
$carrello[] = ['variante' => $idVariante, 'prodotto' => $idProdotto];

// salviamo il carrello in sessione
$_SESSION['carrello'] = $carrello;

// rimando a pagina carrello
header ('location: carrello.php');
