<?php
use Predis\Client;

function creaConnessioneRedis() {
  return new Client();  // per default assume redis accessibile su 127.0.0.1 e porta standard (6379)
}
