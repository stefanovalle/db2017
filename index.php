<?php
include 'libs/db.php';

// inizializza la connessione al database
$db = creaConnessionePDO();

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Corso DB SQL</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
  </head>
  <body>
    <?php include 'include/header.php'; ?>
    <main>
      <div class="container-fluid">
        <div class="row banner-home">
          <div class="col-md-6">
            <img src="/img/store.jpg">
          </div>
          <div class="col-md-6">
            <?php

            // esegue la query SQL
            $stmt = $db->prepare('SELECT * FROM prodotti ORDER BY nome LIMIT 12');
            $stmt->execute();

            // recupera la lista dei prodotti
            $prodotti = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // per ciascun prodotto...
            foreach($prodotti as $prodotto) {
              ?>
              <div class="col-md-4">
                <div class="panel panel-default">
                  <div class="panel-heading"><a href="/prodotto.php?id=<?=$prodotto['id'] ?>"><?= $prodotto['nome'] ?></a></div>
                  <div class="panel-body">
                    <?= $prodotto['prezzo'] ?> &euro;
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </main>
    <?php include 'include/footer.php'; ?>
  </body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="/js/bootstrap.min.js"></script>
</html>
