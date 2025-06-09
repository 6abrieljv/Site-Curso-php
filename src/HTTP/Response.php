<?php

namespace App\HTTP;

class Response
{
    // Código HTTP de resposta
    private $httpCode = 200;
    private $headers = [];
    // Tipo de retorno do conteúdo 
    private $contentType = 'text/html';

    private $content = '';

    public function __construct($code, $content, $contentType = 'text/html')
    {
        $this->httpCode = $code;
        $this->content = $content;
        $this->setContentType($contentType);

    }

    public function sendHeaders()
    {
        // Define o código de status HTTP
        http_response_code($this->httpCode);

        // Envia os cabeçalhos
        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }
    }

    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        $this->addHeader('Content-Type', $contentType);   
    }

    public function addHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }

    public function sendResponse(){
        $this->sendHeaders();
        switch ($this->contentType) {
            case 'text/html':
                echo $this->content;                            
            default:
                # code...
                break;
        }
    }
}