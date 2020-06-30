# pokeapi
Demo app to consume PokeAPI

# Mockup
https://gomockingbird.com/projects/a1rlu7d/4gXVnC

# Challenge
La solución debe cumplir los siguientes requisitos:

- Utilizar para la solución un lenguaje orientado a objetos (Php, Java o similar) y testeo automático de la lógica (Phpunit, JUnit).
- El diseño a libre elección, con la posibilidad de usar algún framework.
- Consultar la data vía PokeApi (https://pokeapi.co/) desde el servidor (HTML -> APP -> API).
- Como mínimo se tiene que poder buscar Pokemones por nombre parcial. 

# Prerequisites:

- Docker Compose

# How to setup

- Clone the repository
- Run docker-compose up -d in the cloned folder (it should auto-build the image and get the container up)
- Open your browser at http://localhost:8000

# How to run tests

- Run docker-compose exec app phpunit

# Development notes

- Fue un desafío cumplir con el esquema de requests, dado que la pokeapi.co no ofrece búsquedas parciales, y a la vez, define en las reglas de uso que las requests deben ser cacheadas localmente.
- En commits anteriores hay una versión que guarda los resultados en mysql. Ese diseño fue descartado para intentar acercarse a que la request hacia pokeapi.co naciera de una request desde el cliente.
