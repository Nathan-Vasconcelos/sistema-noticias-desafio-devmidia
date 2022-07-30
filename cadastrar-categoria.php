<?php

require_once 'src/dominio/modelo/Noticia.php';
require_once 'src/dominio/modelo/Categoria.php';
require_once 'src/persistencia/Conexao.php';
require_once 'src/repositorio/RepositorioNoticias.php';
require_once 'src/dominio/modelo/Perfil.php';
require_once 'src/dominio/modelo/Usuario.php';
require_once 'src/repositorio/RepositorioUsuarios.php';
require_once 'layout/cabecalho-categoria.html';

$conexao = Conexao::criarConexao();
$repositorioNoticias = new RepositorioNoticias($conexao);

$repositorioUsuarios = new RepositorioUsuarios($conexao);
if (isset($_SESSION['TOKEN'])) {
    $repositorioUsuarios->autenticarToken($_SESSION['TOKEN']);
} else {
    header('location: login.php');
}

?>
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') : ?>

    <?php
    
    $nome = $_POST['nomeCategoria'];

    $categoria = new Categoria(null, $nome);

    $categoriaSalva = $repositorioNoticias->salvarCategoria($categoria);

    ?>

    <?php if ($categoriaSalva == FALSE) : ?>
        <script>window.alert('JÁ EXIESTE UMA CATEGORIA CADASTRADA COM ESSE NOME');</script>
    <?php else : ?>
        <?php header('location: categorias.php'); ?>
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
    <title>Cadastrar</title>
</head>

    <main>
        <section class="form-cadastro">
            <form action="" method="post">
                <legend>Cadastro de categoria</legend>
                <br>
                <label for="categoria">Nome da categoria</label>
                <input type="text" name="nomeCategoria" placeholder="Nome da categoria" required>
                <div class="botao-caixa">
                    <button type="submit">Cadastrar</button>
                </div>
            </form>
        </section>
    </main>
<?php require_once 'layout/footer.html'; ?>
