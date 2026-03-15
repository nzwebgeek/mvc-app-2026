<?php

class HomeController
{
    
    // view methods
    public function index()
    {
        // what ever you want to do before loading the view
    $data = 
    [
        "title"=> "Home Page",
        "message"=> "Welcome Home"
    ];  

        return render("home/index", $data);
       //require_once __DIR__ ."/../views/home/index.php";
    }

     public function about()
    {
    $data = 
    [
        "title"=> "About Page",
        "message"=> "Welcome to the About Page of our website"
    ];  

        return render("home/about", $data);
       //require_once __DIR__ ."/../views/home/index.php";
    }

    public function testing()
    {
       
    }

}
?>