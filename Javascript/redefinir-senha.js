$(document).ready(function () {

    $("#senha1, #senha2").on("input", validarSenhas);

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
                erro ? exibirFeedback("N","Erro! Verifique os campos novamente") : exibirFeedback("P","Senha alterada com sucesso!");
                setTimeout(() => window.location.href = "index", 3000);
            },
            error: data => $("#modal-erro").modal("show")
        });
    });
});

function validarSenhas() {
    const senha1 = $("#senha1").val();
    const senha2 = $("#senha2").val();
    return $("#senha2")[0].setCustomValidity(senha1 !== senha2 || senha1.length === 0 ? "Senha diferente da anterior ou em branco" : "");
}