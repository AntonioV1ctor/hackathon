<?php

class CategoriaService
{
    /**
     * Lista todas as categorias disponíveis no arquivo JSON
     * @return array Lista de strings com os nomes das categorias
     */
    public static function listarCategorias()
    {
        $jsonPath = __DIR__ . '/../data/categorias.json';
        
        if (!file_exists($jsonPath)) {
            return [];
        }

        $jsonContent = file_get_contents($jsonPath);
        $data = json_decode($jsonContent, true);

        return $data['categoria'] ?? [];
    }
}
