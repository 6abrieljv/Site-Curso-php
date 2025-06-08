<?php

class PodPinkController
{
    public function show()
    {

        // Render the view with the fetched data
        return (new View())->render('podpink', [
            
        ]);
    }
}
