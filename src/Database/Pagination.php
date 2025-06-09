<?php

namespace App\Database;

class Pagination
{

    private $limit;
    private $results;
    private $pages;
    private $currentPage;

    /**
     * @param int $results O número total de resultados.
     * @param int $currentPage A página atual.
     * @param int $limit O número de resultados por página.
     */
    public function __construct($results, $currentPage = 1, $limit = 10)
    {
        $this->results = (int)$results;
        $this->limit = (int)$limit;
        $this->currentPage = (is_numeric($currentPage) && $currentPage > 0) ? (int)$currentPage : 1;
        $this->calculate();
    }

    /**
     * Calcula o número total de páginas e ajusta a página atual se necessário.
     */
    private function calculate()
    {
        // Calcula o total de páginas
        $this->pages = $this->results > 0 ? ceil($this->results / $this->limit) : 1;

        // Garante que a página atual não seja maior que o total de páginas
        $this->currentPage = $this->currentPage <= $this->pages ? $this->currentPage : $this->pages;
    }

    /**
     * Retorna a cláusula LIMIT para a consulta SQL.
     * @return string
     */
    public function getLimit()
    {
        $offset = ($this->limit * ($this->currentPage - 1));
        return $offset . ',' . $this->limit;
    }

    /**
     * Retorna um array de páginas para ser usado na view.
     * @return array
     */
    public function getPages()
    {
        if ($this->pages == 1) {
            return [];
        }

        $pages = [];
        for ($i = 1; $i <= $this->pages; $i++) {
            $pages[] = [
                'page' => $i,
                'current' => $i == $this->currentPage
            ];
        }
        return $pages;
    }
}
