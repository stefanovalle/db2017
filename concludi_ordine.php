<?php

// inizializziamo le sessioni
session_start();

include 'libs/db.php';

$db = creaConnessionePDO();

// recupero il carrello corrente
$carrello = $_SESSION['carrello'];

$utente = $_SESSION['utente'];

// salvataggio dati ordine in database
try {

    $db->beginTransaction();

    // inserimento in tabella clienti
    $stmt = $db->prepare("INSERT INTO clienti (nome, cognome, email, indirizzo, citta, cap, provincia)
                              VALUES (:nome, :cognome, :email, :indirizzo, :citta, :cap, :provincia)");

    $stmt->bindParam(':nome', $utente['nome'], PDO::PARAM_STR);
    $stmt->bindParam(':cognome', $utente['cognome'], PDO::PARAM_STR);
    $stmt->bindParam(':email', $utente['email'], PDO::PARAM_STR);
    $stmt->bindParam(':indirizzo', $utente['indirizzo'], PDO::PARAM_STR);
    $stmt->bindParam(':citta', $utente['citta'], PDO::PARAM_STR);
    $stmt->bindParam(':cap', $utente['cap'], PDO::PARAM_STR);
    $stmt->bindParam(':provincia', $utente['provincia'], PDO::PARAM_STR);

    $stmt->execute();

    $idCliente = $db->lastInsertId('clienti_id_seq');

    // inserimento in tabella ordini
    $stmt = $db->prepare("INSERT INTO ordini (cliente_id, data, nome, cognome, indirizzo, citta, cap, provincia, stato, spese_spedizione)
                              VALUES (:cliente_id, :data, :nome, :cognome, :indirizzo, :citta, :cap, :provincia, 'Italia', 0)");

    $stmt->bindParam(':cliente_id', $idCliente, PDO::PARAM_INT);
    $stmt->bindParam(':nome', $utente['nome'], PDO::PARAM_STR);
    $stmt->bindParam(':cognome', $utente['cognome'], PDO::PARAM_STR);
    $stmt->bindParam(':indirizzo', $utente['indirizzo'], PDO::PARAM_STR);
    $stmt->bindParam(':citta', $utente['citta'], PDO::PARAM_STR);
    $stmt->bindParam(':cap', $utente['cap'], PDO::PARAM_STR);
    $stmt->bindParam(':provincia', $utente['provincia'], PDO::PARAM_STR);

    $date = date('Y-m-d H:i:s');
    $stmt->bindParam(':data', $date);

    $stmt->execute();

    $idOrdine = $db->lastInsertId('ordini_id_seq');

    // inserimento in tabella ordiniprodottivarianti
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

        $stmt = $db->prepare("INSERT INTO ordiniprodottivarianti (ordine_id, prodotto_id, variante_id, prezzo, quantita, descrizione)
                                  VALUES (:ordine_id, :prodotto_id, :variante_id, :prezzo, 1, :descrizione)");

        $stmt->bindParam(':ordine_id', $idOrdine, PDO::PARAM_INT);
        $stmt->bindParam(':prodotto_id', $rigaCarrello['prodotto'], PDO::PARAM_INT);
        $stmt->bindParam(':variante_id', $rigaCarrello['variante'], PDO::PARAM_INT);
        $stmt->bindParam(':prezzo', $prezzo);
        $stmt->bindParam(':descrizione', $descrizione, PDO::PARAM_STR);

        $stmt->execute();

    }

    $db->commit();

    // svuotamento variabili di sessione
    unset($_SESSION['utente']);
    unset($_SESSION['carrello']);

    // rimando a pagina carrello
    header ('location: grazie.php');

} catch (Exception $e) {
    $db->rollBack();
    echo "Si è verificato un errore: " . $e->getMessage();
}

