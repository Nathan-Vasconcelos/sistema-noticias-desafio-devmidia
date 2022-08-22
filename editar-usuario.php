<?php

require_once 'src/persistencia/Conexao.php';
require_once 'src/seguranca/Limpar.php';
require_once 'src/dominio/modelo/Perfil.php';
require_once 'src/dominio/modelo/Usuario.php';
require_once 'src/repositorio/RepositorioUsuarios.php';
require_once 'src/controleUsuario/ControleUsuario.php';
require_once 'layout/menu-mobile.php';
require_once 'layout/cabecalho.php';

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

$perfis = $repositorioUsuarios->todosOsPerfis();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['nome']) or empty($_POST['email'])) {
        $erroGeral = 'Todos os campos são obrigatórios';
    } else {
        $nome = Limpar::limparPost($_POST['nome']);
        $email = Limpar::limparPost($_POST['email']);

        $perfilUsuario = $repositorioUsuarios->umPerfil($_POST['perfil']);

        $usuarioEditado = new Usuario($usuario->id(), $perfilUsuario, $nome, $email, $usuario->senha());
        $usuarioEditado->validarEmail();

        if (empty($usuarioEditado->erro)) {
            $emailValido = $repositorioUsuarios->verificarEmailDoUsuario($usuarioEditado);

            if ($emailValido === FALSE) {
                $erroGeral = 'Já existe um usuário com esse e-mail';
            } else {
                $repositorioUsuarios->editarUsuario($usuarioEditado);
                header('location: usuarios.php');
            }
            
        }
    }
}

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
    <title>Editar Usuário</title>
</head>
<!--<body>
    <header class="cabecalho"><h1><img src="https://imgs.search.brave.com/75uk1O7iw7k1WkwUlrEVxhB7Dv5jooCt2Rc9-F2XZu8/rs:fit:1200:419:1/g:ce/aHR0cDovL3d3dy5k/ZXZtZWRpYS5jb20u/YnIvam9pbi9pbWFn/ZXMvbG9nby1kZXZt/ZWRpYS5wbmc" alt="logo" class="logo"></h1><a href="categorias.html">CATEGORIAS</a> <a href="cadastrar-categoria.html">CADASTRAR CATEGORIA</a> <a href="cadastrar.html">CADASTRAR NOTICIAS</a> <a href="index.html">EXIBIR NOTICIAS</a> <form action=""><input type="search"><button type="submit" class="botao-busca"><img src="Desenho-Lupa-PNG.png" alt=""></button></form></header>-->
    <main>
        <section class="form-cadastro">
            <form action="" method="post">
                <legend>Editar Usuário</legend>
                <?php if (isset($erroGeral)) : ?>
                    <div class="erro-geral animate__animated animate__rubberBand"><?php echo $erroGeral; ?></div>
                <?php endif ?>
                <input type="text" name="nome" value="<?php echo $usuario->nome(); ?>" placeholder="Nome" required>
                <input type="email" name="email" value="<?php echo $usuario->email(); ?>" placeholder="E-mail" required>
                <?php if (isset($usuario->erro['erro_email'])) : ?>
                    <div class="erro"><?php echo $usuarioEditado->erro['erro_email']; ?></div>
                <?php endif ?>
                <label for="perfil">Perfil</label>
                <select name="perfil" id="" required>
                    <?php foreach ($perfis as $perfil) : ?>
                        <?php if ($perfil->id() == $usuario->idPerfil()) : ?>
                            <option selected="selected" value="<?php echo $perfil->id(); ?>"><?php echo $perfil->perfil(); ?></option>
                        <?php endif ?>
                        <?php if ($perfil->id() != $usuario->idPerfil()) : ?>
                            <option value="<?php echo $perfil->id(); ?>"><?php echo $perfil->perfil(); ?></option>
                        <?php endif ?>
                    <!--<option value="teste">adm</option>
                    <option value="tecnologia">redator</option>-->
                    <?php endforeach ?>
                </select>
                
                <div class="botao-caixa">
                    <button type="submit">Salvar</button>
                </div>
            </form>
        </section>
    </main>
<?php require_once 'layout/footer.html'; ?>
