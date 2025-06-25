<?php

namespace App\Controllers;

use App\Utils\View;
use App\Repositories\AtleticaRepository; // 1. Importa o repositório

class AtleticaController 
{
    public function index()
    {
        // 2. Instancia o repositório para buscar os dados
        $atleticaRepository = new AtleticaRepository();

        // 3. Busca todos os membros no banco, ordenados por nome
        $membros = $atleticaRepository->findAll('nome ASC'); 

        // 4. Renderiza a view 'atletica' e passa a variável 'membros' para ela
        return (new View())->render('atletica', [
            'membros' => $membros
        ]);
    }
}