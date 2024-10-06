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
                if (erro == false) {
                    exibirFeedback("P", "E-mail de recuperação enviado! Verifique a caixa de SPAM");
                } else if (erro[1] == 1) {
                    exibirFeedback("N", "É necessário atualizar a página com F5 para continuar!");
                } else {
                    exibirFeedback("N", "E-mail informado não cadastrado!");
                }
            },
            error: data => $("#modal-erro").modal("show")
        });
    });
});