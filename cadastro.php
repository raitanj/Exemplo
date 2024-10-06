<?php
session_start();
if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
    header('Location: pagina');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Raitan Biz Rigon">
    <meta name="description" content="Página de cadastro">
    <title>Cadastro</title>
    <link rel="icon" href="Imagens/Sistema/Icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0-beta.2/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="CSS/style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="Javascript/cadastro.js"></script>
    <script src="Javascript/feedback.js"></script>
    <script src="Javascript/moment.js"></script>
</head>

<body>
    <?php include_once('menu-superior.php'); ?>
    <?php include_once('modal-erro-db.php'); ?>
    <main role="main">
        <div class="container">
            <div class="container-cadastro p-3 mt-4 mb-3">
                <form id="form" action="crud" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <input type="hidden" name="opcao" value="i1">
                        <div class="d-flex">
                            <div class="flex-grow-0">
                                <label for="imagem">
                                    <img class="rounded-circle" src="Imagens/Sistema/User.png" alt="Imagem de usuário" id="imagem-previa" width="180" height="130" />
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group mb-3 col-sm-12">
                            <label for="imagem" class="control-label">Imagem</label>
                            <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group required mb-3 col-sm-8">
                            <label for="nome" class="control-label">Nome Completo</label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="João da Silva" maxlength="60" required>
                        </div>
                        <div class="form-group required mb-3 col-sm-4">
                            <label for="cpf" class="control-label">CPF</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" placeholder="123.456.789-00" maxlength="11" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group required mb-3 col-sm-8">
                            <label for="cargo" class="control-label">Cargo</label>
                            <select class="form-select form-select-md" name="cargo" id="cargo" aria-label="Seleção de cargo"></select>
                        </div>
                        <div class="form-group required mb-3 col-sm-4">
                            <label for="data-nascimento" class="control-label">Data de nascimento</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="data-nascimento" id="data-nascimento" aria-label="Seleção de data de nascimento" required />
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group d-grid mb-3 col-sm-8">
                            <label for="sexo-masculino" class="control-label">Sexo</label>
                            <div class="container d-flex g-0">
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" id="sexo-masculino" name="sexo" value="M">
                                    <label class="form-check-label" for="sexo-masculino">Masculino</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" id="sexo-feminino" name="sexo" value="F">
                                    <label class="form-check-label" for="sexo-feminino">Feminino</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" id="sexo-outro" name="sexo" value="O">
                                    <label class="form-check-label" for="sexo-outro">Outro</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group required mb-3 col-sm-4">
                            <label for="email" class="control-label">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="usuario@dominio.com" autocomplete="email" maxlength="254" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group required mb-3 col-sm-4">
                            <label for="senha1" class="control-label">Senha</label>
                            <input type="password" class="form-control" id="senha1" name="senha1" maxlength="16" required>
                        </div>
                        <div class="form-group required mb-3 col-sm-4">
                            <label for="senha2" class="control-label">Confirmação da senha</label>
                            <input type="password" class="form-control" id="senha2" name="senha2" maxlength="16" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-center">
                            <div class="alert-feedback alert alert-warning" role="alert"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group text-end">
                            <button type="submit" class="btn btn-primary">Registrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>

</html>