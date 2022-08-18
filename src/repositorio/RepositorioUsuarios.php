<?php

class RepositorioUsuarios
{
    private PDO $conexao;

    public function __construct(PDO $conexao)
    {
        $this->conexao = $conexao;
    }

    public function todosOsPerfis(): array
    {
        $sql = 'SELECT * FROM perfis;';
        $consulta = $this->conexao->query($sql);

        return $this->hidratarListaPerfis($consulta);
    }

    private function hidratarListaPerfis($consulta): array
    {
        $listaDadosPerfis = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $listaPerfis = [];

        foreach ($listaDadosPerfis as $dadosPerfil) {
            $listaPerfis[] = new \Perfil(
                $dadosPerfil['id'],
                $dadosPerfil['nome']
            );
        }

        return $listaPerfis;
    }

    public function umPerfil($id): Perfil
    {
        $sql = 'SELECT * FROM perfis WHERE id = :id;';
        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(':id', $id);
        $consulta->execute();

        $dadosPerfil = $consulta->fetch(PDO::FETCH_ASSOC);
        $perfil = new \Perfil($dadosPerfil['id'], $dadosPerfil['nome']);

        return $perfil;
    }

    public function todosOsUsuarios(): array
    {
        $sql = 'SELECT usuarios.id AS id_usuario, perfis.id AS id_perfil, perfis.nome AS perfil, usuarios.nome, usuarios.email, usuarios.senha FROM usuarios JOIN perfis ON usuarios.id_perfil = perfis.id;';
        $consulta = $this->conexao->query($sql);

        return $this->hidratarListaUsuarios($consulta);
    }

    public function contarNoticiasDosUsuarios(): array
    {
        $sql = 'SELECT noticias.id, noticias.id_usuario, usuarios.id_perfil, perfis.nome AS perfil, usuarios.nome, usuarios.email, usuarios.senha, count(noticias.id_usuario) AS noticias FROM noticias JOIN usuarios ON noticias.id_usuario = usuarios.id JOIN perfis ON usuarios.id_perfil = perfis.id GROUP BY noticias.id_usuario;';
        $consulta = $this->conexao->query($sql);

        return $this->hidratarListaUsuarios($consulta);
    }

    private function hidratarListaUsuarios($consulta): array
    {
        $listaDadosUsuarios = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $listaUsuarios = [];

        foreach ($listaDadosUsuarios as $dadosUsuario) {
            $usuario = new \Usuario(
                $dadosUsuario['id_usuario'],
                new \Perfil($dadosUsuario['id_perfil'], $dadosUsuario['perfil']),
                $dadosUsuario['nome'],
                $dadosUsuario['email'],
                $dadosUsuario['senha']
            );

            if(isset($dadosUsuario['noticias'])) {
                $usuario->definirNoticias($dadosUsuario['noticias']);
            }

            $listaUsuarios[] = $usuario;
        }

        return $listaUsuarios;
    }

    public function buscarUsuarioPorToken($token): Usuario
    {
        $sql = 'SELECT usuarios.id, perfis.id AS id_do_perfil, perfis.nome AS perfil, usuarios.nome, usuarios.email, usuarios.senha FROM usuarios JOIN perfis ON usuarios.id_perfil = perfis.id WHERE token = :token LIMIT 1;';
        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(':token', $token);
        $consulta->execute();

        $dadosUsuario = $consulta->fetch(PDO::FETCH_ASSOC);
        $usuario = new \Usuario(
            $dadosUsuario['id'],
            new \Perfil($dadosUsuario['id_do_perfil'], $dadosUsuario['perfil']),
            $dadosUsuario['nome'],
            $dadosUsuario['email'],
            $dadosUsuario['senha']
        );

        return $usuario;
    }

    public function buscarUsuarioPorId($id): Usuario
    {
        $sql = 'SELECT usuarios.id, perfis.id AS id_do_perfil, perfis.nome AS perfil, usuarios.nome, usuarios.email, usuarios.senha FROM usuarios JOIN perfis ON usuarios.id_perfil = perfis.id WHERE usuarios.id = :id LIMIT 1;';
        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(':id', $id);
        $consulta->execute();

        $dadosUsuario = $consulta->fetch(PDO::FETCH_ASSOC);
        $usuario = new \Usuario(
            $dadosUsuario['id'],
            new \Perfil($dadosUsuario['id_do_perfil'], $dadosUsuario['perfil']),
            $dadosUsuario['nome'],
            $dadosUsuario['email'],
            $dadosUsuario['senha']
        );

        return $usuario;
    }

    public function removerUsuario($id)
    {
        $sql = 'DELETE FROM usuarios WHERE id = :id;';
        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(':id', $id);

        $consulta->execute();
    }

    public function verificarEmailDoUsuario($usuarioEditado)
    {
        $sql = 'SELECT * FROM usuarios WHERE email = :email AND id != :id LIMIT 1;';
        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(':email', $usuarioEditado->email());
        $consulta->bindValue(':id', $usuarioEditado->id());
        $consulta->execute();

        $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            //se não existir esse usuário cadastrado
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function verificarEmail($novoUsuario)
    {
        //verificar se o email já está cadastrado
        $sql = 'SELECT * FROM usuarios WHERE email = :email LIMIT 1;';
        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(':email', $novoUsuario->email());
        $consulta->execute();

        $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            //se não existir esse usuário cadastrado
            return $this->cadastrarUsuario($novoUsuario);
        } else {
            return FALSE;
        }
    }

    public function editarUsuario($usuario): void
    {
        $sql = 'UPDATE usuarios SET id_perfil = :id_perfil, nome = :nome, email = :email WHERE id = :id;';
        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(':id_perfil', $usuario->idPerfil());
        $consulta->bindValue(':nome', $usuario->nome());
        $consulta->bindValue(':email', $usuario->email());
        $consulta->bindValue(':id', $usuario->id());

        $consulta->execute();
    }

    private function cadastrarUsuario($novoUsuario)
    {
        //cadastrar usuário
        $sql = 'INSERT INTO usuarios (id_perfil, nome, email, senha, token) VALUES (:id_perfil, :nome, :email, :senha, :token);';
        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(':id_perfil', $novoUsuario->idPerfil());
        $consulta->bindValue(':nome', $novoUsuario->nome());
        $consulta->bindValue(':email', $novoUsuario->email());
        $consulta->bindValue(':senha', $novoUsuario->senha());
        $consulta->bindValue(':token', $novoUsuario->token());

        $consulta->execute();
    }

    public function login($email, $senha)
    {
        $senha = sha1($senha);

        $sql = 'SELECT usuarios.id, usuarios.id_perfil, perfis.nome AS perfil, usuarios.nome, usuarios.email, usuarios.senha FROM usuarios JOIN perfis ON id_perfil = perfis.id WHERE usuarios.email = :email AND usuarios.senha = :senha LIMIT 1;';
        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(':email', $email);
        $consulta->bindValue(':senha', $senha);
        $consulta->execute();

        $dadosUsuario = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($dadosUsuario) {
            //buscou o usuario com esse email e senha
            $usuario = new \Usuario(
                $dadosUsuario['id'],
                new \Perfil($dadosUsuario['id_perfil'], $dadosUsuario['perfil']),
                $dadosUsuario['nome'],
                $dadosUsuario['email'],
                $dadosUsuario['senha']
            );

            $usuario->definirToken(sha1(uniqid().date('d-m-Y-H-i-s')));

            //$sql = 'UPDATE usuarios SET token = :token WHERE email = :email AND senha = :senha'
            return $this->atualizarToken($usuario);

        } else {
            //não tem usuario com esse email e senha
            return FALSE;
        }
    }

    private function atualizarToken(Usuario $usuario)
    {
        $sql = 'UPDATE usuarios SET token = :token WHERE email = :email AND senha = :senha LIMIT 1;';
        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(':token', $usuario->token());
        $consulta->bindValue(':email', $usuario->email());
        $consulta->bindValue(':senha', $usuario->senhaBanco());
        $consulta->execute();

        //colocar o token na sessão
        $_SESSION['TOKEN'] = $usuario->token();
    }

    public function autenticarToken($token)
    {
        $sql = 'SELECT * FROM usuarios WHERE token = :token LIMIT 1;';
        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(':token', $token);
        $consulta->execute();
        $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            header('location: login.php');
        }
    }
}
