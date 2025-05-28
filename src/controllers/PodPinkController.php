<?php

class PodPinkController
{
    public function show()
    {

        // Render the view with the fetched data
        echo (new RenderTwig())->render('podpink', [
            'title' => 'PodPink',
            
        ]);
    }
}
