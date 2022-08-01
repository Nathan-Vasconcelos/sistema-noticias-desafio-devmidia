<?php

class RepositorioNoticias
{
    private PDO $conexao;

    public function __construct(PDO $conexao)
    {
        $this->conexao = $conexao;
    }

    public function todasAsNoticias(): array
    {
        $sql = 'SELECT noticias.id, categorias.id AS id_da_categoria, categorias.nome AS categoria, noticias.titulo, noticias.conteudo, noticias.data_publicacao
        FROM noticias JOIN categorias ON noticias.id_categoria = categorias.id ORDER BY noticias.data_publicacao DESC;';
        
        $consulta = $this->conexao->query($sql);

        return $this->hidratarListaNoticias($consulta);
    }

    public function umaNoticia($id): Noticia
    {
        $sql = "SELECT noticias.id, categorias.id AS id_da_categoria, categorias.nome AS categoria, noticias.titulo, noticias.conteudo, noticias.data_publicacao
        FROM noticias JOIN categorias ON noticias.id_categoria = categorias.id WHERE noticias.id = :id;";

        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(':id', $id);
        $consulta->execute();

        $dadosNoticia = $consulta->fetch(PDO::FETCH_ASSOC);
        $noticia = new \Noticia(
            $dadosNoticia['id'],
            new \Categoria($dadosNoticia['id_da_categoria'], $dadosNoticia['categoria']),
            $dadosNoticia['titulo'],
            $dadosNoticia['conteudo'],
            $dadosNoticia['data_publicacao']
        );

        return $noticia;
    }

    private function hidratarListaNoticias($consulta): array
    {
        //instanciar classe
        $listaDadosNoticias = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $listaNoticias = [];

        foreach ($listaDadosNoticias as $dadosNoticia) {
            $listaNoticias[] = new \Noticia(
                $dadosNoticia['id'],
                new \Categoria($dadosNoticia['id_da_categoria'], $dadosNoticia['categoria']),
                $dadosNoticia['titulo'],
                $dadosNoticia['conteudo'],
                $dadosNoticia['data_publicacao']
            );
        }

        return $listaNoticias;
    }

    public function pesquisarNoticia($palavra): array
    {
        $palavra = '%' . $palavra . '%';

        $sql = "SELECT noticias.id, categorias.id AS id_da_categoria, categorias.nome AS categoria, noticias.titulo, noticias.conteudo, noticias.data_publicacao
        FROM noticias JOIN categorias ON noticias.id_categoria = categorias.id WHERE noticias.titulo LIKE :palavra OR  categorias.nome LIKE :palavra ORDER BY noticias.data_publicacao DESC;";

        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(':palavra', $palavra);
        $consulta->bindValue(':palavra', $palavra);

        $consulta->execute();

        return $this->hidratarListaNoticias($consulta);
    }

    public function salvarNoticia(Noticia $noticia)
    {
        if ($noticia->id() == null) {
            //create
            return $this->validarNoticia($noticia);
        } else {
            //update
            return $this->atualizarNoticia($noticia);
        }
    }

    private function validarNoticia(Noticia $noticia)
    {
        $listaNoticias = $this->todasAsNoticias();

        foreach ($listaNoticias as $umaNoticia) {
            if (mb_strtoupper($umaNoticia->titulo()) == mb_strtoupper($noticia->titulo()) or mb_strtoupper($umaNoticia->conteudo()) == mb_strtoupper($noticia->conteudo())) {
                return FALSE;
            }
        }

        $this->cadastrarNoticia($noticia);
    }

    private function cadastrarNoticia(Noticia $noticia)
    {
        $sql = "INSERT INTO noticias (id_categoria, titulo, conteudo, data_publicacao) VALUES
        (:id_categoria, :titulo, :conteudo, :data_publicacao);";

        $consulta = $this->conexao->prepare($sql);

        $consulta->bindValue(':id_categoria', $noticia->categoriaId());
        $consulta->bindValue(':titulo', $noticia->titulo());
        $consulta->bindValue(':conteudo', $noticia->conteudo());
        $consulta->bindValue(':data_publicacao', $noticia->dataPublicacaoPadrao());
        $consulta->execute();

        return TRUE;
    }

    private function atualizarNoticia(Noticia $noticia)
    {
        $listaNoticias = $this->todasAsNoticias();

        foreach ($listaNoticias as $umaNoticia) {
            if (mb_strtoupper($umaNoticia->titulo()) == mb_strtoupper($noticia->titulo()) and mb_strtoupper($umaNoticia->conteudo()) == mb_strtoupper($noticia->conteudo())) {
                return FALSE;
            }
        }

        $sql = "UPDATE noticias SET id_categoria = :id_categoria, titulo = :titulo, conteudo = :conteudo WHERE id = :id;";
        $consulta = $this->conexao->prepare($sql);

        $consulta->bindValue(':id_categoria', $noticia->categoriaId());
        $consulta->bindValue(':titulo', $noticia->titulo());
        $consulta->bindValue(':conteudo', $noticia->conteudo());
        $consulta->bindValue(':id', $noticia->id());

        return $consulta->execute() ? true : false;
    }

    public function removeNoticia($id)
    {
        $sql = 'DELETE FROM noticias WHERE id = :id;';
        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(':id', $id);

        return $consulta->execute() ? true : false;
    }

    public function todasAsCategorias(): array
    {
        $sql = 'SELECT * FROM categorias;';
        $consulta = $this->conexao->query($sql);

        return $this->hidratarListaCategorias($consulta);
    }

    public function umaCategoria($id): Categoria
    {
        $sql = 'SELECT * FROM categorias WHERE id = :id;';
        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(':id', $id);
        $consulta->execute();

        $dadosCategoria = $consulta->fetch(PDO::FETCH_ASSOC);
        $categoria = new \Categoria($dadosCategoria['id'], $dadosCategoria['nome']);

        return $categoria;
    }

    public function pesquisarCategoria($palavra): array
    {
        $palavra = '%' . $palavra . '%';

        $sql = 'SELECT * FROM categorias WHERE nome LIKE :palavra;';
        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(':palavra', $palavra);
        $consulta->execute();

        return $this->hidratarListaCategorias($consulta);
    }

    private function hidratarListaCategorias($consulta): array
    {
        $listaDadosCategorias = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $listaCategorias = [];

        foreach ($listaDadosCategorias as $dadosCategoria) {
            $listaCategorias[] = new \Categoria($dadosCategoria['id'], $dadosCategoria['nome']);
        }

        return $listaCategorias;
    }

    public function salvarCategoria(Categoria $categoria)
    {
        if ($categoria->id() == null) {
            return $this->validarCategoria($categoria);
        } else {
            return $this->atualizarCategoria($categoria);
        }
    }

    private function validarCategoria(Categoria $categoria)
    {
        $listaCategorias = $this->todasAsCategorias();

        foreach ($listaCategorias as $umaCategoria) {
            if (mb_strtoupper($umaCategoria->categoria()) == mb_strtoupper($categoria->categoria())) {
                return FALSE;
            }
        }

        return $this->cadastrarCategoria($categoria);
    }

    private function cadastrarCategoria(Categoria $categoria): bool
    {
        $sql = "INSERT INTO categorias (nome) VALUES (:nome);";
        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(':nome', $categoria->categoria());
        $consulta->execute();
        
        return TRUE;
    }

    private function atualizarCategoria(Categoria $categoria)
    {
        $listaCategorias = $this->todasAsCategorias();

        foreach ($listaCategorias as $umaCategoria) {
            if (mb_strtoupper($umaCategoria->categoria()) == mb_strtoupper($categoria->categoria())) {
                return FALSE;
            }
        }

        $sql = "UPDATE categorias SET nome = :nome WHERE id = :id;";
        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(':nome', $categoria->categoria());
        $consulta->bindValue(':id', $categoria->id());
        $consulta->execute();

        return TRUE;
    }

    public function removeCategoria($id)
    {
        $sql = 'DELETE FROM categorias WHERE id = :id;';
        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(':id', $id);
        //$consulta->execute();

        return $consulta->execute() ? true : false;
    }
}
