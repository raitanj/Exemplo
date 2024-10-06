const feedbackAtualizarPessoa = {
    1: "Erro! CPF inválido",
    2: "Erro! CPF já cadastrado",
    3: "Erro! E-mail já cadastrado",
    4: "Erro! SIAPE já cadastrado",
    5: "Erro! Cargo inválido",
    6: "Erro! Nome muito longo"
};

$(document).ready(function () {
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

    $(document).on("focus", ".cpf", function () {
        $(this).unmask();
    });

    $(document).on("blur", ".cpf", function () {
        $(this).mask("000.000.000-00");
    });

}

function carregarPainel(opcao) {
    const paginas = [
        { url: "area-restrita-pessoas.html", func: carregarTabelaPessoas } /*,
        { url: "area-restrita-reserva-salas.html", func: () => function1(2) },
        { url: "area-restrita-cadastros-gerais.html", func: function2 } */
    ];
    $("#container-painel-dados").load(paginas[opcao].url, paginas[opcao].func);
}

function carregarTabelaPessoas() {
    $.ajax({
        dataType: "json",
        type: "GET",
        url: "crud",
        data: { opcao: "s7" },
        success: function (data) {
            $("#tabela-listar-pessoas tbody").html(data);
            $(".cpf").mask("000.000.000-00");
            $(".siape").mask("0000000");
        },
        complete: carregarTabelaComboBoxPessoas,
        error: data => $("#modal-erro").modal("show")
    });
}

function carregarTabelaComboBoxPessoas() {
    const combobox = $(".form-select[name='cargo']");
    $.ajax({
        dataType: "json",
        type: "GET",
        url: "crud",
        data: { opcao: "s6" },
        success: function (data) {
            combobox.append(data);
        },
        error: data => $("#modal-erro").modal("show")
    });

    const sexo = { "1": "M", "2": "F", "3": "O" };
    $.each(sexo, (key, value) => {
        $(".form-select[name='sexo']").append($("<option>", { value: key }).text(value));
    });
}

function atualizarPessoa() {
    const linha = $(this).closest("tr");
    const data = linha.find("td").map((i, el) => $(el).text()).get();

    $.ajax({
        dataType: "json",
        type: "POST",
        url: "crud",
        data: {
            opcao: "u5",
            id: data[0],
            nome: data[1],
            cpf: data[3],
            email: data[4],
            siape: data[5],
            sexo: linha.find("td:eq(6) select option:selected").text(),
            cargo: linha.find("td:eq(7) select option:selected").text()
        },
        success: function (erro) {
            const mensagem = erro[0] ? feedbackAtualizarPessoa[erro[1]] : "Salvo!";
            erro[0] ? exibirFeedbackTabela("N", linha, mensagem) : exibirFeedbackTabela("P", linha, mensagem);
        },
        error: data => $("#modal-erro").modal("show")
    });
}