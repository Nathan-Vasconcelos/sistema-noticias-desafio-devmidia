<?php

class Usuario
{
    private $id;
    private $perfil;
    private $nome;
    private $email;
    private $senha;
    private $token;
    public $erro;

    public function __construct(?int $id, Perfil $perfil, string $nome, string $email, string $senha)
    {
        $this->id = $id;
        $this->perfil = $perfil;
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
        $this->token = "";
        $this->erro = [];
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function idPerfil()
    {
        return $this->perfil->id();
    }

    public function nome(): string
    {
        return $this->nome;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function senha(): string
    {
        return sha1($this->senha);
    }

    public function token()
    {
        return $this->token;
    }

    public function validarCadastro(): void
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->erro['erro_email'] = 'E-mail inválido!';
        }

        if (strlen($this->senha) < 6) {
            $this->erro['erro_senha'] = 'A senha deve ter no mínimo 6 dígitos!';
        }
    }
}
