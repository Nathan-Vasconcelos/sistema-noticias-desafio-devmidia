<?php

require_once 'src/persistencia/Conexao.php';
require_once 'src/dominio/modelo/Perfil.php';
require_once 'src/dominio/modelo/Usuario.php';
require_once 'src/repositorio/RepositorioUsuarios.php';
require_once 'src/controleUsuario/ControleUsuario.php';
require_once 'layout/menu-mobile.php';

$conexao = Conexao::criarConexao();
$repositorioUsuarios = new RepositorioUsuarios($conexao);

if (isset($_SESSION['TOKEN'])) {
    $repositorioUsuarios->autenticarToken($_SESSION['TOKEN']);
} else {
    header('location: login.php');
}

$controleUsuario = new ControleUsuario($_SESSION['TOKEN'], $repositorioUsuarios);
$controleUsuario->somenteAdm();

$usuarios = $repositorioUsuarios->todosOsUsuarios();

$usuariosComNoticias = $repositorioUsuarios->contarNoticiasDosUsuarios();
$listaIds = [];
foreach ($usuariosComNoticias as $usuarioComNoticias) {
    $listaIds[] = $usuarioComNoticias->id();
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<meta name="viewport" content="width=device-width">-->
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Noto+Sans&display=swap" rel="stylesheet">
    <title>Usuários sem notícias</title>
</head>
<body>
    <header class="cabecalho"><h1><img src="img/noticia.png" alt="logo" class="logo"></h1><a href="usuarios.php">USUÁRIOS</a> <a href="cadastrar-usuario.php">CADASTRAR USUÁRIO</a> <a href="categorias.php">CATEGORIAS</a> <a href="cadastrar-categoria.php">CADASTRAR CATEGORIA</a> <a href="cadastrar.php">CADASTRAR NOTICIAS</a> <a href="index.php">NOTICIAS</a> <a href="logout.php">SAIR</a> <form action=""><input type="search"><button type="submit" class="botao-busca"><img src="img/Desenho-Lupa-PNG.png" alt=""></button></form></header>
    <main>
        <table class="tabela-usuarios-sem-noticias">
            <thead><th>ID</th><th>PERFIL</th><th>NOME</th><th class="nao-necessario">E-MAIL</th><th class="nao-necessario">EDITAR</th><th>EXCLUIR</th></thead>
            <tbody>
                <?php foreach ($usuarios as $usuario) : ?>
                    <?php if (!in_array($usuario->id(), $listaIds)) : ?> 
                        <tr><td><a href="editar-usuario.php?id=<?php echo $usuario->id(); ?>"><?php echo $usuario->id(); ?></a></td><td><a href="editar-usuario.php?id=<?php echo $usuario->id(); ?>"><?php echo $usuario->nomePerfil(); ?></a></td><td><a href="editar-usuario.php?id=<?php echo $usuario->id(); ?>"><?php echo $usuario->nome(); ?></a></td><td class="nao-necessario"><?php echo $usuario->email(); ?></td><td class="nao-necessario"><button><a href="editar-usuario.php?id=<?php echo $usuario->id(); ?>">Editar</a></button></td><td><button><a href="excluir-usuario.php?id=<?php echo $usuario->id(); ?>">Excluir</a></button></td></tr>
                    <?php endif ?>
                <?php endforeach ?>
            </tbody>
        </table>
    </main>
<?php require_once 'layout/footer.html'; ?>
