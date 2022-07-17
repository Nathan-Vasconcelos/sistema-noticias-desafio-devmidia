<?php

require_once 'src/dominio/modelo/Noticia.php';
require_once 'src/dominio/modelo/Categoria.php';
require_once 'src/persistencia/Conexao.php';
require_once 'src/repositorio/RepositorioNoticias.php';
require_once 'layout/cabecalho.html';

$conexao = Conexao::criarConexao();
$repositorioNoticias = new RepositorioNoticias($conexao);

if (isset($_GET['busca']) and $_GET['busca'] != '') {
    $categorias = $repositorioNoticias->pesquisarCategoria($_GET['busca']);
} else {
    $categorias = $repositorioNoticias->todasAsCategorias();
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
    <title>Categorias</title>
</head>

    <main>
        <?php foreach ($categorias as $categoria) : ?>
            <section class="caixa-categoria">
                <h2><?php echo $categoria->categoria(); ?></h2>
                <div class="botao-editar">
                    <button><a href="editar-categoria.php?id=<?php echo $categoria->id(); ?>">Editar</a></button>
                </div>
                <div class="botao-editar">
                    <button><a href="excluir-categoria.php?id=<?php echo $categoria->id(); ?>">Excluir</a></button>
                </div>
            </section>
        <?php endforeach ?>
    </main>
<?php require_once 'layout/footer.html'; ?>
