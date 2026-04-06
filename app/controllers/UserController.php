<?php
class UserController
{
    private $userModel;


    public function __construct()
    {
        $this->userModel = new User();
    }
    public function showRegisterForm()
    {
        $data = [
            "title" => "Register"
        ];
        render('user/register', $data);
    }

// method to show the login form
    public function register()
    {
        
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $user = new User();
        $user->username = $_POST['username'] ?? '';
        $user->password = $_POST['password'] ?? '';
        $user->email = sanitize($_POST['email'] ?? '');

        if ($user->store()) {
            redirect('/');
        } else {
            echo "error";
        }
    }
     
    }

    public function showLoginForm()
    {
        $data = [
            "title" => "Login"
        ];
        render('user/login', $data);
    }

    public function loginUser()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            echo "Please fill all fields";
            return;
        }

        $this->userModel->email = $_POST['email'] ?? '';
        $this->userModel->password = $_POST['password'] ?? '';

        if ($this->userModel->login()) {
            $_SESSION['id'] = $this->userModel->id;
            $_SESSION['username'] = $this->userModel->username;
            $_SESSION['email'] = $this->userModel->email;
            redirect('/');
        }
        else{
            echo "Invalid credentials";
        }
        
       
    }
}
?>