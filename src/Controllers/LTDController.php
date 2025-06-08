<?php

class LTDController
{
    

    public function show()
    {
        $data = [
            'title' => 'LTD',
            'description' => 'LTD - Liga de Treinamento e Desenvolvimento',
        ];

        return (new View())->render('ltd', $data);
    }
}