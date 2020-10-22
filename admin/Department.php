<?php

class Department
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

    public function getall_department(){
        $stmt = $this->getPDO()->prepare("SELECT * FROM `department`");
        $stmt->execute();
        $departments_list = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $departments_list;
    }

    public function getdepartment_name($id){
        $stmt = $this->getPDO()->prepare("SELECT name FROM `department` WHERE id=:id");
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function pagination_department($order,$sort,$offset,$numOfrecs){
        $stmt = $this->getPDO()->prepare("SELECT * FROM `department` ORDER BY `$order` $sort LIMIT $offset,$numOfrecs");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

}

?>