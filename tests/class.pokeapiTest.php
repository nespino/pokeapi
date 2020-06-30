<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require ("../app/class.pokeapi.php");

final class PokeApiTest extends TestCase
{
    public function testSearchPokemons() {
        $pokemons = '{"1":"bulbasaur","2":"ivysaur","3":"venusaur","4":"charmander","5":"charmeleon","6":"charizard","7":"squirtle","8":"wartortle","9":"blastoise"}';
        $string = 'as';
        $this->assertEquals(
            PokePHP\PokeApi::searchPokemons($pokemons, $string),
            '{"responseJSON":{"1":"bulbasaur","9":"blastoise"}}'
        );
    }

    public function testGetPokemons() {
        $sendRequestMockValue = new stdClass();
        $sendRequestMockValue->count = 9;
        $sendRequestMockValue->next = null;
        $sendRequestMockValue->previous = null;
        $sendRequestMockValue->results = array(
            0 => array('name' => 'bulbasaur', 'url' => 'https://pokeapi.co/api/v2/pokemon/1/'),
            1 => array('name' => 'ivysaur', 'url' => 'https://pokeapi.co/api/v2/pokemon/2/'),
            2 => array('name' => 'venusaur', 'url' => 'https://pokeapi.co/api/v2/pokemon/3/'),
            3 => array('name' => 'charmander', 'url' => 'https://pokeapi.co/api/v2/pokemon/4/'),
            4 => array('name' => 'charmeleon', 'url' => 'https://pokeapi.co/api/v2/pokemon/5/'),
            5 => array('name' => 'charizard', 'url' => 'https://pokeapi.co/api/v2/pokemon/6/'),
            6 => array('name' => 'squirtle', 'url' => 'https://pokeapi.co/api/v2/pokemon/7/'),
            7 => array('name' => 'wartortle', 'url' => 'https://pokeapi.co/api/v2/pokemon/8/'),
            8 => array('name' => 'blastoise', 'url' => 'https://pokeapi.co/api/v2/pokemon/9/'));

        $sendRequestMockedObject = $this->getMockBuilder('PokePHP\PokeAPI')
            ->setMethods(array('sendRequest'))
            ->getMock();

        $sendRequestMockedObject->method('sendRequest')
            ->will($this->returnValue(json_encode($sendRequestMockValue)));

        $result = $sendRequestMockedObject->getPokemons();

        $this->assertEquals(
            $result,
            '{"responseJSON":{"1":"bulbasaur","2":"ivysaur","3":"venusaur","4":"charmander","5":"charmeleon","6":"charizard","7":"squirtle","8":"wartortle","9":"blastoise"}}'
        );
    }

}
