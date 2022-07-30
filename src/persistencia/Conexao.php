<?php

session_start();
class Conexao
{
    public static function criarConexao(): PDO
    {
        return new PDO('mysql:host=localhost;dbname=dbnoticias', 'root', '');
    }
}
