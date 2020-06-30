<html>

<head>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="57x57" href="img/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="img/favicon//apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/favicon//apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="img/favicon//apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/favicon//apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="img/favicon//apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="img/favicon//apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="img/favicon//apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon//apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="img/favicon//android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon//favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="img/favicon//favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon//favicon-16x16.png">
    <link rel="manifest" href="img/favicon//manifest.json">
    <meta name="msapplication-TileColor" content="#ffff22">
    <meta name="msapplication-TileImage" content="img/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffff22">
</head>

<body>
    <div class="container content">
        <div class="col-10 mx-auto">
            <div class="row">
                <h1>
                    Pokemon finder
                </h1>
            </div>
            <div class="row">
                <h3 class="subtitle">
                    El que quiere Pokemons, que los busque.
                </h3>
            </div>

            <div class="row mt-1">
                <input type="text" id="nombre-pokemon" placeholder="Ingrese el nombre a buscar"><button type="button" id="buscar-pokemon" class="btn btn-primary">Buscar</button>
            </div>

            <div id="results-title" class="row mt-3 ml-1">
                <h2>
                    Resultados de la búsqueda
                </h2>
            </div>

            <div id="wait-for-local-storage" class="row mt-3 ml-1">
                <h3>
                    Estamos preparando la base de datos de Pokemons!<br /> Por favor, aguarde...
                </h3>
            </div>

            <div id="no-results" class="row ml-4 mt-2">
                No se encontraron pokemons.
            </div>

            <div id="results-container" class="row">

            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <hr />
                    <span class="made-by">Desafío hecho para <a href="https://www.ixpandit.com/" target="_blank"><img src="img/ixpandit.png" alt="ixpandit"></a></span>
                    <a href="https://github.com/nespino/pokeapi" target="_blank"><img class="github mr-3" src="img/github.png" /></a>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <span>Copyleft - Nahuel Espiño </span>
    </footer>

    <div id="pokemon-template">
        <div class="row mt-5 ml-2 col-12">
            <div class="col-3">
                <a href="https://pokeapi.co/api/v2/pokemon/{{pokemonId}}" target="_blank" title="{{pokemonName}}">
                    <img src="img/no-image.png">
                </a>
            </div>
            <div class="col-3 pt-3">
                <a href="https://pokeapi.co/api/v2/pokemon/{{pokemonId}}" target="_blank" title="{{pokemonName}}">
                    <span class="pokemon-name">
                        {{pokemonName}}
                    </span>
                </a>
            </div>
            <div class="col-6"></div>
        </div>
    </div>
</body>

</html>

