$(document).ready(function () {

    email_atual = "";

    carregarPainel(0); //Painel default
    configurarEventos();

    $("#container-painel-ul").on("click", "li a", function (event) {
        event.preventDefault();
        const $this = $(this);
        $("#container-painel-ul li a").removeClass("active");
        $this.addClass("active");
        const opcao = $this.parent().index();
        carregarPainel(opcao);
    });
});

function configurarEventos() {

    $(document).on("change", "#imagem", function () {
        const tamanho = this.files[0]?.size;
        if (tamanho < 2 * (1024 * 1024)) { //Imagem menor que 2MB
            $("#imagem")[0].setCustomValidity("");
            const reader = new FileReader();
            reader.onload = function (e) {
                $("#imagem-previa").attr("src", e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        } else {
            $("#imagem")[0].setCustomValidity("Imagem maior que 2 MB!");
        }
    });

    $(document).on("change", "#email", function () {
        verificarDisponibilidadeEmail();
    });

    $(document).on("input", "#senha1, #senha2", validarSenhas);

    $(document).on("submit", "#form-dados-gerais", function (event) {
        event.preventDefault();
        atualizarPessoa();
    });

    $(document).on("submit", "#form-email", function (event) {
        event.preventDefault();
        atualizarEmail();
    });

    $(document).on("submit", "#form-seguranca", function (event) {
        event.preventDefault();
        atualizarSenha();
    });

}

function carregarPainel(opcao) {
    const paginas = [
        {
            url: "atualizar-cadastro-dados-gerais.html",
            funcs: [carregarPessoa, configurarDatepicker]
        },
        { url: "atualizar-cadastro-email.html" },
        { url: "atualizar-cadastro-seguranca.html" }
    ];
    $("#container-painel-dados").load(paginas[opcao].url, function () {
        paginas[opcao].funcs.forEach(func => func());
    });
}

function configurarDatepicker() {
    const anoAtual = new Date().getFullYear();
    const datepickerParams = {
        dateFormat: "dd/mm/yy",
        changeMonth: true,
        changeYear: true,
        yearRange: "1900:" + anoAtual,
        minDate: new Date(1900, 0, 1),
        maxDate: 0,
        dayNames: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado", "Domingo"],
        dayNamesMin: ["D", "S", "T", "Q", "Q", "S", "S", "D"],
        dayNamesShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb", "Dom"],
        monthNames: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
        monthNamesShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"]
    };
    $("#data-nascimento").datepicker(datepickerParams);
}

function carregarPessoa() {
    $.ajax({
        dataType: "json",
        type: "GET",
        url: "crud",
        data: {
            opcao: "s5"
        },
        success: function (data) {
            $("#cpf").val(data["cpf"]);
            $("#cpf").mask("000.000.000-00");
            email_atual = data["email"];
            $("#nome").val(data["nome"]);
            $("#data-nascimento").mask("00/00/0000").val(moment(data["data_nascimento"]).format("DD/MM/YYYY"));
            switch (data["sexo"]) {
                case "M":
                    $("#sexo-masculino").prop("checked", true);
                    break;
                case "F":
                    $("#sexo-feminino").prop("checked", true);
                    break;
                case "O":
                    $("#sexo-outro").prop("checked", true);
                    break;
            }
            if (data["imagem"] != "") {
                $("#imagem-previa").attr("src", data["imagem"]);
            }
        },
        error: data => $("#modal-erro").modal("show")
    });
}

function verificarDisponibilidadeEmail() {
    const email = $("#email").val();
    if (email_atual == email) {
        $("#email")[0].setCustomValidity("E-mail novo é igual ao atual.");
        return;
    }
    $.ajax({
        dataType: "json",
        url: "crud",
        data: {
            opcao: "s3",
            email: email
        },
        success: function (emailDisponivel) {
            $("#email")[0].setCustomValidity(emailDisponivel ? "" : "E-mail já cadastrado.");
        },
        error: data => $("#modal-erro").modal("show")
    });
}

function validarSenhas() {
    const senha1 = $("#senha1").val();
    const senha2 = $("#senha2").val();
    return $("#senha2")[0].setCustomValidity(senha1 !== senha2 ? "Senha diferente da anterior ou em branco." : "");
}

function atualizarPessoa() {
    const form = $("#form-dados-gerais");
    const formData = new FormData(form[0]);
    $.ajax({
        dataType: "json",
        type: "POST",
        url: "crud",
        processData: false,
        contentType: false,
        data: formData,
        success: function (erro) {
            erro ? exibirFeedback("N", "Erro! Verifique os campos novamente") : exibirFeedback("P", "Dados atualizados!");
        },
        complete: function () {
            setTimeout(() => window.location.reload, 3000);
        },
        error: data => $("#modal-erro").modal("show")
    });
}

function atualizarEmail() {
    $.when(verificarDisponibilidadeEmail()).done(function () {
        const form = $("#form-email");
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
                    email_atual = $("#email").val();
                    exibirFeedback("P", "E-mail alterado!");
                } else {
                    exibirFeedback("N", "Erro! Verifique os campos novamente");
                }
            },
            error: data => $("#modal-erro").modal("show")
        });
    });
}

function atualizarSenha() {
    const form = $("#form-seguranca");
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
                exibirFeedback("P", "Senha alterada!");
            } else if (erro[1] == 1) {
                exibirFeedback("N", "Senha inválida informada mais de 5 vezes. Tente novamente mais tarde!");
            } else {
                exibirFeedback("N", "Erro! Senha atual incorreta.");
            }
        },
        error: data => $("#modal-erro").modal("show")
    });
}