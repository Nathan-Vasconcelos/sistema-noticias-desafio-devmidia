<?php

require_once 'src/persistencia/Conexao.php';
require_once 'src/dominio/modelo/Perfil.php';
require_once 'src/dominio/modelo/Usuario.php';
require_once 'src/controleUsuario/ControleUsuario.php';
require_once 'src/repositorio/RepositorioUsuarios.php';
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

$id = $_GET['id'];
$usuario = $repositorioUsuarios->buscarUsuarioPorId($id);

?>
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') : ?>
    <?php $permitirExcluri = $controleUsuario->negarAlteracaoAdm($usuario); ?>
    <?php if ($permitirExcluri) : ?>
        <?php $repositorioUsuarios->removerUsuario($_POST['id']); ?>
        <?php header('location: usuarios-sem-noticias.php'); ?>
    <?php else : ?>
        <script>window.alert('Não é possível excluir um usuário adm');</script>
    <?php endif ?>
<?php endif ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Noto+Sans&display=swap" rel="stylesheet">
    <title>Excluir Usuário</title>
</head>
<body>
    <header class="cabecalho"><h1><img src="https://imgs.search.brave.com/75uk1O7iw7k1WkwUlrEVxhB7Dv5jooCt2Rc9-F2XZu8/rs:fit:1200:419:1/g:ce/aHR0cDovL3d3dy5k/ZXZtZWRpYS5jb20u/YnIvam9pbi9pbWFn/ZXMvbG9nby1kZXZt/ZWRpYS5wbmc" alt="logo" class="logo"></h1><a href="categorias.html">CATEGORIAS</a> <a href="cadastrar-categoria.html">CADASTRAR CATEGORIA</a> <a href="cadastrar.html">CADASTRAR NOTICIAS</a> <a href="index.html">EXIBIR NOTICIAS</a> <form action=""><input type="search"><button type="submit" class="botao-busca"><img src="Desenho-Lupa-PNG.png" alt=""></button></form></header>
    <main>
        <section class="conteudo-excluir">
            <form action="" method="post">
                    <h2>Deseja excluir o usuário <?php echo $usuario->nome(); ?>?</h2>
                    <div class="botao-editar">
                        <button><a href="usuarios-sem-noticias.php">Voltar</a></button>
                    </div>
                    <div class="botao-editar">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <button type="submit">Excluir</button>
                    </div>
            </form>
        </section>
    </main>
<?php require_once 'layout/footer.html'; ?>
