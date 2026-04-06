<?php
class AdminController
{
    public function __construct()
    {
               AuthMiddleware::requireLogin();

    }  
    
    public function dashboard()
    {
       $data = 
    [
       "title"=> "Admin Dashboard",
        "message"=> "Welcome To Dashboard"
    ];  

        render("admin/dashboard", $data, 'layouts/admin_layout');// render view with layout
        
    }

    
}

?>