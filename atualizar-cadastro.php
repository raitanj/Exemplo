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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0-beta.2/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="CSS/style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="Javascript/atualizar-cadastro.js"></script>
    <script src="Javascript/feedback.js"></script>
    <script src="Javascript/moment.js"></script>
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