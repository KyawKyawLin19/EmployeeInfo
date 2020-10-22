<?php

class User
{

    private function getPDO()
    {
        try {
            $pdo = new PDO("mysql:dbname=employee_list_db;host=localhost",'root','');
            $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e){
            die ($e->getMessage());
        }
    }
    
    public function check_login($email,$password){
        $stmt = $this->getPDO()->prepare("SELECT * FROM users WHERE email=:email");
        $stmt->bindParam(":email",$email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_OBJ);
        if ($user) {
            if ($user->email == $email && password_verify($password, $user->password)) {
                return $user;
    
            } else {
                return false;
            }
        }
    }

}

?>