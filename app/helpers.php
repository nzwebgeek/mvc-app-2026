<?php
  // BASE URL
function render($view, $data = [], $layout ='layout'){
    
    extract($data); // get data from array

    ob_start(); // saves in temporary container 

    require views_path($view . '.php'); // load the view
    $content = ob_get_clean(); // get the content of the view and clean the buffer
    require views_path($layout . ".php"); // load the layout
     
}

function base_url($path = ''){

    if(defined('BASE_URL')){

       return BASE_URL . ltrim($path, '/');
    }
    $protocol =
    (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != "off") || $_SERVER['SERVER_PORT'] === 443 ? "https://":"http://";

    //mike.com/blog/index.php
    $host = $_SERVER['HTTP_HOST'];

    // https or http + host + /blog/index.php
    $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
    return $protocol . $host . $base . '/' . ltrim($path, '/');
}

function base_path($path = ''){
    return  realpath( __DIR__ . '/../' . '/' .ltrim($path,'/'));
}

function views_path($path = ''){
    return base_path('app/views/' . ltrim($path, '/'));

}

function redirect($path = '', $queryParams = []){

    $url = base_url($path);

    if(!empty($queryParams)){

        $url .= "?" . http_build_query($queryParams); // formats the query parameters as a URL-encoded string
    }

    header("Location: " . $url);

    exit();
}

function config($key){
    $config = require base_path('config/config.php');

    $keys = explode('.', $key);
    $value = $config;

    foreach($keys as $segment){
        if(!isset($value[$segment])){
            throw new Exception('Config key not found: ' . $segment);
        }
        $value = $value[$segment];
    }

    return $value;
}

function sanitize($dirty){
    return htmlspecialchars(strip_tags($dirty ?? ''));
}

function isLoggedIn(){
    return isset($_SESSION['id']);
}