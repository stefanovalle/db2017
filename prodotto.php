<?php
include 'libs/db.php';

$db = creaConnessionePDO();

// lettura parametro da URL
$id = $_GET['id'];

// Sostituire <QUERY> con la query SQL corretta
// specificare :id in corrispondenza del valore dell'id prodotto
$stmt = $db->prepare('<QUERY>');

// bind parametro alla query
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$prodotto = $stmt->fetch(PDO::FETCH_ASSOC);

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
          <h1><?= $prodotto['nome'] ?></h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <h3><?= $prodotto['descrizione'] ?></h3>
          <div>
            <strong>Prezzo</strong>: <?= $prodotto['prezzo'] ?>
          </div>
          <br>
          <div>
            <a href="#" class="btn btn-success">Acquista</a>
          </div>
        </div>
      </div>
    </main>
    <?php include 'include/footer.php'; ?>
  </body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="/js/bootstrap.min.js"></script>
</html>
