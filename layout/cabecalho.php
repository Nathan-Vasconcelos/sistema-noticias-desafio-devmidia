<body>
    <header class="cabecalho"><h1><img src="https://imgs.search.brave.com/75uk1O7iw7k1WkwUlrEVxhB7Dv5jooCt2Rc9-F2XZu8/rs:fit:1200:419:1/g:ce/aHR0cDovL3d3dy5k/ZXZtZWRpYS5jb20u/YnIvam9pbi9pbWFn/ZXMvbG9nby1kZXZt/ZWRpYS5wbmc" alt="logo" class="logo"></h1> <?php if (isset($_SESSION['TOKEN'])) : ?><a href="cadastrar-usuario.php">CADASTRAR USUÁRIO</a> <a href="categorias.php">CATEGORIAS</a> <a href="cadastrar-categoria.php">CADASTRAR CATEGORIA</a> <a href="cadastrar.php">CADASTRAR NOTICIAS</a><?php endif ?> <a href="index.php">EXIBIR NOTICIAS</a> <?php if (isset($_SESSION['TOKEN'])) : ?><a href="logout.php">SAIR</a><?php endif ?> <form action="index.php" method="get"><input type="search" name="busca"><button type="submit" class="botao-busca"><img src="img/Desenho-Lupa-PNG.png" alt=""></button></form></header>