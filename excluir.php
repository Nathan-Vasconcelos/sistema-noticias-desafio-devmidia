<?php

require_once 'src/dominio/modelo/Noticia.php';
require_once 'src/dominio/modelo/Categoria.php';
require_once 'src/persistencia/Conexao.php';
require_once 'src/repositorio/RepositorioNoticias.php';
require_once 'src/dominio/modelo/Perfil.php';
require_once 'src/dominio/modelo/Usuario.php';
require_once 'src/repositorio/RepositorioUsuarios.php';
require_once 'layout/cabecalho.html';

$id = $_GET['id'];

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
    <?php $noticiaRemovida = $repositorioNoticias->removeNoticia($_POST['id']); ?>
    <?php if ($noticiaRemovida  == FALSE) : ?>
        <script>window.alert('OCORREU UM PROBLEMA AO TENTAR REMOVER A NOTICIA');</script>
    <?php else : ?>
        <?php header('location: index.php'); ?>
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
    <title>Excluir</title>
</head>

    <main>
        <section class="conteudo-excluir">
            <form action="" method="post">
                    <h2>Deseja excluir a noticia Noticia qualquer?</h2>
                    <div class="botao-editar">
                        <button><a href="noticia.php?id=<?php echo $id; ?>">Voltar</a></button>
                    </div>
                    <div class="botao-editar">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <button type="submit">Excluir</button>
                    </div>
            </form>
        </section>
    </main>
<?php require_once 'layout/footer.html'; ?>
