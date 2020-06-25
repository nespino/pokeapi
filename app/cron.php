<?php

require 'class.pokeapi.php';
use PokePHP\PokeApi;

$pokeApi = new PokeApi();

echo $pokeApi->updateNames();

?>