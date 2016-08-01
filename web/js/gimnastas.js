$('#buscar').on('submit', function(e){
    e.preventDefault();
    var tipo = $('#tipo').val();
    var dato = $('#dato').val();

    window.location.replace("gimnastas" + "?" + "tipo=" + tipo + "&dato=" + dato);

});

$('#newGim').on('submit', function(e){
    e.preventDefault();
    var nombre = $('#name').val();
    var email  = $('#email').val();
    var dni    = $('#dni').val();

    $.post("agregar",
        {
            name : nombre,
            email: email,
            dni  : dni
        },

        function(data, status){
            alert("El usuario " + nombre + " ha sido creado")
        });
});

$('#editGim').on('submit', function(e){
    e.preventDefault();
    var nombre = $('#name').val();
    var email  = $('#email').val();
    var dni    = $('#dni').val();
    var id     = $('#numero').val();
    $.post( id,
        {
            name : nombre,
            email: email,
            dni  : dni,
            id   : id
        },

        function(data, status){
            alert("El usuario " + nombre + " ha sido modificado")
        });
});