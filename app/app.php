<?php
require 'class.pokeapi.php';
$pokeApi = new PokePHP\PokeApi();

if (isset($_GET['getPokemons'])) {
    $response = $pokeApi->getPokemons();
} else if (isset($_GET['searchPokemons'])) {
    $response = $pokeApi->searchPokemons($_POST['pokemons'], $_POST['searchString']);
} else {
    header('X-PHP-Response-Code: 400', true, 400);
    $response = '400: Bad request';
}

echo $response;

?>
