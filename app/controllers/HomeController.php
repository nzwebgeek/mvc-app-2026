<?php

class HomeController
{
    // view methods
    public function index()
    {
      $database = Database::getInstance();
      $conn = $database->getConnection();

    //echo $_SESSION['id'] ?? 'Guest';
  $data = 
    [
       "title"=> "Home Page",
        "message"=> "Welcome Home"
    ];  

        render("home/index", $data, 'layouts/hero_layout');// render view with layout
        
    }

     public function about()
    {
    $data = 
    [
        "title"=> "About Page",
        "message"=> "Welcome to the About Page of our website"
    ];  

        render("home/about", $data);
       //require_once __DIR__ ."/../views/home/index.php";
    }

    
}
?>