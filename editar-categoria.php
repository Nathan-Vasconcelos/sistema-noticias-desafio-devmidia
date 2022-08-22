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

<?php

$categoria = new Categoria($categoria->id(), $_POST['nomeCategoria']);

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
    <title>Editar categoria</title>
</head>

    <main>
        <section class="form-cadastro">
            <form action="" method="post">
                <legend>Editar categoria</legend>
                <br>
                <label for="categoria">Nome da categoria</label>
                <input type="text" placeholder="Nome da categoria" value="<?php echo $categoria->categoria(); ?>" name="nomeCategoria" required>
                <div class="botao-caixa-categoria">
                    <button type="submit">Salvar</button>
                </div>
            </form>
        </section>
    </main>
<?php require_once 'layout/footer.html'; ?>
