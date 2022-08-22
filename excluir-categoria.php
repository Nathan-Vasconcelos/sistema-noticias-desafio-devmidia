<?php

require_once 'src/dominio/modelo/Noticia.php';
require_once 'src/dominio/modelo/Categoria.php';
require_once 'src/persistencia/Conexao.php';
require_once 'src/repositorio/RepositorioNoticias.php';
require_once 'src/dominio/modelo/Perfil.php';
require_once 'src/dominio/modelo/Usuario.php';
require_once 'src/repositorio/RepositorioUsuarios.php';
require_once 'src/controleUsuario/ControleUsuario.php';
require_once 'layout/menu-mobile.php';
require_once 'layout/cabecalho-categoria.html';

$id = $_GET['id'];

$conexao = Conexao::criarConexao();
$repositorioNoticias = new RepositorioNoticias($conexao);

$repositorioUsuarios = new RepositorioUsuarios($conexao);
if (isset($_SESSION['TOKEN'])) {
    $repositorioUsuarios->autenticarToken($_SESSION['TOKEN']);
} else {
    header('location: login.php');
}

$controleUsuario = new ControleUsuario($_SESSION['TOKEN'], $repositorioUsuarios);
$controleUsuario->somenteAdm();

$categoria = $repositorioNoticias->umaCategoria($id);

?>

<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') : ?>

    <?php $categoriaRemovida = $repositorioNoticias->removeCategoria($_POST['id']); ?>

    <?php if ($categoriaRemovida == FALSE) : ?>
        <script>window.alert('EXIESTE UMA NOTICIA CADASTRADA COM ESSA CATEGORIA');</script>
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
    <title>Excluir categoria</title>
</head>

    <main>
        <section class="conteudo-excluir">
            <form action="" method="post">
                <h2>Deseja excluir a categoria <?php echo $categoria->categoria(); ?>?</h2>
                <div class="botao-editar">
                    <button><a href="categorias.php">Voltar</a></button>
                </div>
                <div class="botao-editar">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <button type="submit">Excluir</button>
                </div>
            </form>
        </section>
    </main>
<?php require_once 'layout/footer.html'; ?>
