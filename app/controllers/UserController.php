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
    public function showProfile()
    {
        $userId = $_SESSION['user_id'] ?? null;
        
        $data = [
            "title" => "Profile"
        ];
        render('admin/users/profile', $data, 'layouts/admin_layout');
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
            $_SESSION['user_id'] = $this->userModel->id;
            $_SESSION['username'] = $this->userModel->username;
            $_SESSION['email'] = $this->userModel->email;
            $_SESSION['first_name'] = $this->userModel->first_name;
            $_SESSION['last_name'] = $this->userModel->last_name;
            redirect('/dashboard');
        }
        else{
            echo "Invalid credentials";
        }
    }

    public function logout()
    {
        session_destroy();
        $_SESSION = [];

        unset($_SESSION['id']);
        unset($_SESSION['username']);
        unset($_SESSION['email']);
        redirect('/user/login');
    }
}
?>