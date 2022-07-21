<?php

class Categoria
{
    private $id;
    private $categoria;

    public function __construct(?int $id, string $categoria)
    {
        $this->id = $id;
        $this->categoria = $this->limpar($categoria);
    }

    public function categoria(): string
    {
        return $this->categoria;
    }

    public function id(): ?string
    {
        return $this->id;
    }

    private function limpar($categoria)
    {
        $categoria = trim($categoria);
        $categoria = stripcslashes($categoria);
        $categoria = htmlspecialchars($categoria);

        return $categoria;
    }
}
