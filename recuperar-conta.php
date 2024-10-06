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
    <meta name="description" content="Página de recuperação de e-mail">
    <title>Recuperação de conta</title>
    <link rel="icon" href="Imagens/Sistema/Icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.0/js/bootstrap.min.js" integrity="sha512-8Y8eGK92dzouwpROIppwr+0kPauu0qqtnzZZNEF8Pat5tuRNJxJXCkbQfJ0HlUG3y1HB3z18CSKmUo7i2zcPpg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="Javascript/recuperar-conta.js"></script>
    <script src="Javascript/feedback.js"></script>
</head>

<body>
    <?php include_once('menu-superior.php'); ?>
    <?php include_once('modal-erro-db.php'); ?>
    <main role="main">
        <div class="container">
            <div class="container-recuperar-conta p-3">
                <div class="alert alert-feedback alert-warning" role="alert"></div>
                <form id="form" action="crud" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="opcao" value="i2">
                    <div class="row mb-3 justify-content-md-center">
                        <div class="form-group required col-md-12">
                            <label for="email" class="control-label">E-mail de recuperação</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="usuario@dominio.com" maxlength="254" autocomplete="email" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-primary float-end">Enviar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>

</html>