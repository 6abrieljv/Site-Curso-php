<?php

namespace App\Controllers;

use App\Utils\View;
use App\Repositories\AtleticaRepository;
use App\Database\Pagination; // <-- 1. Importe a classe de Paginação
use App\HTTP\Request;       // <-- 2. Importe a classe de Request

class AtleticaController 
{
    // 3. Adicione o Request como parâmetro do método index
    public function index(Request $request) 
    {
        $atleticaRepository = new AtleticaRepository();

        // 4. Lógica de paginação (igual à de Educadores)
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        // Conta o total de membros para saber quantas páginas teremos
        $totalMembros = $atleticaRepository->count();

        // Instancia o objeto de paginação (ex: 6 membros por página)
        $paginacao = new Pagination($totalMembros, $paginaAtual, 3); 

        // Busca no repositório apenas os membros da página correta
        $membros = $atleticaRepository->findAll('id ASC', $paginacao->getLimit()); 

        // 5. Renderiza a view e passa os membros e os dados da paginação
        return (new View())->render('atletica', [
            'membros' => $membros,
            'pagination' => $paginacao->getPages()
        ]);
    }
}