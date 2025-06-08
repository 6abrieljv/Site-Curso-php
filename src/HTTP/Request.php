<?php

namespace App\HTTP;

class Request
{
    private $method;
    private $uri;
    private $queryParams = [];

    private $headers = [];

    private $body = [];

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';
        $this->queryParams = $_GET ?? [];
        $this->headers = getallheaders();
        $this->body = $_POST ?? [];
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getQueryParams()
    {
        return $this->queryParams;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getBody()
    {
        return $this->body;
    }

}
