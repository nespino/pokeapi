<?php

namespace PokePHP;

require 'class.db.php';
use Db;

class PokeApi
{
    public function __construct()
    {
        $this->baseUrl = 'https://pokeapi.co/api/v2/';
    }

    # TODO: Implement language settings
    public function language($lookUp)
    {
        $url = $this->baseUrl.'language/'.$lookUp;

        return json_decode($this->sendRequest($url));
    }

    public function name($lookUp)
    {
        $url = $this->baseUrl.'pokemon/'.$lookUp;

        return json_decode($this->sendRequest($url));
    }

    public function searchByName($name) {
        $result = '';
        if (strlen($name) > 0) {
            $template = file_get_contents('pokemon.tpl.php');
            $db = new Db();
            $pokemons = $db->query("SELECT name FROM pokemons WHERE LOWER(name) LIKE LOWER('%" . $name . "%');")->fetchAll();
            foreach ($pokemons as $pokemon) {
                $result .= str_replace('{{pokemonName}}', $pokemon['name'], $template);
            }
        }
        return $result;
    }

    public function updateNames()
    {
        $db = new Db();
        $db->query('DROP TABLE IF EXISTS pokemons');
        $db->query('CREATE TABLE pokemons (id INT NOT NULL, name VARCHAR(100))');
        // As required by pokeapi.co, use offset and limit
        $limit = 60;
        $offset = 0;
        $request = $this->name('');
        $count = $request->count;

        while ($count > $offset) {
            $request = $this->name('?offset=' . $offset . '&limit=' . $limit);
            foreach ($request->results as $pokemon) {
                $pokeId = str_replace(array('https://pokeapi.co/api/v2/pokemon/','/'), array('',''), $pokemon->url);
                $db->query("INSERT INTO pokemons VALUES (" . $pokeId . ", '" . $pokemon->name . "')");
            }
            $offset += $limit;
        }

        echo 'Pokemons name update finished succesfully.';
    }
    /**
     * @param string $url
     */
    public function sendRequest($url)
    {
        $ch = curl_init();

        $timeout = 5;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($http_code != 200) {
            // return http code and error message
            return json_encode([
                'code'    => $http_code,
                'message' => $data,
            ]);
        }

        return $data;
    }
}
