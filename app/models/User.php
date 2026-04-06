<?php

    class User {
        
        private $table = 'users';
        public $id;
        public $username;
        public $first_name;
        public $last_name;
        public $password;
        public $email;
        public $organization;
        public $location;
        public $country;
        public $city;
        public $zip_code;
        public $address;
        public $created_at;
        public $updated_at;
        public $phone;
        public $gender;
        public $dateOfBirth;
        private $conn;

        public function __construct() {
            $this->conn = Database::getInstance()->getConnection();
        }

        public function store() {
            $query = "INSERT INTO {$this->table} (username, password, email) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $this->username = htmlspecialchars(strip_tags($this->username));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $hashed_password = password_hash($this->password, PASSWORD_BCRYPT);

            $stmt->bindParam(1, $this->username);
            $stmt->bindParam(2, $hashed_password);
            $stmt->bindParam(3, $this->email);


            if($stmt->execute()){
                return true;
            }
            else{
                return false;
            }

        }

       public function login(){
           $query = "SELECT * FROM {$this->table} WHERE email = :email";
           $stmt = $this->conn->prepare($query);
           
           $this->email =sanitize($this->email);
           $stmt->bindParam(':email', $this->email);
           $stmt->execute();
           $dbuser = $stmt->fetch(PDO::FETCH_OBJ);

           if($dbuser && password_verify($this->password, $dbuser->password)){
               $this->id = $dbuser->id;
               $this->username = $dbuser->username;
               return true;
           }
            return false;

       }

    }
?>