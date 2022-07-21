<?php

class Noticia
{
    private $id;
    private $categoria;
    private $titulo;
    private $conteudo;
    private $dataPublicacao;

    public function __construct(?int $id, Categoria $categoria, string $titulo, string $conteudo, ?string $dataPublicacao)
    {
        $this->id = $id;
        $this->categoria = $categoria;
        $this->titulo = $this->limpar($titulo);
        $this->conteudo = $this->limpar($conteudo);
        $this->dataPublicacao = $dataPublicacao;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function titulo(): string
    {
        return $this->titulo;
    }

    public function conteudo(): string
    {
        return $this->conteudo;
    }

    public function dataPublicacao(): string
    {
        $dataPublicacaoFormatada = $this->dataPublicacao;
        $dataPublicacaoFormatada = date_create($dataPublicacaoFormatada);

        return date_format($dataPublicacaoFormatada, 'd/m/Y');
    }

    public function dataPublicacaoPadrao(): string
    {
        return $this->dataPublicacao;
    }

    public function categoria(): string
    {
        return $this->categoria->categoria();
    }

    public function categoriaId(): int
    {
        return $this->categoria->id();
    }

    private function limpar($noticia)
    {
        $noticia = trim($noticia);
        $noticia = htmlspecialchars($noticia);

        return $noticia;
    }
}
