<?php

class Categoria
{
    private $id;
    private $categoria;

    public function __construct(?int $id, string $categoria)
    {
        $this->id = $id;
        $this->categoria = $categoria;
    }

    public function categoria(): string
    {
        return $this->categoria;
    }

    public function id(): ?string
    {
        return $this->id;
    }
}
