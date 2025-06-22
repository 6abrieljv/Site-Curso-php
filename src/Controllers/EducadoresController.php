<?php
namespace App\Controllers;
use App\Utils\View;
use App\Repositories\EducadorRepository;
use App\Database\Pagination; // Importar a classe de paginação
use App\HTTP\Request; // Importar a classe Request

class EducadoresController
{
    private $educadorRepository;

    public function __construct()
    {
        $this->educadorRepository = new EducadorRepository();
    }

    public function index (Request $request){ // Adicionar Request como parâmetro
        $queryParams = $request->getQueryParams();
        $currentPage = $queryParams['page'] ?? 1; // Obter a página atual da URL

        $totalEducadores = $this->educadorRepository->count(); // Contar o total de educadores
        $pagination = new Pagination($totalEducadores, $currentPage, 4); // 5 educadores por página (você pode ajustar)

        // Buscar apenas os educadores da página atual
        $educadores = $this->educadorRepository->findAll('u.id DESC', $pagination->getLimit());

        $data = [
            'title' => 'Educadores',
            'description' => 'Educadores - Laboratório de Transformação Digital',
            'educadores' => $educadores, // Passar os educadores paginados
            'pagination' => $pagination->getPages() // Passar os dados da paginação para a view
        ];

        return (new View())->render('educadores', $data);
    }
}