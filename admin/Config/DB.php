<?php

    class DB{

        public $pdo;

        public function connect(){

            try{
        
                $pdo = new PDO("mysql:dbname=employee_list_db;host=localhost",'root','');
                
                $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        
                return $pdo;

            }catch(PDOException $e){
        
                die($e->getMessage());
        
            }
        }
    }

?>