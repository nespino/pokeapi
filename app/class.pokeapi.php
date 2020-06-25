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

    public function getPokemons() {
        // As required by pokeapi.co, use offset and limit
        $limit = 60;
        $offset = 0;
        $request = $this->name('');
        $count = $request->count;
        $pokemons = array();
        while ($count > $offset) {
            $request = $this->name('?offset=' . $offset . '&limit=' . $limit);
            foreach ($request->results as $pokemon) {
                $pokeId = str_replace(array('https://pokeapi.co/api/v2/pokemon/','/'), array('',''), $pokemon->url);
                $pokemons[$pokeId] = $pokemon->name;
            }
            $offset += $limit;
        }
        die(json_encode(array('responseJSON' => $pokemons)));
    }

    public function searchPokemons($pokemons, $string) {
        $pokemons = json_decode($pokemons);

        die(json_encode(array('responseJSON' => $pokemons)));
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
