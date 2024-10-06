function exibirFeedback(tipo, mensagem) {
    $(".alert-feedback").text(mensagem);
    tipo === "P" ? $(".alert-feedback").removeClass("alert-warning").addClass("alert alert-success") : $(".alert-feedback").removeClass("alert-success").addClass("alert alert-warning");
    $(".alert-feedback").fadeTo(3000, 500).slideUp(500);
}

function exibirFeedbackTabela(tipo, linha, mensagem) {
    linha.find(".alert-feedback").text(mensagem);
    tipo === "P" ? linha.find(".alert-feedback").removeClass("alert-warning").addClass("alert alert-success") : linha.find(".alert-feedback").removeClass("alert alert-success").addClass("alert-warning");
    linha.find(".alert-feedback").fadeTo(3000, 500).slideUp(500);
}