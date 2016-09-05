
$('#newHorario').on('submit', function(e){
    e.preventDefault();

    $.post("new",
        {
            horario : $('#horario').val(),
            lunes: $('#lunes').val(),
            martes  : $('#martes').val(),
            miercoles : $('#miercoles').val(),
            jueves : $('#jueves').val(),
            viernes : $('#viernes').val(),
            sabado : $('#sabado').val()
        },
        function(data, status){
            location.href = "create"
        });
});

$('#editarHorario').on('submit', function(e){
    e.preventDefault();
    var nombre = $('#name').val();
    var email  = $('#email').val();
    var dni    = $('#dni').val();
    var id     = $('#numero').val();
    var fechadePago   = $('#payDate').val();
    var fechadeIngreso   = $('#beginDate').val();
    $.post( id,
        {
            horario : $('#horario').val(),
            lunes: $('#lunes').val(),
            martes  : $('#martes').val(),
            miercoles : $('#miercoles').val(),
            jueves : $('#jueves').val(),
            viernes : $('#viernes').val(),
            sabado : $('#sabado').val()
        },

        function(data, status){
            location.href = ""
        });
});/**
 * Created by marti on 4/9/2016.
 */
