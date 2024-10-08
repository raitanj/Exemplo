<?php
session_start();
if (empty($_SESSION['logado']) || $_SESSION['logado'] === false) {
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
    <meta name="description" content="Página inicial">
    <title>Página Inicial</title>
    <link rel="icon" href="Imagens/Sistema/Icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="CSS/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.0/js/bootstrap.min.js" integrity="sha512-8Y8eGK92dzouwpROIppwr+0kPauu0qqtnzZZNEF8Pat5tuRNJxJXCkbQfJ0HlUG3y1HB3z18CSKmUo7i2zcPpg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="Javascript/pagina.js"></script>
</head>

<body>
    <?php include_once('menu-superior.php'); ?>
    <?php include_once('modal-erro-db.php'); ?>
    <main role="main">
        <div class="container min-vh-100 mt-5 justify-content-center">
            <div class="container container-menu-principal d-inline-flex p-2 justify-content-center flex-wrap">
                <div class="card card-menu-principal">
                    <img src="Imagens/Sistema/Menu Inicial - Imagem 1.png" class="card-img-top" alt="Reserva de salas">
                    <div class="card-body">
                        <h5 class="card-title">Reserva de Salas</h5>
                        <p class="card-text">Sistema de reserva de salas do campus IFC Brusque</p>
                        <a href="#" class="btn btn-link shadow-none stretched-link" aria-label="Imagem de menu da reserva de salas"></a>
                    </div>
                </div>
                <div class="card card-menu-principal">
                    <img src="Imagens/Sistema/Menu Inicial - Imagem 2.png" class="card-img-top" alt="Imagem de menu do controle do restaurante">
                    <div class="card-body">
                        <h5 class="card-title">Restaurante</h5>
                        <p class="card-text">Sistema administrativo do restaurante do campus IFC Brusque</p>
                        <a href="#" class="btn btn-link shadow-none stretched-link" aria-label="Controle do restaurante"></a>
                    </div>
                </div>
                <div class="card card-menu-principal">
                    <img src="Imagens/Sistema/Menu Inicial - Imagem 3.png" class="card-img-top" alt="Imagem de menu da reserva de veículos">
                    <div class="card-body">
                        <h5 class="card-title">Reserva de veículos</h5>
                        <p class="card-text">Sistema de reserva de veículos do campus IFC Brusque</p>
                        <a href="#" class="btn btn-link shadow-none stretched-link" aria-label="Reserva  de veículos"></a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include_once('menu-inferior.php'); ?>
</body>

</html>