$('#buscar').on('submit', function(e){
    e.preventDefault();
    var tipo = $('#tipo').val();
    var dato = $('#dato').val();

    window.location.replace("gimnastas" + "?" + "tipo=" + tipo + "&dato=" + dato);

});
