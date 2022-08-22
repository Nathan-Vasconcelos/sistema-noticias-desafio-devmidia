<input type="checkbox" id="check" class="check-menu">
    <label for="check" class="label-menu-mobile"><img class="menu-icone" src="img/menu.png" alt=""></label>
    <nav class="menu-mobile">
        <ul class="lista-menu-mobile">
            <li><a href="index.php" class="link-menu-mobile">NOTICIAS</a></li>
            <?php if (isset($_SESSION['TOKEN'])) : ?>
            <li><a href="cadastrar.php" class="link-menu-mobile">CADASTRAR NOTICIAS</a></li>
            <li><a href="categorias.php" class="link-menu-mobile">CATEGORIAS</a></li>
            <li><a href="cadastrar-categoria.php" class="link-menu-mobile">CADASTRAR CATEGORIAS</a></li>
            <li><a href="usuarios.php" class="link-menu-mobile">USUÁRIOS</a></li>
            <li><a href="cadastrar-usuario.php" class="link-menu-mobile">CADASTRAR USUÁRIOS</a></li>
            <li><a href="logout.php" class="link-menu-mobile">SAIR</a></li>
            <?php endif ?>
        </ul>
    </nav>