<?php

class ControleUsuario
{
    private string $token;
    private RepositorioUsuarios $repositorio;
    private $usuario;

    public function __construct($token, $repositorio)
    {
        $this->token = $token;
        $this->repositorio = $repositorio;
    }

    public function somenteAdm()
    {
        $this->usuario = $this->repositorio->buscarUsuarioPorToken($this->token);

        if ($this->usuario->idPerfil() === 1) {
            return True;
        } else {
            header('location: login.php');
        }
    }

    public function admEredator()
    {
        $this->usuario = $this->repositorio->buscarUsuarioPorToken($this->token);

        if ($this->usuario->idPerfil() === 1 or $this->usuario->idPerfil() === 2) {
            return True;
        } else {
            header('location: login.php');
        }
    }

}
