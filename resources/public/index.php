<?php require_once __DIR__ . '/../app/init.php'; ?>
<?php require_once __DIR__ . '/../routes/web.php'; ?> 
<?php require_once __DIR__ . '/../app/controllers/HomeController.php'; ?> 

<?php


//$request = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$method = $_SERVER['REQUEST_METHOD'];

if (isset($routes[$method][$request])) {
    //echo''. $routes[$method][$request] .' OK';
    list($controller, $action) = explode('@', $routes[$method][$request]);
    //var_dump($controller, $action);
    require_once __DIR__ .'/../app/controllers/' . $controller . '.php';

    $controllerInstance = new $controller();
    
    $controllerInstance->$action();

}
else{
    http_response_code(404);
    echo '404 Not Found';   
}
/*else{
    echo 'not';
}*/


//list($controller, $action) = explode('@', $routes[$method][$request]);

/*if (array_key_exists($request, $routes)) {

    $route = explode('@', $routes[$request]);
    $controllerName = $route[0];
    $methodName = $route[1];
    $controller = new $controllerName();
    $controller->$methodName();

    $controller = new HomeController();
   // $controller->index();

    //echo 'Exists';
   
}
else{
    echo '404';
}*/
?>