<?php

require_once 'src/dominio/modelo/Noticia.php';
require_once 'src/dominio/modelo/Categoria.php';
require_once 'src/persistencia/Conexao.php';
require_once 'src/repositorio/RepositorioNoticias.php';
require_once 'layout/cabecalho.php';

$conexao = Conexao::criarConexao();
$repositorioNoticias = new RepositorioNoticias($conexao);

$id = $_GET['id'];

$noticia = $repositorioNoticias->umaNoticia($id);

?>
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
    <title>Noticia</title>
</head>

    <main>
        <section class="conteudo-completo">
                <h2><?php echo $noticia->titulo(); ?></h2>
                <h3><?php echo $noticia->categoria(); ?></h3>
                    <p>
                        <?php echo nl2br($noticia->conteudo()); ?>
                   </p>
                   <br>
                   <p>
                    Data: <?php echo $noticia->dataPublicacao(); ?>
                   </p>
                <?php if (isset($_SESSION['TOKEN'])) : ?>
                    <div class="botao-editar">
                        <button><a href="editar.php?id=<?php  echo $noticia->id(); ?>">Editar</a></button>
                    </div>
                    <div class="botao-editar">
                        <button><a href="excluir.php?id=<?php  echo $noticia->id(); ?>">Excluir</a></button>
                    </div>
                <?php endif ?>
        </section>
    </main>
<?php require_once 'layout/footer.html'; ?>
