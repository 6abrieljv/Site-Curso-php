<?php
namespace App\Controllers;
use App\Utils\View;

class ErrorController{

    private $view;

public function __construct()
{
$this->view = new View();

}

    public function index()
    {
        return $this->renderError();
}
    public function renderError($params = [])
    {
        return $this->view->render('error', [
            'title' => 'Error',
            'message' => $params['message'] ?? 'An error occurred',
            'code' => $params['code'] ?? 500,
        ]);
    }
}
