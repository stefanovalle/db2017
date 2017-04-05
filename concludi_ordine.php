<?php

// inizializziamo le sessioni
session_start();

include 'libs/db.php';
include 'libs/couchdb.php';
include 'vendor/autoload.php';

// inizializzazione connessione a Postgres
$db = creaConnessionePDO();

// inizializzazione connessione a CouchDB
$couchdb = creaConnessioneCouchDB();

// recupero il carrello corrente
$carrello = $_SESSION['carrello'];

$utente = $_SESSION['utente'];

// salvataggio dati ordine in database
try {

    // creazione documento che contiene l'ordine
    $ordine = [];

    // dati cliente
    $ordine['cliente'] = $utente;

    // prodotti
    $prodotti = [];
    foreach($carrello as $rigaCarrello) {

        $stmt = $db->prepare('SELECT prodotti.nome, prodotti.prezzo, prodottivarianti.prezzo as prezzo_variante, varianti.nome as nome_variante
                              FROM prodottivarianti, varianti, prodotti
                              WHERE prodottivarianti.variante_id = varianti.id
                              AND prodotti.id = prodottivarianti.prodotto_id
                              AND prodottivarianti.prodotto_id = :idProdotto
                              AND prodottivarianti.variante_id = :idVariante');

        // bind parametro alla query
        $stmt->bindParam(':idProdotto', $rigaCarrello['prodotto'], PDO::PARAM_INT);
        $stmt->bindParam(':idVariante', $rigaCarrello['variante'], PDO::PARAM_INT);
        $stmt->execute();

        $risultato = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // mi aspetto solo 1 riga come risultato
        $valori = $risultato[0];

        $prezzo = $valori['prezzo'] + $valori['prezzo_variante'];

        $descrizione = $valori['nome'] . ' - ' . $valori['nome_variante'];

        $prodotti[] = [
          'descrizione' => $descrizione,
          'prezzo' => $prezzo,
          'prodotto_id' => $rigaCarrello['prodotto'],
          'variante_id' => $rigaCarrello['variante']
        ];

    }

    $ordine['prodotti'] = $prodotti;

    // altri dati
    $ordine['data'] = date('Y-m-d H:i:s');

    // salvataggio documento su CouchDB
    $couchdb->storeDoc((object) $ordine);

    // svuotamento variabili di sessione
    unset($_SESSION['utente']);
    unset($_SESSION['carrello']);

    // rimando a pagina conclusiva
    header ('location: grazie.php');

} catch (Exception $e) {
    echo "Si è verificato un errore: " . $e->getMessage();
}
