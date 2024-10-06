<?php

session_start();
if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
    header('Location: pagina');
    exit();
}

include_once('Banco de dados/conexao.php');

if (empty($_GET) or (empty($_GET['token']))) {
    header('Location: recuperar-conta');
    exit();
}

$token = $_GET['token'];
$sql = "SELECT token FROM recuperacao_conta WHERE token=? AND valido = 1"; //Verificar se token existe
if ($stmt = $conexao->prepare($sql)) {
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $stmt->free_result();
    $stmt->close();
    $linha = $resultado->fetch_assoc();
    if ($resultado->num_rows == 0) {
        mysqli_close($conexao);
        header('Location: recuperar-conta');
        exit();
    }
}
mysqli_close($conexao);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Raitan Biz Rigon">
    <meta name="description" content="Página de redefinição de senha">
    <title>Redefinição de senha</title>
    <link rel="icon" href="Imagens/Sistema/Icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.0/js/bootstrap.min.js" integrity="sha512-8Y8eGK92dzouwpROIppwr+0kPauu0qqtnzZZNEF8Pat5tuRNJxJXCkbQfJ0HlUG3y1HB3z18CSKmUo7i2zcPpg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="Javascript/redefinir-senha.js"></script>
    <script src="Javascript/feedback.js"></script>
</head>

<body>
    <?php include_once('menu-superior.php'); ?>
    <?php include_once('modal-erro-db.php'); ?>
    <main role="main">
        <div class="container">
            <div class="container-redefinir-senha p-3">
                <div class="alert alert-feedback alert-warning" role="alert"></div>
                <form id="form" action="insert" method="post">
                    <input type="hidden" name="opcao" value="u4">
                    <input type="hidden" name="token" value="<?php echo $token ?>">
                    <div class="row mb-3">
                        <div class="form-group required col-md-6">
                            <label for="senha1" class="control-label">Senha</label>
                            <input type="password" class="form-control" id="senha1" name="senha1" maxlength="16" required>
                        </div>
                        <div class="form-group required col-md-6">
                            <label for="senha2" class="control-label">Confirmação da senha</label>
                            <input type="password" class="form-control" id="senha2" name="senha2" maxlength="16" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-primary float-end">Redefinir</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>

</html>