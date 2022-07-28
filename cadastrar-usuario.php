<?php

require_once 'src/persistencia/Conexao.php';
require_once 'src/seguranca/Limpar.php';
require_once 'src/dominio/modelo/Perfil.php';
require_once 'src/dominio/modelo/Usuario.php';
require_once 'src/repositorio/RepositorioUsuarios.php';
require_once 'layout/cabecalho.html';

$conexao = Conexao::criarConexao();
$repositorioUsuarios = new RepositorioUsuarios($conexao);
$perfis = $repositorioUsuarios->todosOsPerfis();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['nome']) or empty($_POST['email']) or empty($_POST['senha'])) {
        $erroGeral = 'Todos os campos são obrigatórios';
    } else {
        $nome = Limpar::limparPost($_POST['nome']);
        $email = Limpar::limparPost($_POST['email']);
        $senha = Limpar::limparPost($_POST['senha']);

        $perfilUsuario = $repositorioUsuarios->umPerfil($_POST['perfil']);

        $usuario = new Usuario(null, $perfilUsuario, $nome, $email, $senha);
        $usuario->validarCadastro();

        if (empty($usuario->erro)) {
            //verificar se o usuário existe para cadastra-lo
            $erroAoCadastrar = $repositorioUsuarios->verificarEmail($usuario);

            if ($erroAoCadastrar === FALSE) {
                $erroGeral = 'Usuário já cadastrado';
            } else {
                header('location: index.php');
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
    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Noto+Sans&display=swap" rel="stylesheet">
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
    <title>Cadastrar usuário</title>
</head>

    <main>
        <section class="form-login">
            <form action="" method="post">
                <h1>Cadastrar usuário</h1>
                <?php if (isset($erroGeral)) : ?>
                    <div class="erro-geral animate__animated animate__rubberBand"><?php echo $erroGeral; ?></div>
                <?php endif ?>
                <input type="text" name="nome" placeholder="Digite seu nome" <?php if (isset($_POST['nome'])) : ?> value="<?php echo $_POST['nome'] ?>" <?php endif ?> required>
                <input type="email" name="email" placeholder="Digite seu e-mail" <?php if (isset($_POST['email'])) : ?> value="<?php echo $_POST['email'] ?>" <?php endif ?> required>
                <?php if (isset($usuario->erro['erro_email'])) : ?>
                    <div class="erro"><?php echo $usuario->erro['erro_email']; ?></div>
                <?php endif ?>
                <input type="password" name="senha" placeholder="Digite a senha" <?php if (isset($_POST['senha'])) : ?> value="<?php echo $_POST['senha'] ?>" <?php endif ?> required>
                <?php if (isset($usuario->erro['erro_senha'])) : ?>
                    <div class="erro"><?php echo $usuario->erro['erro_senha']; ?></div>
                <?php endif ?>
                <label for="perfil">Perfil do usuário</label>
                <select name="perfil" id="perfil">
                    <?php foreach ($perfis as $perfil) : ?>
                        <option value="<?php echo $perfil->id(); ?>"><?php echo $perfil->perfil(); ?></option>
                    <?php endforeach ?>
                </select>
                <button type="submit" class="botao-login">Cadastrar</button>
            </form>
        </section>
    </main>
<?php require_once 'layout/footer.html'; ?>
