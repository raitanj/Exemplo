<?php
session_start();
if (isset($_SESSION['logado']) && isset($_SESSION['administrador'])) {
    if ($_SESSION['logado'] === false || $_SESSION['administrador'] === 0) {
        header('Location: index');
        exit();
    }
} else {
    header('Location: index');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=.5">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Raitan Biz Rigon">
    <meta name="description" content="Página de área restrita">
    <title>Área restrita</title>
    <link rel="icon" href="Imagens/Sistema/Icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0-beta.2/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.0/js/bootstrap.min.js" integrity="sha512-8Y8eGK92dzouwpROIppwr+0kPauu0qqtnzZZNEF8Pat5tuRNJxJXCkbQfJ0HlUG3y1HB3z18CSKmUo7i2zcPpg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="Javascript/area-restrita.js"></script>
    <script src="Javascript/feedback.js"></script>
    <script src="Javascript/moment.js"></script>
</head>

<body>
    <?php include_once('menu-superior.php'); ?>
    <?php include_once('modal-erro-db.php'); ?>
    <main role="main">
        <div class="container-fluid">
            <div class="container-area-restrita d-flex m-auto mt-3">
                <aside>
                    <section>
                        <div class="d-block mb-3 text-nowrap flex-grow-0 p-2" id="container-painel-ul">
                            <ul class="list-group">
                                <li class="list-group-item"><a href="#" class="list-group-item list-group-item-action active" aria-label="Usuários">Usuários</a></li>
                                <li class="list-group-item"><a href="#" class="list-group-item list-group-item-action" aria-label="Reserva de salas">Reserva de salas</a></li>
                                <li class="list-group-item"><a href="#" class="list-group-item list-group-item-action" aria-label="Cadastros">Cadastros</a></li>
                            </ul>
                        </div>
                    </section>
                </aside>
                <div class="d-inline-block flex-grow-1 p-2" id="container-painel-dados"></div>
            </div>
        </div>
    </main>
</body>

</html>