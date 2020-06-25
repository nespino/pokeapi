<?php

namespace PokePHP;

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

        return $this->sendRequest($url);
    }

    public function name($lookUp)
    {
        $url = $this->baseUrl.'pokemon/'.$lookUp;

        return $this->sendRequest($url);
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
