<?php

class PodPinkController
{
    public function show()
    {

        // Render the view with the fetched data
        return (new RenderTwig())->render('podpink', [
            
        ]);
    }
}
