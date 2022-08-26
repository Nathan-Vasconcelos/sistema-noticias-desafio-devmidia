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
        $this->usuario = $this->repositorio->buscarUsuarioPorToken($this->token);
    }

    public function somenteAdm()
    {
        //$this->usuario = $this->repositorio->buscarUsuarioPorToken($this->token);

        if ($this->usuario->idPerfil() === 1) {
            return True;
        } else {
            header('location: login.php');
        }
    }

    public function admEredator()
    {
        //$this->usuario = $this->repositorio->buscarUsuarioPorToken($this->token);

        if ($this->usuario->idPerfil() === 1 or $this->usuario->idPerfil() === 2) {
            return True;
        } else {
            header('location: login.php');
        }
    }

    public function negarAlteracaoAdm($usuarioParaAlterar)
    {
        if ($usuarioParaAlterar->idPerfil() === 1) {
            //header('location: login.php');
            return False;
        } else {
            return True;
        }
    }

    public function apenasAdmEAltor($idUsuarioNoticia)
    {
        //$this->usuario = $this->repositorio->buscarUsuarioPorToken($this->token);

        if ($this->usuario->id() === $idUsuarioNoticia or $this->usuario->idPerfil() === 1) {
            return True;
        } else {
            return False;
        }
    }

    public function negarParaRedator()
    {
        if ($this->usuario->idPerfil() === 1) {
            return True;
        } else {
            return False;
        }
    }

}
