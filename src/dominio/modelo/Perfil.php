<?php

class Perfil
{
    private $id;
    private $perfil;

    public function __construct(?int $id, string $perfil)
    {
        $this->id = $id;
        $this->perfil = $perfil;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function perfil(): string
    {
        return $this->perfil;
    }
}
