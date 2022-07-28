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
}
