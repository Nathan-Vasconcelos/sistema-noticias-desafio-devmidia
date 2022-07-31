<?php

require_once 'src/dominio/modelo/Noticia.php';
require_once 'src/dominio/modelo/Categoria.php';
require_once 'src/persistencia/Conexao.php';
require_once 'src/repositorio/RepositorioNoticias.php';
require_once 'src/dominio/modelo/Perfil.php';
require_once 'src/dominio/modelo/Usuario.php';
require_once 'src/repositorio/RepositorioUsuarios.php';
require_once 'layout/cabecalho.php';

$id = $_GET['id'];

$conexao = Conexao::criarConexao();
$repositorioNoticias = new RepositorioNoticias($conexao);

$repositorioUsuarios = new RepositorioUsuarios($conexao);
if (isset($_SESSION['TOKEN'])) {
    $repositorioUsuarios->autenticarToken($_SESSION['TOKEN']);
} else {
    header('location: login.php');
}

$noticia = $repositorioNoticias->umaNoticia($id);

$categorias = $repositorioNoticias->todasAsCategorias();

?>
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') : ?>
    <?php

    $categoria = $repositorioNoticias->umaCategoria($_POST['Categoria']);
    $noticiaEditada = new Noticia($id, new Categoria($categoria->id(), $categoria->categoria()), $_POST['titulo'], $_POST['conteudo'], $noticia->dataPublicacaoPadrao());
    $noticiaSalva = $repositorioNoticias->salvarNoticia($noticiaEditada);

    ?>
    <?php if ($noticiaSalva == FALSE) : ?>
        <script>window.alert('JÁ EXIESTE ESSA NOTICIA CADASTRADA');</script>
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
    <title>Editar</title>
</head>

    <main>
        <section class="form-cadastro">
            <form action="" method="post">
                <legend>Editar notícia</legend>
                <input type="text" placeholder="Titulo" name="titulo" value="<?php echo $noticia->titulo(); ?>" required>
                <label for="categoria">Categoria</label>
                <select name="Categoria" id="" required>
                    <?php foreach ($categorias as $categoria) : ?>
                        <?php if ($categoria->id() == $noticia->categoriaId()) : ?>
                            <option selected="selected" value="<?php echo $categoria->id(); ?>"><?php echo $categoria->categoria(); ?></option>
                        <?php endif ?>
                        <option value=<?php echo $categoria->id(); ?>><?php echo $categoria->categoria(); ?></option>
                    <?php endforeach ?>
                </select>
                <textarea name="conteudo" id="" cols="50" rows="17" placeholder="Conteudo da noticia" required><?php echo $noticia->conteudo(); ?></textarea>
                <div class="botao-caixa">
                    <button type="submit">Salvar</button>
                </div>
            </form>
        </section>
    </main>
<?php require_once 'layout/footer.html'; ?>
