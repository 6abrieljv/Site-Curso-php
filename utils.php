<?php
function dump($value){

    echo"<pre>";
    var_dump($value);
    echo "</pre>";
}

function dd($value){
    dump($value);
    exit;
}

?>