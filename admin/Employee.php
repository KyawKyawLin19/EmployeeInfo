<?php

class Employee
{

    private function getPDO()
    {
        try{
        
            $pdo = new PDO("mysql:dbname=employee_list_db;host=localhost",'root','');
            
            $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    
            return $pdo;

        }catch(PDOException $e){
    
            die($e->getMessage());
    
        }
    }
    

    public function getall_employee(){

        
        $stmt = $this->getPDO()->prepare("SELECT * FROM employee");

        $stmt->execute();

        $companies_list = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $companies_list;
    }

    public function get_employee($id){

        
        $stmt = $this->getPDO()->prepare("SELECT * FROM employee WHERE id=:id");

        $stmt->bindParam(":id", $id);

        $stmt->execute();

        $employee = $stmt->fetch(PDO::FETCH_OBJ);

        return $employee;
    }

    public function add_employee($data){

        $statement = $this->getPDO()->prepare("
        INSERT INTO `employee` (`name`, `email`, `age`, `company_id`, `department_id`) 
        VALUES (:name, :email, :age, :company_id, :department_id);
        ");

        $statement->bindParam(":name", $data["name"]);
        $statement->bindParam(":email", $data["email"]);
        $statement->bindParam(":age", $data["age"]);
        $statement->bindParam(":company_id", $data["company"]);
        $statement->bindParam(":department_id", $data["department"]);

        if($statement->execute()){
            return true;
        }else {
            return false;
        }
        
    }

    public function update_employee($data){

        $statement = $this->getPDO()->prepare("
        UPDATE `employee`
            SET name = :name, email = :email, age = :age, company_id = :company_id, department_id = :department_id
            WHERE id = :id
            ");

        $statement->bindParam(":id", $data["id"]);
        $statement->bindParam(":name", $data["name"]);
        $statement->bindParam(":email", $data["email"]);
        $statement->bindParam(":age", $data["age"]);
        $statement->bindParam(":company_id", $data["company"]);
        $statement->bindParam(":department_id", $data["department"]);

        if($statement->execute()){
            return true;
        }else {
            return false;
        }

    }

    public function delete_employee($id){

        $statement = $this->getPDO()->prepare("DELETE FROM employee WHERE id = :id");
        
        $statement->bindParam(":id",$id);
        
        if($statement->execute()){
            return true;
        }else {
            return false;
        }

    }

    public function pagination_employee($order,$sort,$offset,$numOfrecs){
        $stmt = $this->getPDO()->prepare("SELECT * FROM employee ORDER BY `$order` $sort LIMIT $offset,$numOfrecs");

        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $result;
    }

    public function get_depart($id){
        $stmt = $this->getPDO()->prepare("SELECT COUNT(id) FROM employee WHERE department_id=:id");

        $stmt->bindParam(":id", $id);

        $stmt->execute();
        
        $employee = $stmt->fetch();

        return $employee[0];
    }

    public function get_com($id){
        $stmt = $this->getPDO()->prepare("SELECT COUNT(id) FROM employee WHERE company_id=:id");

        $stmt->bindParam(":id", $id);

        $stmt->execute();
        
        $employee = $stmt->fetch();

        return $employee[0];
    }

    public function check_email($email){
        $statement = $this->getPDO()->prepare("SELECT * FROM `employee` WHERE email=:email");
        $statement->bindParam(':email',$email);
        $statement->execute();
        $result = $statement->fetch();
        return $result;
    }

}

?>