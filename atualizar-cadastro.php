<?php
session_start();
if (!isset($_SESSION['logado']) || (isset($_SESSION['logado']) && $_SESSION['logado'] === false)) {
    header('Location: index');
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
    <meta name="description" content="Página de atualização de cadastro">
    <title>Atualização de cadastro</title>
    <link rel="icon" href="Imagens/Sistema/Icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.0/js/bootstrap.min.js" integrity="sha512-8Y8eGK92dzouwpROIppwr+0kPauu0qqtnzZZNEF8Pat5tuRNJxJXCkbQfJ0HlUG3y1HB3z18CSKmUo7i2zcPpg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="Javascript/atualizar-cadastro.js"></script>
    <script src="Javascript/feedback.js"></script>
</head>

<body>
    <?php include_once('menu-superior.php'); ?>
    <?php include_once('modal-erro-db.php'); ?>
    <main role="main">
        <div class="container-fluid p-lg-5">
            <div class="container-atualizar-cadastro d-flex gap-3">
                <aside class="col-md-3 col-lg-2">
                    <section>
                        <div class="d-block mb-3 flex-grow-0 mt-3" id="container-painel-ul">
                            <ul class="list-group rounded-0">
                                <li class="list-group-item"><a href="#" class="list-group-item list-group-item-action active" aria-label="Dados">Dados</a></li>
                                <li class="list-group-item"><a href="#" class="list-group-item list-group-item-action" aria-label="E-mail">E-mail</a></li>
                                <li class="list-group-item"><a href="#" class="list-group-item list-group-item-action" aria-label="Segurança">Segurança</a></li>
                            </ul>
                        </div>
                    </section>
                </aside>
                <div class="d-inline-block mb-3 flex-grow-1" id="container-painel-dados"></div>
            </div>
        </div>
    </main>
</body>

</html>