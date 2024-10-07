<?php

/*
[ADMINISTRADOR] -> A opção só pode ser executada após verificar se o usuário é administrador na sessão

SELECTs
Case s1: Verificar login
Case s2: Verificar login na sessão
Case s3: Verificar se e-mail é único
Case s4: Verificar se CPF é único
Case s5: SELECT dados de cadastro de usuário para alteração
Case s6: SELECT cargos
Case s7: SELECT lista de usuários [ADMINISTRADOR]

INSERTs
Case i1: INSERT usuário
Case i2: Enviar e-mail para redefinição

UPDATEs
Case u1: UPDATE usuário (Dados Gerais)
Case u2: UPDATE usuário (E-mail)
Case u3: UPDATE usuário (Senha)
Case u4: UPDATE de redefinição de senha de usuário por e-mail
Case u5: UPDATE usuário através da área restrita pelo administrador [ADMINISTRADOR]

DELETEs
Case d1: 
*/

date_default_timezone_set("America/Sao_Paulo");
define("PASTA_IMAGENS_PESSOAS", "Imagens/Pessoas/");
define("TAMANHO_MAX_ARQUIVO", 2 * (1024 * 1024)); //Limite de tamanho: 2MB (default PHP)

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {

    include_once('Banco de dados/conexao.php');
    include_once('Email/enviar-email.php'); //Adiciona função para envio de e-mails com o PHP Mailer

    $opcao = filter_input(INPUT_POST, 'opcao') ?? filter_input(INPUT_GET, 'opcao');

    $resposta = "";
    $resultado = $conexao->query("SELECT 1 FROM DUAL LIMIT 0");

    switch ($opcao) {

        case "s1": //Verificar Login

            if (!isset($_POST['email']) || !isset($_POST['senha']) || empty($_POST['email']) || empty($_POST['senha'])) {
                $resposta = array(true, 1);
                break;
            }

            if (verificarBloqueio($conexao)) {
                $resposta = array(true, 2);
                break;
            }

            $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
            $senha = $_POST['senha'];

            $sql = "SELECT idPessoa, email, senha, nome, administrador FROM pessoa WHERE email=?";
            $resultado = executarQueryComRetorno($conexao, $sql, "s", [$email]);
            if ($resultado && $resultado->num_rows > 0) {
                $linha = $resultado->fetch_assoc();
                if (password_verify($senha, $linha['senha'])) { //Verificar se senhas são iguais
                    $resposta = array(false, 0);
                    session_start();
                    $_SESSION['idPessoa'] = $linha['idPessoa'];
                    $_SESSION['email'] = $linha['email'];
                    $_SESSION['nome'] = $linha['nome'];
                    $_SESSION['administrador'] = $linha['administrador'];
                    $_SESSION['logado'] = true;
                } else {
                    $resposta = array(true, 3); //Senha inválida
                    insertLoginInvalido($conexao); //Login inválido
                }
            } else {
                $resposta = array(true, 4); //E-mail inválido
                insertLoginInvalido($conexao); //Login inválido
            }
            break;

        case "s2": //Verificar login na sessão
            $resposta = verificarLogin();
            break;

        case "s3": //Verificar se e-mail é único
            $email = filter_input(INPUT_GET, 'email');
            $resposta = false;
            if (!empty($email)) {
                $sql = "SELECT email FROM pessoa WHERE email=?";
                $resultado = executarQueryComRetorno($conexao, $sql, "s", [$email]);
                if ($resultado && $resultado->num_rows == 0) {
                    $resposta = true;
                }
            }
            break;

        case "s4": //Verificar se CPF é único
            $cpf = filter_input(INPUT_GET, 'cpf');
            $cpf = preg_replace('/[^0-9]/', '', $cpf);

            $resposta = false;
            if (!empty($cpf)) {
                $sql = "SELECT cpf FROM pessoa WHERE cpf=?";
                $resultado = executarQueryComRetorno($conexao, $sql, "s", [$cpf]);
                if ($resultado && $resultado->num_rows == 0) {
                    $resposta = true;
                }
            }
            break;

        case "s5": //SELECT dados de cadastro de usuário para alteração
            session_start();
            $resultado = $conexao->query("SELECT cpf, nome, email, data_nascimento, sexo, IF(imagem IS NULL OR imagem = '', '', CONCAT('" . PASTA_IMAGENS_PESSOAS . "', imagem)) as imagem FROM pessoa WHERE idPessoa = {$_SESSION['idPessoa']}");
            $resposta =  mysqli_fetch_assoc($resultado);
            break;

        case "s6": //SELECT cargos
            $sql = "SELECT idCargo, nome FROM cargo ORDER BY nome ASC";
            $resultado = $conexao->query($sql);
            while (($linha = mysqli_fetch_assoc($resultado))) {
                $resposta .= "<option value='{$linha['idCargo']}'>{$linha['nome']}</option>";
            }
            break;

        case "s7": //SELECT lista de usuários
            session_start();
            if ($_SESSION['administrador'] === 1) {
                $sql = "SELECT p.idPessoa, p.nome, p.cpf, p.email, p.data_nascimento, p.sexo, IF(imagem IS NULL OR imagem = '', '', CONCAT('" . PASTA_IMAGENS_PESSOAS . "', imagem)) as imagem, c.nome AS cargo FROM pessoa p INNER JOIN cargo c ON c.idCargo = p.cargo_idCargo ORDER BY p.nome ASC";
                $resultado = $conexao->query($sql);
                while (($linha = mysqli_fetch_assoc($resultado))) {

                    $imagem = !empty($linha['imagem'])
                        ? "<a href='{$linha['imagem']}' target='_blank'><i class='fa-solid fa-image'></i></a>"
                        : "<i class='fa-solid fa-image'></i>";

                    $resposta .=
                        "<tr>
                            <td class='d-none'>{$linha['idPessoa']}</td>
                            <td contenteditable='true'>{$linha['nome']}</td>
                            <td>$imagem</td>
                            <td contenteditable='true' class='cpf'>{$linha['cpf']}</td>
                            <td contenteditable='true'>{$linha['email']}</td>
                            <td contenteditable='true' class='data-nascimento'>{$linha['data_nascimento']}</td>
                            <td><select class='form-select text-center bg-transparent border-0' name='sexo' aria-label='Seleção de sexo'><option value='' hidden>{$linha['sexo']}</option></select></td>
                            <td><select class='form-select text-center bg-transparent border-0' name='cargo' aria-label='Seleção de cargo'><option value='' hidden>{$linha['cargo']}</option></select></td>
                            <td><button class='btn btn-outline-primary btn-salvar-edicao-usuario'>Salvar</button></td>
                            <td><div class='alert-feedback alert-success alert-dismissible mb-0' style='white-space: nowrap;'></div></td>
                        </tr>";
                }
            }
            break;

        case "i1": //INSERT Usuário
            session_start();
            if (isset($_SESSION['logado']) && $_SESSION['logado']) {
                $resposta = array(true, 1);
                break;
            }

            $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
            $cpf = trim(preg_replace('/[^0-9]/', '', htmlspecialchars($_POST['cpf'], ENT_QUOTES, 'UTF-8')));
            $sexo = isset($_POST['sexo']) ? trim(htmlspecialchars($_POST['sexo'], ENT_QUOTES, 'UTF-8')) : "";
            $senha = password_hash($_POST['senha1'], PASSWORD_DEFAULT);
            $nome = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", htmlspecialchars($_POST['nome'], ENT_QUOTES, 'UTF-8'))));
            $data_nascimento = trim(htmlspecialchars($_POST['data-nascimento'], ENT_QUOTES, 'UTF-8'));
            $administrador = 0;
            $idCargo = filter_input(INPUT_POST, 'cargo', FILTER_VALIDATE_INT);

            $resposta = array(true);

            if (verificarCpf($cpf)) {
                break;
            }

            if (!in_array($sexo, ['M', 'F', 'O'])) {
                $sexo = "";
            }

            $sql = "INSERT INTO pessoa(cpf, nome, email, senha, data_nascimento, sexo, administrador, cargo_idCargo) VALUES (?,?,?,?,?,?,?,?)";
            if (executarQuery($conexao, $sql, "ssssssii", [$cpf, $nome, $email, $senha, $data_nascimento, $sexo, $administrador, $idCargo])) {
                $arquivo_imagem = $_FILES;
                $resposta = array(false);
                array_push($resposta, verificarImagem($conexao, $arquivo_imagem, $cpf)); //Verificar arquivo de imagem após cadastro
            }
            break;

        case "i2": //Enviar e-mail para redefinição
            session_start();
            if (isset($_SESSION['logado']) && $_SESSION['logado']) {
                $resposta = array(true, 1);
                break;
            }

            if (!empty($_POST) && empty($_POST['email'])) {
                $resposta = array(true, 2);
                break;
            }

            $resposta = true;

            $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
            $sql = "SELECT idPessoa, email FROM pessoa WHERE email=?";
            $resultado = executarQueryComRetorno($conexao, $sql, "s", [$email]);
            if ($resultado && $resultado->num_rows > 0) {
                $linha = $resultado->fetch_assoc();
                $idPessoa = $linha['idPessoa'];

                //Anular outros tokens de recuperação do usuário se existentes
                $sql = "SELECT rc.idRecuperacaoConta, rc.pessoa_idPessoa FROM recuperacao_conta rc INNER JOIN pessoa p ON p.idPessoa = rc.pessoa_idPessoa WHERE p.email=? AND rc.valido = 1";
                $resultado = executarQueryComRetorno($conexao, $sql, "s", [$email]);
                if ($resultado && $resultado->num_rows > 0) {
                    while (($linha = mysqli_fetch_assoc($resultado))) {
                        $idRecuperacaoConta = $linha['idRecuperacaoConta'];
                        $conexao->query("UPDATE recuperacao_conta SET valido = 0 WHERE idRecuperacaoConta = $idRecuperacaoConta");
                    }
                }
                //INSERT após anular outros tokens
                $token = bin2hex(random_bytes(16));
                $hoje = new DateTime("now", new DateTimeZone('America/Sao_Paulo'));
                $hoje = $hoje->format('Y-m-d H:i:s');
                $valido = 1;
                $sql = "INSERT INTO recuperacao_conta(pessoa_idPessoa,token,data,valido) VALUES(?,?,?,?)";
                if (executarQuery($conexao, $sql, "issi", [$idPessoa, $token, $hoje, $valido])) {
                    $resposta = false;
                    $corpo = "Olá!<br/><br/>Clique <a href='localhost/IFC/redefinir-senha?token=$token'>AQUI</a> para redefinir sua senha.";
                    $corpo .= "<br/><br/><b><font color='red'>Atenção!</font></b> O link acima expira após 24h.";
                    enviarEmail($email, "IFC - Redefinição de senha", $corpo);
                }
            }
            break;

        case "u1": //UPDATE Usuário (Dados Gerais)
            session_start();
            $idPessoa = $_SESSION['idPessoa'];

            $sexo = isset($_POST['sexo']) ? trim(htmlspecialchars($_POST['sexo'], ENT_QUOTES, 'UTF-8')) : "";
            $nome = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", htmlspecialchars($_POST['nome'], ENT_QUOTES, 'UTF-8'))));

            $resposta = true;
            $sql = "UPDATE pessoa SET nome=?, sexo=? WHERE idPessoa=?";
            if (executarQuery($conexao, $sql, "ssi", [$nome, $sexo, $idPessoa])) {
                $arquivo_imagem = $_FILES;
                $_SESSION['nome'] = $nome;
                $cpf = $conexao->query("SELECT cpf FROM pessoa WHERE idPessoa=$idPessoa")->fetch_object()->cpf;
                $resposta = verificarImagem($conexao, $arquivo_imagem, $cpf);
            }
            break;

        case "u2": //UPDATE Usuário (E-mail)
            session_start();
            $idPessoa = $_SESSION['idPessoa'];

            $resposta = true;
            $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
            if (!empty($email)) {
                $sql = "UPDATE pessoa SET email=? WHERE idPessoa=?";
                if (executarQuery($conexao, $sql, "si", [$email, $idPessoa])) {
                    $_SESSION['email'] = $email;
                    $resposta = false;
                }
            }
            break;

        case "u3": //UPDATE Usuário (Senha)
            session_start();
            $idPessoa = $_SESSION['idPessoa'];

            $resposta = true;
            $senha_nova = $_POST['senha1'];

            if (verificarBloqueio($conexao)) {
                $resposta = array(true, 1); //Limite de tentativas atingido
                break;
            }

            if (!empty($senha_nova)) {
                $senha_atual = $_POST['senha-atual'];
                $senha = $conexao->query("SELECT senha FROM pessoa WHERE idPessoa = $idPessoa")->fetch_object()->senha;
                if (password_verify($senha_atual, $senha)) {
                    $senha_nova = password_hash($senha_nova, PASSWORD_DEFAULT);
                    $sql = "UPDATE pessoa SET senha=? WHERE idPessoa=?";
                    if (executarQuery($conexao, $sql, "si", [$senha_nova, $idPessoa])) {
                        $resposta = false;
                    }
                } else {
                    insertLoginInvalido($conexao);
                    $resposta = array(true, 2); //Senha incorreta
                }
            }
            break;

        case "u4": //UPDATE de redefinição de senha de usuário por e-mail
            $token = trim(htmlspecialchars($_POST['token'], ENT_QUOTES, 'UTF-8'));
            $nova_senha = $_POST['senha1'];

            $resposta = true;
            if (!empty($nova_senha)) {
                $nova_senha = password_hash($nova_senha, PASSWORD_DEFAULT);
                $sql = "SELECT pessoa_idPessoa FROM recuperacao_conta WHERE token=?";
                $resultado = executarQueryComRetorno($conexao, $sql, "s", [$token]);
                if ($resultado && $resultado->num_rows > 0) {
                    $linha = $resultado->fetch_assoc();
                    $idPessoa = $linha['pessoa_idPessoa'];
                    $sql = "UPDATE pessoa SET senha=? WHERE idPessoa=?";
                    if (executarQuery($conexao, $sql, "si", [$nova_senha, $idPessoa])) {
                        $resposta = false;
                    }
                }
            }
            break;

        case "u5": //UPDATE usuário através da área restrita pelo administrador
            session_start();
            if ($_SESSION['administrador'] === 1) {
                $idPessoa = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
                $nome = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", htmlspecialchars($_POST['nome'], ENT_QUOTES, 'UTF-8'))));
                $cpf = trim(preg_replace('/[^0-9]/', '', htmlspecialchars($_POST['cpf'], ENT_QUOTES, 'UTF-8')));
                $data_nascimento = trim(htmlspecialchars($_POST['data_nascimento'], ENT_QUOTES, 'UTF-8'));
                $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
                $sexo = isset($_POST['sexo']) ? htmlspecialchars($_POST['sexo'], ENT_QUOTES, 'UTF-8') : "";
                $cargo = filter_input(INPUT_POST, 'cargo', FILTER_VALIDATE_INT);
                $resposta = false;

                if (verificarCpf($cpf)) {
                    $resposta = array(true, 1); //CPF inválido
                } else {
                    $sql = "UPDATE pessoa SET cpf=? WHERE idPessoa=?";
                    if (!executarQuery($conexao, $sql, "si", [$cpf, $idPessoa])) {
                        $resposta = array(true, 2); //CPF duplicado
                    }
                }

                $sql = "UPDATE pessoa SET email=? WHERE idPessoa=?";
                if (!executarQuery($conexao, $sql, "si", [$email, $idPessoa])) {
                    $resposta = array(true, 3); //E-mail duplicado
                }

                $sql = "UPDATE pessoa SET data_nascimento=? WHERE idPessoa=?";
                if (!executarQuery($conexao, $sql, "si", [$data_nascimento, $idPessoa])) {
                    $resposta = array(true, 4); //Data de nascimento inválida
                }

                $resultado = executarQueryComRetorno($conexao, "SELECT idCargo FROM cargo WHERE nome=?", "s", [$cargo]);
                if ($resultado && $resultado->num_rows > 0) {
                    $idCargo = $resultado->fetch_object()->idCargo;
                    $sql = "UPDATE pessoa SET cargo_idCargo=? WHERE idPessoa=?";
                    if (!executarQuery($conexao, $sql, "ii", [$idCargo, $idPessoa])) {
                        $resposta = array(true, 5); //Cargo inválido
                    }
                }

                $sql = "UPDATE pessoa SET nome=?, sexo=? WHERE idPessoa=?";
                if (!executarQuery($conexao, $sql, "ssi", [$nome, $sexo, $idPessoa])) {
                    $resposta = array(true, 6); //Campo extrapolado
                }
            }
            break;
    }

    if ($resultado instanceof mysqli_result) {
        mysqli_free_result($resultado);
    }
    mysqli_close($conexao);
    echo json_encode($resposta);
    exit;
}

function executarQuery(mysqli $conexao, $sql, $nParametros, $parametros) //Queries com INSERTs, UPDATEs e DELETEs
{
    $resultado = false;
    if ($stmt = $conexao->prepare($sql)) {
        $stmt->bind_param($nParametros, ...$parametros);
        if ($stmt->execute()) {
            $resultado = true;
        }
        $stmt->close();
    }
    return $resultado;
}

function executarQueryComRetorno(mysqli $conexao, $sql, $nParametros, $parametros) //Queries com SELECTs
{
    if ($stmt = $conexao->prepare($sql)) {
        $stmt->bind_param($nParametros, ...$parametros);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
        }
        $stmt->free_result();
        $stmt->close();
        return $resultado;
    }
}

function verificarBloqueio(mysqli $conexao)
{
    //Verificar se o IP errou a senha mais de 5 vezes nos últimos 10 minutos
    $ip = $_SERVER['REMOTE_ADDR'];
    $data = date_create()->format('Y-m-d H:i:s'); //Data e hora do servidor
    $tentativa = $conexao->query("SELECT COUNT(*) AS tentaviva FROM login WHERE ip = '$ip' AND data BETWEEN DATE_ADD('$data',INTERVAL - 10 MINUTE) AND '$data'")->fetch_object()->tentaviva;
    return $tentativa >= 5;
}

function insertLoginInvalido(mysqli $conexao)
{
    $ip = $_SERVER['REMOTE_ADDR'];
    $data = date_create()->format('Y-m-d H:i:s'); //Data e hora do servidor
    $conexao->query("INSERT INTO login(ip,data) VALUES('$ip','$data')");
}

function verificarLogin()
{
    session_start();
    $resposta = false;
    if (isset($_SESSION['logado']) && $_SESSION['logado']) {
        $resposta = true;
    }
    return $resposta;
}

function verificarCpf($cpf)
{
    if (strlen($cpf) != 11) { //Entrada diferente de 11 dígitos
        return true;
    }
    if (preg_match('/(\d)\1{10}/', $cpf)) { //Entrada com nºs repetidos (111.111.111-11)
        return true;
    }
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return true;
        }
    }
    return false;
}

function verificarImagem(mysqli $conexao, $arquivo_imagem, $cpf)
{
    $erro = true;
    $sql = "SELECT idPessoa,imagem FROM pessoa WHERE cpf=?";
    $resultado = executarQueryComRetorno($conexao, $sql, "s", [$cpf]);
    if ($resultado && $resultado->num_rows > 0) {
        $linha = $resultado->fetch_assoc();
        $idPessoa = $linha['idPessoa'];
        $imagem = $linha['imagem'];
        if (
            !empty($arquivo_imagem['imagem']['name'])
            && $arquivo_imagem['imagem']['size'] <= TAMANHO_MAX_ARQUIVO
            && $arquivo_imagem['imagem']['size'] > 0
        ) { //Imagens maiores que 2MB aparecem com 0MB
            if (!empty($imagem) && file_exists(PASTA_IMAGENS_PESSOAS . $imagem)) { //Deletar imagem antiga ao atualizar
                unlink(PASTA_IMAGENS_PESSOAS . $imagem);
            }
            $ext = pathinfo($arquivo_imagem['imagem']['name'], PATHINFO_EXTENSION);
            $nome_imagem = bin2hex(random_bytes(8)); //Gera um hash para garantir que usuários não consigam descobrir outras imagens no servidor
            $imagem = "$nome_imagem.$ext";
            move_uploaded_file($arquivo_imagem['imagem']['tmp_name'], PASTA_IMAGENS_PESSOAS . $imagem);
        }
        $conexao->query("UPDATE pessoa SET imagem = \"$imagem\" WHERE idPessoa = $idPessoa");
        $erro = false;
    }

    return $erro;
}

function utf8_fopen_read($fileName)
{
    $fc = iconv('windows-1250', 'utf-8', file_get_contents($fileName));
    $handle = fopen("php://memory", "rw");
    fwrite($handle, $fc);
    fseek($handle, 0);
    return $handle;
}
