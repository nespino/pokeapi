$(document).ready(function() {
    // TODO: It could be onchange instead of clicking a button/enter
    $('#buscar-pokemon').click(function() {
        searchPokemons();
    });

    $('#nombre-pokemon').keyup(function(e){
        if (e.keyCode == 13) {
            searchPokemons();
        }
    });

    var getPokemonsUrl = 'app.php?getPokemons';

    // Method to get the size of an object
    Object.size = function(obj) {
        var size = 0, key;
        for (key in obj) {
            if (obj.hasOwnProperty(key)) size++;
        }
        return size;
    };

    function searchPokemons() {
        $('#results-title').show();
        searchString = $('#nombre-pokemon').val();
        if (!searchString) {
            $('#results-container').html('');
            $('#no-results').show();
            return;
        }
        var pokemons = localStorage.getItem(getPokemonsUrl);
        $.ajax({
            url : 'app.php?searchPokemons',
            type : 'POST',
            data: {
                pokemons: pokemons,
                searchString: searchString
            },
            dataType: "json",
            success : function(data) {
                $('#results-container').html('');
                if (Object.size(data['responseJSON'])) {
                    $('#no-results').hide();
                    Object.entries(data['responseJSON']).forEach(([pokeId, pokemon]) => {
                        $('#results-container').append($('#pokemon-template').html().replace(new RegExp('{{pokemonName}}', 'g'), pokemon)
                            .replace(new RegExp('{{pokemonId}}', 'g'), pokeId));
                    });
                } else {
                    $('#no-results').show();
                    $('#results-container').html('');
                }
            },
            error : function(request, error) {
                alert("Error: No se pudo conseguir el listado.");
            }
        });
    }

    // Use local cache as requested by pokeapi.co Rules
    $.ajaxPrefilter(function (options, originalOptions, jqXHR) {
        if (options.cache) {
            var success = originalOptions.success || $.noop,
                url = originalOptions.url;

            options.cache = false; //remove jQuery cache as we have our own localStorage
            options.beforeSend = function () {
                if (localStorage.getItem(url)) {
                    success(localStorage.getItem(url));
                    return false;
                }
                return true;
            };
            options.success = function (data, textStatus) {
                var responseData = JSON.stringify(data.responseJSON);
                localStorage.setItem(url, responseData);
                if ($.isFunction(success)) success(data.responseJSON); //call back to original ajax call
            };
        }
    });

    today = $.now();
    lastUpdate = localStorage.getItem('last_update');
    if (!lastUpdate || lastUpdate < (today - 7 * 24 * 60 * 60 * 1000)) {
        localStorage.removeItem(getPokemonsUrl);
        $.ajax({
            url : getPokemonsUrl,
            type : 'GET',
            cache: true,
            dataType: "json",
            success : function(data) {
                localStorage.setItem('last_update', today);
                searchPokemon();
            },
            error : function(request, error) {
                alert("Error: No se pudo conseguir el listado.");
            }
        });
    }

    $('#nombre-pokemon').val('').focus();
});