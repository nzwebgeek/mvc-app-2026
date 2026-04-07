<?php

    class User {
        
        private $table = 'users';

        private $uploadDir = 'uploads/users';

        public $profile_image;
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

        public function getUserById($userId) {
            $query = "SELECT * FROM {$this->table} WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            //return $stmt->fetch(PDO::FETCH_OBJ);
            return $stmt->fetchObject();
        }

        public function update($userId, $data) {
            $fields = [];
            foreach ($data as $key => $value) {
                $fields[] = "$key = :$key"; // Prepare field assignments for the SQL query
            }
            $query = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = :id";
           
            $stmt = $this->conn->prepare($query);
           
            $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
          
            foreach ($data as $key => $value) {

                if($value === ''){
                $stmt->bindValue(":$key", null, PDO::PARAM_NULL);

                }
                else{
                $stmt->bindValue(":$key", $value);
                }
            }

            return $stmt->execute();
        }

        public function handleImageUpload($file) {

       $maxSize = 5 * 1024 * 1024; // 5MB
       $tempLocation = $file['tmp_name'];

       if($file['size'] > $maxSize) {
           $_SESSION['error'] = "File size exceeds the maximum limit of 5MB.";
           return false;
       }

       $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);

       $filename = uniqid('user_', true) . '.' . $fileExtension;

       if(!file_exists($this->uploadDir)) {
           mkdir($this->uploadDir, 0755, true);
       }

       $filePath = $this->uploadDir . '/' . $filename;
     
       $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    // Validate file type to prevent malicious uploads  
        if (!in_array(strtolower($fileExtension), $allowedTypes)) {
            $_SESSION['error'] = "Invalid file type.";
            return false;
        }


       if(move_uploaded_file($tempLocation, $filePath)) {
           return $filePath;
       }
       else {
           $_SESSION['error'] = "Failed to move uploaded file.";
           return false;
       }

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