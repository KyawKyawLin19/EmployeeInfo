<?php

class Company
{

    private function getPDO()
    {
        try {
            $pdo = new PDO("mysql:dbname=employee_list_db;host=localhost",'root','');
            $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die ($e->getMessage());
        }
    }
    
    public function getall_company(){
        $stmt = $this->getPDO()->prepare("SELECT * FROM `company` ORDER BY id DESC");
        $stmt->execute();
        $companies_list = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $companies_list;
    }

    public function getcompany_name($id){
        $stmt = $this->getPDO()->prepare("SELECT name FROM `company` WHERE id=:id");
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        $company_name = $stmt->fetch(PDO::FETCH_OBJ);
        return $company_name;
    }

    public function pagination_company($order="name",$sort="ASC",$offset,$numOfrecs){
        $stmt = $this->getPDO()->prepare("SELECT * FROM `company` ORDER BY `$order` $sort LIMIT $offset,$numOfrecs");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

}

?>