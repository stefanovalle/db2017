#!/usr/bin/php
<?php
include 'libs/db.php';
try {
  $db = creaConnessionePDO();

  // categorie
  $categorie = [
      1 => 'Sport',
      2 => 'Fotografia',
      3 => 'Viaggi',
      4 => 'Giardinaggio',
      5 => 'Utensili',
      6 => 'Cancelleria',
      7 => 'Informatica'
  ];

  // varianti prodotti
  $varianti = [
      1 => 'Nero',
      2 => 'Rosso',
      3 => 'Blue',
      4 => 'Giallo',
      5 => 'Verde',
      6 => 'Mimetico',
      7 => 'Argento',
      8 => 'Pelle',
      9 => 'Bianco'
  ];

  $namebase = array('pingo', 'pongo', 'bum', 'bam', 'foo',
      'baz', 'bar', 'pogo', 'dogo', 'sole',
      'luna', 'volo', 'air', 'fire', 'tee');

  $prodottovariante = 0;

  $db->beginTransaction();

  for ($x = 0; $x < 10000; $x++) {
    $categoria = rand(1, (count($categorie)));
    $prezzo = rand(1, 200) * 10;
    $venduti = rand(0, 5000);
    $dataarrivo = '2015-02-20 '.rand(1,23).':'.rand(0,59);
    $nome = $namebase[rand(0, count($namebase) - 1)].$namebase[rand(0, count($namebase) - 1)];
    if (rand(0,1) == 1) {
      $nome .= " " . $namebase[rand(0, count($namebase) - 1)];
    }
    $db->exec("INSERT INTO prodotti (nome, prezzo, visite, data_arrivo, categoria_id) VALUES ('".
        $nome ."',".$prezzo.",".$venduti.",'".$dataarrivo."',".$categoria.")");
    $idProd = $db->lastInsertId('prodotti_id_seq');
    echo "Prodotto ".$nome." creato\n";
    $db->exec("INSERT INTO prodottivarianti (prodotto_id, variante_id) VALUES (".$idProd.",".rand(1,5).")");
    $db->exec("INSERT INTO prodottivarianti (prodotto_id, variante_id) VALUES (".$idProd.",".rand(6,9).")");
    echo "Varianti Prodotto ".$nome." create\n";
  }
  $db->commit();
}
catch(PDOException $e) {
  echo 'Ahia! '.$e->getMessage()."\n";
}