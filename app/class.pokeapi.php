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
    /**
     * @param string $lang
     */
    public function language($lang) {
        $url = $this->baseUrl.'language/'.$lang;

        return json_decode($this->sendRequest($url));
    }

    /**
     * @param string $lookUp - Can be exact name or id
     */
    public function name($lookUp) {
        $url = $this->baseUrl.'pokemon/'.$lookUp;

        return json_decode($this->sendRequest($url));
    }

    /**
     * @param string $name
     */
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

    public function updateNames($silent) {
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
        if (!$silent) {
            echo 'Pokemons name update finished succesfully.';
        }
    }


    public function checkUpdate($silent) {
        $db = new Db();
        $result = $db->query("SELECT COUNT(*) AS count FROM information_schema.tables WHERE table_name = 'pokeapi_config' LIMIT 1")->fetchAll();
        if (!$result[0]['count']) {
            $db->query("CREATE TABLE pokeapi_config (id INT NOT NULL, config_key VARCHAR(50), config_value VARCHAR(255));");
        }
        $lastUpdate = $db->query("SELECT config_value FROM pokeapi_config WHERE config_key = 'last_update' LIMIT 1")->fetchAll();
        if (!isset($lastUpdate[0]) || $lastUpdate[0]['config_value'] < date("Y-m-d", strtotime("-1 week"))) {
            $this->updateNames($silent);
            if (!isset($lastUpdate[0])) {
                $db->query("INSERT INTO pokeapi_config (config_key, config_value) VALUES ('last_update', NOW());");
            } else {
                $db->query("UPDATE pokeapi_config SET config_value = NOW() WHERE config_key = 'last_update'");
            }
        }
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
