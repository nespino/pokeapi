$(document).ready(function() {
    // TODO: It could be onchange instead of clicking a button/enter
    $('#buscar-pokemon').click(function() {
        searchPokemon();
    });

    $('#nombre-pokemon').keyup(function(e){
        if(e.keyCode == 13)
        {
            searchPokemon();
        }
    });

    function searchPokemon() {
        $.ajax({
            url : '?name=' + $('#nombre-pokemon').val(),
            type : 'GET',
            success : function(data) {
                $('#results-container').html(data);
            },
            error : function(request, error) {
                alert("Error: No se pudo conseguir el listado.");
            }
        });
    }
});