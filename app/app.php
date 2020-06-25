<?php
require 'class.pokeapi.php';
$pokeApi = new PokePHP\PokeApi();

if (isset($_GET['getPokemons'])) {
    $pokeApi->getPokemons();
} else if (isset($_GET['searchPokemons'])) {
    $pokeApi->searchPokemons($_POST['pokemons'], $_POST['searchString']);
} else {
    header('X-PHP-Response-Code: 400', true, 400);
    echo '400: Bad request';
} ?>
