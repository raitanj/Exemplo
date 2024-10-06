const feedbackLogin = {
    1: "Erro! Verifique os campos novamente",
    2: "E-mail ou senha inválida informados mais de 5 vezes. Tente novamente mais tarde!",
    3: "Senha inválida para o e-mail informado",
    4: "E-mail não cadastrado",
};

$(document).ready(function () {
    $("#form").on("submit", function (event) {
        event.preventDefault();
        const form = $("#form");
        const formData = new FormData(form[0]);
        $.ajax({
            dataType: "json",
            type: "POST",
            url: "crud",
            processData: false,
            contentType: false,
            data: formData,
            success: function (erro) {
                erro[0] === true ? exibirFeedback("N", feedbackLogin[erro[1]]) : window.location.href = "pagina";
            },
            error: data => $("#modal-erro").modal("show")
        });
    });
});