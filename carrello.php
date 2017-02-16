<?php

// inizializziamo le sessioni
session_start();

include 'libs/db.php';

$db = creaConnessionePDO();

// recuperiamo i dati del carrello dalla sessione
$carrello = $_SESSION['carrello'];

?>
<!DOCTYPE html>
<html>
  <head>
    <title>MV chocosite</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
  </head>
  <body>
    <?php include 'include/header.php'; ?>
    <main>
      <div class="row">
        <div class="col-md-12">
          <h1>Carrello acquisti</h1>
          <a href="svuota_carrello.php">Svuota carrello</a>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <?php
          if (count($carrello) > 0) { ?>
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Prodotto</th>
                <th>Quantità</th>
                <th>Prezzo unitario</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $totaleCarrello = 0;
              foreach($carrello as $rigaCarrello) {

                $stmt = $db->prepare('<QUERY SQL>');

                // bind parametro alla query
                $stmt->bindParam(':idProdotto', $rigaCarrello['prodotto'], PDO::PARAM_INT);
                $stmt->bindParam(':idVariante', $rigaCarrello['variante'], PDO::PARAM_INT);
                $stmt->execute();

                $risultato = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // mi aspetto solo 1 riga come risultato
                $valori = $risultato[0];

                $prezzo = $valori['prezzo'] + $valori['prezzo_variante'];

              ?>
              <tr>
                <td><?= $valori['nome'] ?><br />
                  <small><?= $valori['nome_variante'] ?></small></td>
                <td>1</td>
                <td><?= $valori['prezzo'] ?> &euro;</td>
                <td><a href="" class="btn btn-link">rimuovi</a></td>
              </tr>
              <?php
                $totaleCarrello += $prezzo;
              }
              ?>
              <tr class="success" style="font-weight: bold">
                <th scope="row"></th>
                <td>Totale</td>
                <td></td>
                <td><?=$totaleCarrello?> &euro;</td>
                <td></td>
              </tr>
            </tbody>
          </table>
          <?php } else { ?>
            Nessun prodotto presente nel carrello
          <?php } ?>
        </div>
      </div>
      <?php if (count($carrello) > 0) { ?>
      <div class="row">
        <div class="col-md-8">
        </div>
        <div class="col-md-4">
          <a href="iscrizione.php" class="btn btn-success btn-lg">Procedi con l'acquisto</a>
        </div>
      </div>
      <?php } ?>
    </main>
    <?php include 'include/footer.php'; ?>
  </body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="/js/bootstrap.min.js"></script>
</html>
