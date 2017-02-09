<?php

function creaConnessionePDO() {
    $db = new PDO('pgsql:host=localhost;port=5432;dbname=ecommerce', 'ecommerce', 'ecommerce');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
}