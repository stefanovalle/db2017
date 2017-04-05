<?php
use PHPOnCouch\Couch,
    PHPOnCouch\CouchAdmin,
    PHPOnCouch\CouchClient;

function creaConnessioneCouchDB() {
  return new CouchClient('http://127.0.0.1:5984', 'ordini');
}
