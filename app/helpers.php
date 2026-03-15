<?php
  
function render($view, $data = [], $layout ='layout'){
    
    extract($data); // get data from array

    ob_start(); // saves in temporary container 

    require __DIR__ .'/views/' . $view . '.php'; // render view

    $content = ob_get_clean(); // get the content of the view and clean the buffer
    
    require __DIR__ .'/views/' . $layout . '.php'; // render layout
     
}

function base_url($path=''){
    
    if(defined('BASE_URL')){

       return BASE_URL . ltrim($path,'/');
    }
    $protocol =
    (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] != "off") || $_SERVER["SERVER_PORT"] === "443" ? "https://":"http://";

    //mike.com
    $host = $_SERVER["HTTP_HOST"];

    // https or http
    $base = rtrim(dirname($_SERVER['SCRIPT_NAME']),'/');
    return $protocol . $host . $base . '/' . ltrim($path,'/');
}
/*
function base_path($path=''){
    return  realpath( __DIR__ . '/../' . '/' .ltrim($path,'/'));
}

function views_path($path = ''){
    return base_path('app/views/' . ltrim($path, '/'));

}

function redirect($path = '', $queryParams = []){
    $url = base_url($path);

    if(!empty($queryParams)){
        $url .= "?" . http_build_query($queryParams);
    }
    header("Location: ". $url);
    exit();
}*/