<?php

//session_start();

require_once 'src/persistencia/Conexao.php';
require_once 'src/seguranca/Limpar.php';
require_once 'src/dominio/modelo/Perfil.php';
require_once 'src/dominio/modelo/Usuario.php';
require_once 'src/repositorio/RepositorioUsuarios.php';

$conexao = Conexao::criarConexao();
$repositorioUsuarios = new RepositorioUsuarios($conexao);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['email']) or empty($_POST['senha'])) {
        $erroGeral = 'Todos os campos são obrigatórios';
    } else {
        $email = Limpar::limparPost($_POST['email']);
        $senha = Limpar::limparPost($_POST['senha']);

        $erroLogin = $repositorioUsuarios->login($email, $senha);

        if ($erroLogin === FALSE) {
            $erroGeral = 'E-mail ou senha inválido';
        } else {
            header('location: index.php');
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
    <title>Login</title>
</head>
<body>
    <header class="cabecalho"><h1><img src="img/noticia.png" alt="logo" class="logo" style="padding-top: 12px; padding-bottom: 35px;"></h1></header>
    <main>
        <section class="form-login">
            <form action="" method="post">
                <h1>Login</h1>
                <?php if (isset($erroGeral)) : ?>
                    <div class="erro-geral animate__animated animate__rubberBand"><?php echo $erroGeral; ?></div>
                <?php endif ?>
                <input type="email" name="email" placeholder="Digite seu e-mail" required>
                <input type="password" name="senha" placeholder="Digite a senha" required>
                <button type="submit" class="botao-login">Fazer login</button>
            </form>
        </section>
    </main>
<?php require_once 'layout/footer.html'; ?>
