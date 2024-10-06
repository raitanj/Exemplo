<header role="banner">
    <h1 class="h1">IFC Campus Brusque</h1>
</header>
<nav class="navbar navbar-expand-lg navbar-light bg-light" role="navigation">
    <div class="container-fluid">
        <a class="navbar-brand" href="pagina"><img alt="Página inicial" src="Imagens/Sistema/Logo - IFC Brusque.png" width="220" height="50" aria-label="Ir para página inicial"></a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Menu de navegação">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <?php if (isset($_SESSION['administrador']) && $_SESSION['administrador'] === 1) { ?><li class="nav-item dropdown"><a class="nav-link" href="area-restrita" aria-label="Área restrita">Área restrita</a></li><?php } ?>
                <?php if (isset($_SESSION['nome']) && !empty($_SESSION['nome'])) { ?><li class="nav-item dropdown"><a class="nav-link" href="atualizar-cadastro" aria-label="Perfil de usuário"><?php echo strtok(trim($_SESSION['nome']), ' ');
                                                                                                                                                                                                                                } ?></a></li>
                    <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) { ?><li class="nav-item dropdown"><a class="nav-link" href="logout" aria-label="Sair da sessão">Sair</a></li><?php } ?>
            </ul>
        </div>
    </div>
</nav>