$(document).ready(function () {
    $("#cpf").mask("000.000.000-00");
    $("#data-nascimento").mask("00/00/0000").val(moment(dataSelecionada).format("DD/MM/YYYY"));
    carregarCargos();
    configurarEventos();
});

function configurarEventos() {

    $("#imagem").change(function () {
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

    $("#senha1, #senha2").on("input", validarSenhas);

    $("#cpf").change(function () {
        verificarDisponibilidadeCPF();
    });

    $("#siape").change(function () {
        verificarDisponibilidadeSiape();
    });

    $("#email").change(function () {
        verificarDisponibilidadeEmail();
    });

    $("#form").on("submit", function (event) {
        event.preventDefault();
        cadastrarPessoa();
    });
}

function carregarCargos() {
    $.ajax({
        dataType: "json",
        type: "GET",
        url: "crud",
        data: { opcao: "s6" },
        success: function (data) {
            $("#cargo").append(data);
        },
        error: data => $("#modal-erro").modal("show")
    });
}

function verificarDisponibilidadeCPF() {
    const cpf = $("#cpf").val();

    if (!verificarCPF()) {
        return;
    }

    $.ajax({
        dataType: "json",
        type: "GET",
        url: "crud",
        data: {
            opcao: "s4",
            cpf: cpf
        },
        success: function (cpfDisponivel) {
            $("#cpf")[0].setCustomValidity(cpfDisponivel ? "" : "CPF já cadastrado.");
        },
        error: data => $("#modal-erro").modal("show")
    });
}

function verificarDisponibilidadeSiape() {
    const siape = $("#siape").val();

    if (siape.length != 7) {
        $("#siape")[0].setCustomValidity("Siape precisa ter 7 dígitos.");
        return;
    } else {
        $("#siape")[0].setCustomValidity("");
    }

    $.ajax({
        dataType: "json",
        type: "GET",
        url: "crud",
        data: {
            opcao: "s4",
            siape: siape
        },
        success: function (siapeDisponivel) {
            $("#siape")[0].setCustomValidity(siapeDisponivel ? "" : "Siape já cadastrado.");
        },
        error: data => $("#modal-erro").modal("show")
    });
}

function verificarDisponibilidadeEmail() {
    $.ajax({
        dataType: "json",
        type: "GET",
        url: "crud",
        data: {
            opcao: "s3",
            email: $("#email").val()
        },
        success: function (emailDisponivel) {
            $("#email")[0].setCustomValidity(emailDisponivel ? "" : "E-mail já cadastrado.");
        },
        error: data => $("#modal-erro").modal("show")
    });
}

function verificarCPF() {
    const cpf = $("#cpf").val().trim().replace(/\D/g, ""); //Remove caracteres não numéricos
    if (cpf.length == 11) {
        let v1 = 0;
        let v2 = 0;
        let aux = false;
        for (let i = 1; cpf.length > i; i++) {
            if (cpf[i - 1] != cpf[i]) {
                aux = true;
            }
        }
        if (aux == false) {
            $("#cpf")[0].setCustomValidity("CPF inválido.");
            return false;
        }
        for (let i = 0, p = 10; (cpf.length - 2) > i; i++, p--) {
            v1 += cpf[i] * p;
        }
        v1 = ((v1 * 10) % 11);
        if (v1 == 10) {
            v1 = 0;
        }
        if (v1 != cpf[9]) {
            $("#cpf")[0].setCustomValidity("CPF inválido.");
            return false;
        }
        for (let i = 0, p = 11; (cpf.length - 1) > i; i++, p--) {
            v2 += cpf[i] * p;
        }
        v2 = ((v2 * 10) % 11);
        if (v2 == 10) {
            v2 = 0;
        }
        if (v2 != cpf[10]) {
            $("#cpf")[0].setCustomValidity("CPF inválido.");
            return false;
        } else {
            $("#cpf")[0].setCustomValidity("");
            return true;
        }
    } else {
        $("#cpf")[0].setCustomValidity("CPF inválido.");
        return false;
    }
}

function configurarDatepickers() {

    $("#aulas-data-inicial, #aulas-data-final").mask("00/00/0000").val(moment().format("DD/MM/YYYY"));

    const datepickerParams = {
        dateFormat: "dd/mm/yy",
        changeMonth: true,
        changeYear: true,
        yearRange: "1900:2024",
        minDate: new Date(2024, 0, 1),
        maxDate: new Date(2025, 11, 31),
        dayNames: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado", "Domingo"],
        dayNamesMin: ["D", "S", "T", "Q", "Q", "S", "S", "D"],
        dayNamesShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb", "Dom"],
        monthNames: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
        monthNamesShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"]
    };

    $("#aulas-data-inicial").datepicker(datepickerParams);
}

function validarSenhas() {
    const senha1 = $("#senha1").val();
    const senha2 = $("#senha2").val();
    return $("#senha2")[0].setCustomValidity(senha1 !== senha2 ? "Senha diferente da anterior ou em branco." : "");
}

function cadastrarPessoa() {
    $.when(verificarDisponibilidadeCPF(), verificarDisponibilidadeSiape(), verificarDisponibilidadeEmail()).done(function () {
        const form = $("#form");
        const formData = new FormData(form[0]);
        formData.append("imagem", $("input[type=file]")[0]?.files[0]);
        $.ajax({
            dataType: "json",
            type: "POST", //Arquivo sempre precisa ser POST
            url: "crud",
            processData: false, //Necessário para enviar imagem e formData (valores do formulário) por POST
            contentType: false, //Necessário para enviar imagem e formData (valores do formulário) por POST
            data: formData,
            success: function (erro) {
                if (erro[0] == true) {
                    exibirFeedback("N", "Erro! Verifique os campos novamente");
                } else if (erro[1] == true) {
                    exibirFeedback("N", "Cadastro realizado, entretanto houve um erro ao enviar a imagem!");
                    setTimeout(() => window.location.href = "index", 3000);
                } else {
                    exibirFeedback("P", "Cadastro realizado!");
                    setTimeout(() => window.location.href = "index", 3000);
                }
            },
            error: data => $("#modal-erro").modal("show")
        });
    });
}