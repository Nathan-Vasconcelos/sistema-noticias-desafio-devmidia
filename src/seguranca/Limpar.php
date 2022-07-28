<?php

class Limpar
{
    public static function limparPost($dado)
    {
        $dado = trim($dado);
        $dado = htmlspecialchars($dado);

        return $dado;
    }
}
