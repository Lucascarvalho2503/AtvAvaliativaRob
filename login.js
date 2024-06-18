function doLogin() {
    let usuario = $('#exampleInputEmail').val();
    let senha = $('#exampleInputPassword').val();
    let dados = {
        email: usuario, // Certifique-se de que a chave aqui corresponde ao name do campo no formulário
        password: senha // Certifique-se de que a chave aqui corresponde ao name do campo no formulário
    };

    $.ajax({
        url: 'validaLogin.php',
        type: 'POST',
        data: dados,
        success: function (response) {
            console.log(response); // Adicione isto para depuração
            let json = JSON.parse(response);
            let msg = json.msg;
            if (json.status == 1) {
                window.location.href = 'index.php'; // Corrigido para redirecionar para index.php
            } else {
                $('#msg').html(msg);
            }
        },
        error: function (xhr, status, error) {
            console.error('Erro na solicitação AJAX:', status, error);
            $('#msg').html('Erro na solicitação AJAX: ' + status + ', ' + error);
        }
    });
}
