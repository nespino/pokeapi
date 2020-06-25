$(document).ready(function() {
    // TODO: It could be onchange instead of clicking a button
    $('#buscar-pokemon').click(function() {
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
    });
});