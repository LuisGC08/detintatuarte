$(document).ready(function (e) {

    $('#buttonLogin').on('click', function () {
        var nick = $('#nick').val();
        var password = $('#password').val();
        if (validarUsuario(nick, password)) {
            $.ajax({
                url: 'index.php?controller=login&action=comprobarUsuario',
                method: 'POST',
                dataType: 'JSON',
                data: {
                    nick: nick,
                    password: password
                },
                cache: false
            })
                .done(function (dataResult) {
                    if (dataResult.success == false) {
                        $("#mensaje").addClass('alert alert-danger');
                        $("#mensaje p").html(dataResult.data.mensaje);
                    }  else {
                        window.location.replace('index.php?controller=login&action=home');
                    }
                })
                .fail(function (jqXHR) {
                    $("#mensaje").addClass('alert alert-danger');
                    $("#mensaje p").html("Error: Numero " + jqXHR.status.toString());
                });
        } else {
            $("#mensaje").addClass('alert alert-danger');
            $("#mensaje p").html("Por favor rellene todos los campos");
        }

    });
});

function validarUsuario(nick, password) {
    if (nick.trim() != "" && password.trim() != "") {
        return true;
    } else {
        return false;
    }
}