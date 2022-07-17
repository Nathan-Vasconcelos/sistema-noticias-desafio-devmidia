<?php

require_once 'src/dominio/modelo/Noticia.php';
require_once 'src/dominio/modelo/Categoria.php';
require_once 'src/persistencia/Conexao.php';
require_once 'src/repositorio/RepositorioNoticias.php';
require_once 'layout/cabecalho.html';

$conexao = Conexao::criarConexao();
$repositorioNoticias = new RepositorioNoticias($conexao);

if (isset($_GET['busca']) and $_GET['busca'] != '') {
    //implementar validações
    $noticias = $repositorioNoticias->pesquisarNoticia($_GET['busca']);
} else {
    $noticias = $repositorioNoticias->todasAsNoticias();
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
    <title>Home page</title>
</head>

    <main>
        <?php foreach ($noticias as $noticia) : ?>
            <section class="caixa-noticia">
                <h2><?php echo $noticia->titulo(); ?></h2>
                <h3><?php echo $noticia->categoria(); ?></h3>
                <p>
                    <?php echo $noticia->conteudo(); ?>
                </p>
                <div class="botao-caixa">
                    <button><a href="noticia.php?id=<?php echo $noticia->id(); ?>" class="butao-noticia">Acessar</a></button>
                </div>
            </section>
        <?php endforeach ?>
    </main>
<?php require_once 'layout/footer.html'; ?>
