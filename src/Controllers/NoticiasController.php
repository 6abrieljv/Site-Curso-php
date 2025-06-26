<?php
namespace App\Controllers;

use App\Utils\View;
use App\Repositories\NoticiaRepository;
use App\Database\Pagination; // <-- Importar a classe
use App\HTTP\Request; // <-- Importar a classe Request

class NoticiasController
{
    public function index(Request $request) // <-- Recebe o objeto Request
    {
        $noticiasRepository = new NoticiaRepository();

        // 1. Obter a página atual dos parâmetros da query
        $queryParams = $request->getQueryParams();
        $currentPage = $queryParams['page'] ?? 1;

        // 2. Contar o total de notícias
        $totalNoticias = $noticiasRepository->count();

        // 3. Configurar a paginação
        $pagination = new Pagination($totalNoticias, $currentPage, 7); // 5 notícias por página

        // 4. Buscar apenas as notícias da página atual
        $noticias = $noticiasRepository->findAll('data_publicacao DESC', $pagination->getLimit());

        // 5. Passar os dados para a view
        $data = [
            'noticias' => $noticias,
            'pagination' => $pagination->getPages(), // Envia os botões da paginação
            'currentPage' => $currentPage
        ];
        
        return (new View())->render('noticias', $data);
    }

    public function show($request, $params)
    {
        $noticiasRepository = new NoticiaRepository();
        $noticia = $noticiasRepository->findBySlug($params['slug']);

        if (!$noticia) {
            // Idealmente, redirecionar para uma página de erro 404
            return (new View())->render('error', ['code' => 404, 'message' => 'Notícia não encontrada']);
        }

        $data = [
            'noticia' => $noticia
        ];

        return (new View())->render('noticia', $data);
    }

}